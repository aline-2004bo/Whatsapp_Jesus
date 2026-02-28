<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e1eadd] font-sans antialiased relative z-0">

    <div class="absolute top-0 w-full h-56 bg-[#00a884] -z-10"></div>

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-[#00a884]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 5.97 2 10.86c0 2.8 1.5 5.28 3.84 6.84-.23 1.25-.97 2.87-1.02 2.97-.07.16-.02.35.1.47.1.1.25.14.4.1.28-.08 1.8-.57 3.32-1.33 1.05.34 2.18.52 3.36.52 5.52 0 10-3.97 10-8.86S17.52 2 12 2zm0 16.27c-1.06 0-2.1-.17-3.08-.49l-.33-.11-1.8.72.48-1.57-.22-.32C5.16 15.15 4 13.1 4 10.86 4 6.98 7.59 3.82 12 3.82s8 3.16 8 7.04-3.59 7.04-8 7.04z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold text-gray-800">Inicia sesión</h2>
                <p class="text-gray-500 text-sm mt-2">Ingresa tus datos para acceder a tus chats</p>
            </div>

            <form action="#" method="POST">
                <div class="mb-5">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Nombre de Usuario</label>
                    <input type="text" id="username" name="username" placeholder="Ej. usuario123" required
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00a884] focus:bg-white transition-colors">
                </div>

                <div class="mb-8">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00a884] focus:bg-white transition-colors">
                        <div class="flex items-center justify-between mb-1">
                    
                    <a href="#" class="text-sm text-[#00a884] hover:text-[#008f6f] hover:underline transition-colors">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
                </div>
                

                <button type="submit"
                    class="w-full bg-[#00a884] hover:bg-[#008f6f] text-white font-semibold py-2.5 px-4 rounded-md shadow-md transition duration-300 ease-in-out">
                    Entrar al Chat
                </button>
            </form>

        </div>
    </div>

</body>
</html>