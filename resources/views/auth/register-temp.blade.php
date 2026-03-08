<x-app-layout>
<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Crea tu cuenta</h2>

    <form method="POST" action="{{ route('register.temp.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border px-3 py-2 rounded" required>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="{{ session('email') }}" class="w-full border px-3 py-2 rounded" required>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Crear cuenta</button>
    </form>
</div>
</x-app-layout>