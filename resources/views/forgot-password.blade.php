<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e1eadd] font-sans antialiased relative z-0">

    <div class="absolute top-0 w-full h-56 bg-[#00a884] -z-10"></div>

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            
            <div class="text-center mb-8">
                <h2 class="text-2xl font-semibold text-gray-800">Recupera tu cuenta</h2>
                <p class="text-gray-500 text-sm mt-2">Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
            </div>

            <form action="#" method="POST">
                @csrf
                <div class="mb-8">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="Ej. correo@ejemplo.com" required
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00a884] focus:bg-white transition-colors">
                </div>
                
                <button type="submit"
                    class="w-full bg-[#00a884] hover:bg-[#008f6f] text-white font-semibold py-2.5 px-4 rounded-md shadow-md transition duration-300 ease-in-out mb-4">
                    Enviar enlace de recuperación
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-[#00a884] hover:text-[#008f6f] hover:underline transition-colors">
                        Volver al inicio de sesión
                    </a>
                </div>
            </form>

        </div>
    </div>

</body>
</html>