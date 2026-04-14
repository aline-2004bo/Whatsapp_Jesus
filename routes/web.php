<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\CustomLoginController;

Route::get('/', function () {
    return redirect('/login');
});

// LOGIN
Route::get('/login', [CustomLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomLoginController::class, 'login']);
Route::post('/logout', [CustomLoginController::class, 'logout'])->name('logout');

// REGISTRO
Route::get('/register', [CustomLoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [CustomLoginController::class, 'register'])->name('register.store');

// RECUPERAR CONTRASEÑA
Route::get('/password/request', [CustomLoginController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/email', [CustomLoginController::class, 'sendNewPassword'])->name('password.email');

// WEBAUTHN - Login biométrico (rutas públicas, sin auth)
Route::post('/webauthn/auth', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'Usuario no encontrado.'], 404);
    }

    try {
        // Construir solo los campos que el paquete espera
        $data = [
            'id'       => $request->input('id'),
            'type'     => $request->input('type'),
            'rawId'    => $request->input('rawId'),
            'response' => $request->input('response'),
        ];

        \LaravelWebauthn\Facades\Webauthn::validateAssertion($user, $data);
        \Illuminate\Support\Facades\Auth::login($user, true);

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('WebAuthn login error: ' . $e->getMessage());
        return response()->json(['message' => 'Verificación biométrica fallida: ' . $e->getMessage()], 422);
    }
});

Route::post('/webauthn/auth/options', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'Usuario no encontrado.'], 404);
    }

    $count = \Illuminate\Support\Facades\DB::table('webauthn_keys')
        ->where('user_id', $user->id)->count();

    if ($count === 0) {
        return response()->json(['message' => 'Este usuario no tiene biometría registrada.'], 422);
    }

    try {
        // Probar los nombres posibles según la versión del paquete
        $webauthn = app(\LaravelWebauthn\Services\Webauthn::class);

        if (method_exists($webauthn, 'getAuthenticateData')) {
            $options = $webauthn->getAuthenticateData($user);
        } elseif (method_exists($webauthn, 'prepareAssertion')) {
            $options = $webauthn->prepareAssertion($user);
        } elseif (method_exists($webauthn, 'generateAuthenticateRequest')) {
            $options = $webauthn->generateAuthenticateRequest($user);
        } elseif (method_exists($webauthn, 'assertionObjectFor')) {
            $options = $webauthn->assertionObjectFor($user->getAuthIdentifier());
        } else {
            // Listar métodos disponibles para debug
            $methods = get_class_methods($webauthn);
            \Illuminate\Support\Facades\Log::info('Webauthn methods: ', $methods);
            return response()->json([
                'message' => 'Método no encontrado. Ver log para métodos disponibles.',
                'methods' => $methods
            ], 500);
        }

        return response()->json($options);

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('WebAuthn options error: ' . $e->getMessage());
        return response()->json(['message' => $e->getMessage()], 500);
    }
});

// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    // SEGURIDAD (BIOMETRÍA)
    Route::get('/seguridad', function () {
        return view('seguridad');
    })->name('seguridad');

    // WEBAUTHN - listar llaves del usuario
    Route::get('/webauthn/keys', function () {
        try {
            $user = auth()->user();

            if (method_exists($user, 'webauthnKeys')) {
                $keys = $user->webauthnKeys()->latest()->get(['id', 'name', 'created_at']);
            } elseif (method_exists($user, 'webAuthnKeys')) {
                $keys = $user->webAuthnKeys()->latest()->get(['id', 'name', 'created_at']);
            } elseif (method_exists($user, 'passkeys')) {
                $keys = $user->passkeys()->latest()->get(['id', 'name', 'created_at']);
            } else {
                $keys = \Illuminate\Support\Facades\DB::table('webauthn_keys')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->get(['id', 'name', 'created_at']);
            }

            return response()->json($keys);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('WebAuthn keys error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });

    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/messages/{id}', [ChatController::class, 'messages']);
    Route::post('/send', [ChatController::class, 'send']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/groups/create', [ChatController::class, 'createGroup']);
    Route::delete('/groups/{id}', [ChatController::class, 'deleteGroup']);
});