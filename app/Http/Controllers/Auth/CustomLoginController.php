<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{

    // -------------------------------
    // Mostrar login
    // -------------------------------
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // -------------------------------
    // Login
    // -------------------------------
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/chat');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden.',
        ]);
    }

    // -------------------------------
    // Logout
    // -------------------------------
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // -------------------------------
    // Mostrar formulario de registro
    // -------------------------------
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // -------------------------------
    // Registrar usuario
    // -------------------------------
    public function register(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $password = substr(bin2hex(random_bytes(4)), 0, 8);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);

        Mail::raw("Tu usuario ha sido creado. Tu contraseña es: $password", function($message) use ($user) {
            $message->to($user->email)
                    ->subject('Registro de usuario');
        });

        return redirect()->route('login')->with('status','Usuario creado. Revisa tu correo para ver la contraseña.');
    }

    // -------------------------------
    // Mostrar formulario recuperar contraseña
    // -------------------------------
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // -------------------------------
    // Generar nueva contraseña
    // -------------------------------
    public function sendNewPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email',$request->email)->first();

        $newPassword = substr(bin2hex(random_bytes(4)),0,8);

        $user->password = Hash::make($newPassword);
        $user->save();

        Mail::raw("Tu nueva contraseña es: $newPassword", function($message) use ($user) {
            $message->to($user->email)
                    ->subject('Nueva contraseña');
        });

        return redirect()->route('login')->with('status','Nueva contraseña enviada al correo.');
    }

}