<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Simulador</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased overflow-hidden">

    <div class="flex h-screen max-w-[1600px] mx-auto bg-white shadow-xl">

        <div class="w-1/3 flex flex-col border-r border-gray-200 bg-white">
            
            <div class="h-16 bg-gray-100 flex items-center justify-between px-4 border-b border-gray-200">
                <img src="https://ui-avatars.com/api/?name=Kim&background=00a884&color=fff" alt="Mi Perfil" class="w-10 h-10 rounded-full cursor-pointer">
                <div class="flex space-x-4 text-gray-500">
                    <button class="hover:text-gray-700">⟳</button>
                    <button class="hover:text-gray-700">⊕</button>
                    <button class="hover:text-gray-700">⋮</button>
                </div>
            </div>

            <div class="p-2 bg-white border-b border-gray-200">
                <input type="text" placeholder="Buscar un chat o iniciar uno nuevo" 
                    class="w-full bg-gray-100 rounded-lg px-4 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-[#00a884] transition-all">
            </div>

            <div class="flex-1 overflow-y-auto">
                
                <div class="flex items-center px-4 py-3 bg-gray-100 cursor-pointer border-b border-gray-50">
                    <img src="https://ui-avatars.com/api/?name=Cliente+Pedidos" class="w-12 h-12 rounded-full mr-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline">
                            <h3 class="font-semibold text-gray-800 truncate">Cliente Pedidos</h3>
                            <span class="text-xs text-[#00a884]">10:45 AM</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">¿Todavía tienes de Bubulubu y Kinder?</p>
                    </div>
                </div>

                <div class="flex items-center px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 transition-colors">
                    <img src="https://ui-avatars.com/api/?name=Paseador" class="w-12 h-12 rounded-full mr-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline">
                            <h3 class="font-semibold text-gray-800 truncate">Paseador</h3>
                            <span class="text-xs text-gray-500">Ayer</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">El perrito gordito caminó súper bien hoy 🐶</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="w-2/3 flex flex-col bg-[#efeae2]"> <div class="h-16 bg-gray-100 flex items-center justify-between px-4 border-b border-gray-200">
                <div class="flex items-center cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name=Cliente+Pedidos" class="w-10 h-10 rounded-full mr-4">
                    <div>
                        <h2 class="font-semibold text-gray-800">Cliente Pedidos</h2>
                        <p class="text-xs text-gray-500">en línea</p>
                    </div>
                </div>
                <div class="flex space-x-4 text-gray-500">
                    <button class="hover:text-gray-700">🔍</button>
                    <button class="hover:text-gray-700">⋮</button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                
                <div class="flex justify-start">
                    <div class="bg-white rounded-lg p-2 max-w-md shadow-sm relative">
                        <p class="text-gray-800 text-sm pb-3">Hola Kim, buenas tardes. ¿Todavía tienes trufas de Bubulubu y Oreo para este fin de semana?</p>
                        <span class="text-[10px] text-gray-400 absolute bottom-1 right-2">10:44 AM</span>
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="bg-[#d9fdd3] rounded-lg p-2 max-w-md shadow-sm relative">
                        <p class="text-gray-800 text-sm pb-3">¡Hola! Sí, claro que sí. Te separo tu pedido de una vez. 🍫</p>
                        <span class="text-[10px] text-gray-500 absolute bottom-1 right-2 flex items-center">
                            10:45 AM 
                            <span class="text-blue-500 ml-1">✓✓</span> </span>
                    </div>
                </div>

            </div>

            <div class="min-h-[60px] bg-gray-100 flex items-center px-4 py-2 space-x-2">
                <button class="text-gray-500 hover:text-gray-700 text-xl px-2">📎</button>
                
                <input type="text" placeholder="Escribe un mensaje" 
                    class="flex-1 bg-white rounded-lg px-4 py-2.5 text-sm focus:outline-none shadow-sm">
                
            </div>

        </div>
    </div>

</body>
</html>