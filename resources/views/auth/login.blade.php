<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Chat</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gradient-to-r from-indigo-500 to-purple-600 h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-2xl w-96">

<h2 class="text-2xl font-bold text-center text-gray-700 mb-6">
Login al Chat
</h2>

<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-4">
        <label class="block text-gray-600">Email</label>
        <input 
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400"
        >
        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
    </div>

    <div class="mb-4">
        <label class="block text-gray-600">Contraseña</label>
        <input
            type="password"
            name="password"
            required
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400"
        >
        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
    </div>

    <div class="flex items-center justify-between mb-4">
        <label class="flex items-center text-sm text-gray-600">
            <input type="checkbox" name="remember" class="mr-2">Recordarme
        </label>

        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">
            Olvidé mi contraseña
        </a>
    </div>

    <button
        class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition"
    >
        Entrar al Chat
    </button>
</form>

<hr class="my-4">

<a href="{{ route('register') }}" 
   class="w-full block text-center bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
   Crear usuario
</a>

</div>

</body>
</html>