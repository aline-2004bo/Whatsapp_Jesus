<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomLoginController extends Controller
{
    // -------------------------------
    // Mostrar formulario de registro
    // -------------------------------
    public function showRegisterForm()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    // -------------------------------
    // Registrar usuario nuevo
    // -------------------------------
    public function register(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        // Genera contraseña aleatoria de 8 caracteres
        $password = substr(bin2hex(random_bytes(4)), 0, 8);

        // Crear usuario
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($password),
        ]);

        // Enviar correo con la contraseña
        Mail::raw("Tu usuario ha sido creado. Tu contraseña es: $password", function($message) use ($user) {
            $message->to($user->email)
                    ->subject('Registro de usuario');
        });

        return redirect()->route('login')->with('status', "Usuario creado correctamente. La contraseña fue enviada a su correo.");
    }

    // -------------------------------
    // Mostrar formulario "Olvidé mi contraseña"
    // -------------------------------
    public function showForgotForm()
    {
        return view('auth.forgot-password'); // resources/views/auth/forgot-password.blade.php
    }

    // -------------------------------
    // Enviar nueva contraseña
    // -------------------------------
    public function sendNewPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Genera nueva contraseña aleatoria
        $newPassword = substr(bin2hex(random_bytes(4)), 0, 8);

        // Actualiza la contraseña en la BD
        $user->password = Hash::make($newPassword);
        $user->save();

        // Enviar correo con nueva contraseña
        Mail::raw("Tu nueva contraseña es: $newPassword", function($message) use ($user) {
            $message->to($user->email)
                    ->subject('Nueva contraseña');
        });

        return redirect()->route('login')->with('status', 'Se ha enviado tu nueva contraseña al correo.');
    }
}