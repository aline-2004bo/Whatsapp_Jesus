<nav x-data="{ open: false }" class="bg-blue-600 shadow">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

<div class="flex justify-between h-16">

<!-- LOGO / NOMBRE -->

<div class="flex items-center">

<a href="{{ route('chat') }}" class="text-white font-bold text-xl">
💬 ChatApp
</a>

</div>


<!-- MENU -->

<div class="hidden sm:flex sm:items-center gap-6">

<a href="{{ route('chat') }}" class="text-white hover:text-blue-200">
Chat
</a>

</div>


<!-- USER -->

<div class="hidden sm:flex sm:items-center">

<x-dropdown align="right" width="48">

<x-slot name="trigger">

<button class="flex items-center gap-3 text-white">

<!-- FOTO -->

@if(Auth::user()->avatar)

<img 
src="{{ asset('storage/'.Auth::user()->avatar) }}" 
class="w-9 h-9 rounded-full object-cover border-2 border-white"
>

@else

<img 
src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563eb&color=fff"
class="w-9 h-9 rounded-full"
>

@endif


<span>{{ Auth::user()->name }}</span>

</button>

</x-slot>


<x-slot name="content">

<x-dropdown-link :href="route('profile.edit')">
Perfil
</x-dropdown-link>

<form method="POST" action="{{ route('logout') }}">
@csrf

<x-dropdown-link :href="route('logout')"
onclick="event.preventDefault();
this.closest('form').submit();">

Cerrar sesión

</x-dropdown-link>

</form>

</x-slot>

</x-dropdown>

</div>

</div>

</div>

</nav>