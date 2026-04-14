<nav x-data="{ open: false }" class="bg-blue-600 shadow">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex justify-between h-16">

    <!-- LOGO -->
    <div class="flex items-center">
        <a href="{{ route('chat') }}" class="text-white font-bold text-xl">
            💬 ChatApp
        </a>
    </div>

    <!-- MENÚ DESKTOP -->
    <div class="hidden sm:flex sm:items-center gap-6">
        <a href="{{ route('chat') }}" class="text-white hover:text-blue-200">
            Chat
        </a>
    </div>

    <!-- USER DESKTOP -->
    <div class="hidden sm:flex sm:items-center">
        <x-dropdown align="right" width="56">

            <x-slot name="trigger">
                <button class="flex items-center gap-3 text-white">

                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/'.Auth::user()->avatar) }}" 
                        class="w-9 h-9 rounded-full object-cover border-2 border-white">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563eb&color=fff"
                        class="w-9 h-9 rounded-full">
                    @endif

                    <span>{{ Auth::user()->name }}</span>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    Perfil
                </x-dropdown-link>

                <a href="{{ route('seguridad') }}" 
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    FaceID / Huella
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar sesión
                    </x-dropdown-link>
                </form>
            </x-slot>

        </x-dropdown>
    </div>

    <!-- BOTÓN HAMBURGUESA (MÓVIL) -->
    <div class="flex items-center sm:hidden">
        <button @click="open = !open" class="text-white text-3xl focus:outline-none">
            ☰
        </button>
    </div>

</div>
</div>

<!-- MENÚ MÓVIL -->
<div x-show="open" x-transition class="sm:hidden bg-blue-600 px-4 pb-4 space-y-3">

    <!-- Usuario -->
    <div class="flex items-center gap-3 border-b border-blue-400 pb-3">

        @if(Auth::user()->avatar)
            <img src="{{ asset('storage/'.Auth::user()->avatar) }}" 
            class="w-10 h-10 rounded-full object-cover border-2 border-white">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563eb&color=fff"
            class="w-10 h-10 rounded-full">
        @endif

        <span class="text-white font-semibold">
            {{ Auth::user()->name }}
        </span>
    </div>

    <!-- Opciones -->
    <a href="{{ route('chat') }}" class="block text-white py-2">
        💬 Chat
    </a>

    <a href="{{ route('profile.edit') }}" class="block text-white py-2">
        👤 Perfil
    </a>

    <a href="{{ route('seguridad') }}" class="block text-white py-2">
        🔐 FaceID / Huella
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left text-red-200 py-2">
            🚪 Cerrar sesión
        </button>
    </form>

</div>

</nav>