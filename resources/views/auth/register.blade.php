<x-guest-layout>
    <form method="POST" action="/register">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">

            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                href="{{ route('login') }}">
                ¿Ya tienes cuenta?
            </a>

            <x-primary-button class="ms-4">
                Registrar
            </x-primary-button>

        </div>
    </form>
</x-guest-layout>