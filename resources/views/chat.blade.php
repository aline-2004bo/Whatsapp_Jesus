    <x-app-layout>

        <style>
    /* Estenedor principal adaptativo */
    .containerChat {
        display: flex;
        height: 80vh;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        background: white;
        transition: all 0.3s ease;
    }

    /* SIDEBAR - Ajustada para ser flexible */
    .users {
        width: 30%;
        min-width: 250px;
        background: #f0f6ff;
        border-right: 1px solid #dbeafe;
        display: flex;
        flex-direction: column;
    }

    .users-list-container {
        flex: 1;
        overflow-y: auto;
    }

    .users h3 {
        background: #2563eb;
        color: white;
        margin: 0;
        padding: 15px;
        font-weight: 600;
    }

    .user {
        padding: 14px;
        cursor: pointer;
        border-bottom: 1px solid #e5e7eb;
        transition: 0.2s;
    }

    .user:hover {
        background: #dbeafe;
    }

    /* CHAT - Crece para ocupar el resto */
    .chat {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #f9fafb;
        min-width: 0; /* Evita que el contenido desborde el flex */
    }

    #chatTitle {
        background: #2563eb;
        color: white;
        margin: 0;
        padding: 15px;
        font-weight: 600;
    }

    /* MENSAJES */
    .messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background: #eef2ff;
    }

    .message {
        margin: 12px 0;
        display: flex;
    }

    .me { justify-content: flex-end; }
    .other { justify-content: flex-start; }

    .bubble {
        display: inline-block;
        padding: 10px 14px;
        border-radius: 16px;
        max-width: 85%; /* Aumentado para móviles */
        font-size: 14px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        word-wrap: break-word;
    }

    .me .bubble {
        background: #2563eb;
        color: white;
        border-bottom-right-radius: 4px;
    }

    .other .bubble {
        background: white;
        border: 1px solid #e5e7eb;
        border-bottom-left-radius: 4px;
    }

    .time {
        font-size: 11px;
        margin-top: 5px;
        opacity: 0.7;
        text-align: right;
    }

    .send button{
padding:10px 18px;
background:#2563eb;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
font-weight:600;
}

.send button:hover{
background:#1d4ed8;
}

    /* AREA ENVIAR RESPONSIVE */
    .send {
        display: flex;
        flex-wrap: wrap; /* Permite que los elementos bajen si no caben */
        gap: 10px;
        padding: 12px;
        border-top: 1px solid #e5e7eb;
        background: white;
    }

    .send input[type="text"] {
        flex: 1;
        min-width: 150px;
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        outline: none;
    }

    .send input[type="file"] {
        max-width: 100%;
        font-size: 12px;
    }

    /* VISOR Y OTROS */
    .image-container { margin-top: 6px; max-width: 100%; overflow: hidden; }
    .chat-image { max-width: 100%; height: auto; border-radius: 10px; }

    /* =============================================
       MEDIA QUERIES PARA MÓVILES (MÁX 768px)
       ============================================= */
    @media (max-width: 768px) {
        .containerChat {
            flex-direction: column; /* Apila la lista arriba y el chat abajo */
            height: 90vh; /* Un poco más alto en móvil */
        }

        .users {
            width: 100%;
            height: 30%; /* La lista ocupa la parte superior */
            border-right: none;
            border-bottom: 2px solid #dbeafe;
        }

        .chat {
            width: 100%;
            height: 70%;
        }

        .bubble {
            max-width: 90%; /* Más ancho en pantallas pequeñas */
        }
        
        .send button {
            width: 100%; /* Botón de enviar a lo ancho en pantallas muy pequeñas */
        }
    }
    /* SIDEBAR - Ajustada para tener scroll interno */
    .users {
        width: 30%;
        min-width: 250px;
        background: #f0f6ff;
        border-right: 1px solid #dbeafe;
        display: flex;
        flex-direction: column; /* Esto permite que el contenido se apile verticalmente */
        overflow: hidden; /* Evitamos que el contenedor principal crezca de más */
    }

    /* NUEVA CLASE: Para que la lista sea la que scrollee */
    .users-list-container {
        flex: 1;
        overflow-y: auto; /* Aquí activamos el scroll */
    }

    /* ... (tus otros estilos se quedan igual) ... */

    /* AJUSTE EN MEDIA QUERY PARA MÓVIL */
    @media (max-width: 768px) {
        .containerChat {
            flex-direction: column;
            height: 90vh;
        }

        .users {
            width: 100%;
            height: 35%; /* Ajustamos la altura para que no ocupe toda la pantalla */
            border-right: none;
            border-bottom: 2px solid #dbeafe;
        }

        .chat {
            width: 100%;
            height: 65%;
        }
    }
</style>

        <div class="containerChat">
        
<div class="users">
    <div style="padding: 10px;">
        <button onclick="abrirModal()" style="width: 100%; padding: 8px; background: #2fa3f0; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
            + Nuevo Grupo
        </button>
    </div>

    <div class="users-list-container">
        <h4 style="padding: 10px 15px; margin: 0; background: #e5e7eb; font-size: 13px; color: #4b5563;">MIS GRUPOS</h4>
        @if(isset($groups) && $groups->count() > 0)
            @foreach($groups as $group)
                <div class="user" style="display: flex; justify-content: space-between; align-items: center; padding: 0;">
                    <div onclick="openChat({{ $group->id }}, '{{ $group->name }}', true)" style="flex: 1; padding: 14px;">
                        👥 {{ $group->name }}
                    </div>
                    @if($group->created_by == auth()->id())
                        <button onclick="eliminarGrupo({{ $group->id }})" style="background: transparent; border: none; color: #ef4444; font-size: 16px; cursor: pointer; padding: 14px;">
                            🗑️
                        </button>
                    @endif
                </div>
            @endforeach
        @else
            <div style="padding: 10px 15px; font-size: 12px; color: #9ca3af;">No tienes grupos aún.</div>
        @endif

        <h4 style="padding: 10px 15px; margin: 0; background: #e5e7eb; font-size: 13px; color: #4b5563;">USUARIOS</h4>
        @foreach($users as $user)
            <div class="user" onclick="openChat({{ $user->id }}, '{{ $user->name }}', false)">
                {{ $user->name }}
            </div>
        @endforeach
    </div>
</div>

            <div class="chat">
                <h3 id="chatTitle">Selecciona un usuario</h3>
                
                <div id="messages" class="messages"></div>

                <form id="formSend" class="send" enctype="multipart/form-data">
                    <input type="hidden" id="receiver_id" name="receiver_id">
                    <input type="hidden" id="is_group" name="is_group" value="false">
                    
                    <input type="text" name="message" id="message" placeholder="Mensaje...">
                    <input type="file" name="file" id="file">
                    
                    <button type="submit">Enviar</button>
                </form>

                <div id="preview"></div>
            </div>

        </div>

        <div id="viewer" class="viewer">
            <span onclick="closeViewer()">✕</span>
            <img id="viewerImg">
        </div>

        <div id="modalGrupo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); align-items: center; justify-content: center; z-index: 9999;">
            <div style="background: white; padding: 20px; border-radius: 12px; width: 350px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                <h3 style="margin-top: 0; color: #2563eb;">Crear Nuevo Grupo</h3>
                
                <input type="text" id="nombreGrupoNuevo" placeholder="Nombre del grupo..." style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;">
                
                <p style="margin: 0 0 10px 0; font-weight: bold; font-size: 14px; color: #4b5563;">Selecciona integrantes:</p>
                <div style="max-height: 150px; overflow-y: auto; margin-bottom: 20px; border: 1px solid #e5e7eb; padding: 10px; border-radius: 6px;">
                    @foreach($users as $user)
                        <label style="display: block; margin-bottom: 8px; cursor: pointer;">
                            <input type="checkbox" class="check-usuario" value="{{ $user->id }}">
                            {{ $user->name }}
                        </label>
                    @endforeach
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button onclick="cerrarModal()" style="padding: 8px 15px; background: #9ca3af; color: white; border: none; border-radius: 6px; cursor: pointer;">Cancelar</button>
                    <button onclick="guardarGrupo()" style="padding: 8px 15px; background: #10b981; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">Guardar Grupo</button>
                </div>
            </div>
        </div>

        <script>


            let receiver = null;
            let isGroupChat = false; // Variable para saber si es grupo o chat directo

            // 1. Abrir conversación (Actualizado para grupos)
            function openChat(id, name, isGroup = false) {
                receiver = id;
                isGroupChat = isGroup;
                
                document.getElementById('receiver_id').value = id;
                document.getElementById('is_group').value = isGroup; // Avisa al form si es grupo
                document.getElementById('chatTitle').innerText = name;
                
                loadMessages();
            }

            // Funciones para la ventana de crear grupo
            function abrirModal() {
                document.getElementById('modalGrupo').style.display = 'flex';
            }

            function cerrarModal() {
                document.getElementById('modalGrupo').style.display = 'none';
                document.getElementById('nombreGrupoNuevo').value = ''; // Limpiar
            }

            function guardarGrupo() {
                let nombre = document.getElementById('nombreGrupoNuevo').value;
                if (!nombre) {
                    alert("Por favor, ingresa un nombre para el grupo.");
                    return;
                }

                // Recolectar a todos los usuarios que seleccionaste en los checkboxes
                let checkboxes = document.querySelectorAll('.check-usuario:checked');
                let usuariosSeleccionados = Array.from(checkboxes).map(cb => cb.value);

                if (usuariosSeleccionados.length === 0) {
                    alert("Debes seleccionar al menos un integrante.");
                    return;
                }

                let formData = new FormData();
                formData.append('name', nombre);
                // Agregamos cada usuario al formulario
                usuariosSeleccionados.forEach(id => formData.append('users[]', id));

                fetch('/groups/create', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'ok') {
                        cerrarModal();
                        location.reload(); // Recarga para ver el grupo nuevo
                    }
                });
            }
            function eliminarGrupo(id) {
                // Confirmación de seguridad
                if(confirm("¿Estás segura de que quieres eliminar este grupo? Se borrarán todos los mensajes para todos los integrantes.")) {
                    fetch('/groups/' + id, {
                        method: 'DELETE',
                        headers: { 
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.status === 'ok') {
                            location.reload(); // Recargamos para que desaparezca de la lista
                        } else {
                            alert("Error: No tienes permiso para eliminar este grupo.");
                        }
                    });
                }
            }

            // 3. Funciones del visor de imágenes (Original)
            function openViewer(src) {
                document.getElementById('viewerImg').src = src;
                document.getElementById('viewer').style.display = 'flex';
            }

            function closeViewer() {
                document.getElementById('viewer').style.display = 'none';
            }

            // 4. Cargar mensajes del servidor (Actualizado para grupos)
            function loadMessages() {
                if (!receiver) return;

                // Mandamos por la URL si es un chat de grupo o normal
                fetch('/messages/' + receiver + '?is_group=' + isGroupChat)
                    .then(res => res.json())
                    .then(data => {
                        let html = '';

                        data.forEach(msg => {
                            let className = msg.sender_id == "{{auth()->id()}}" ? 'me' : 'other';
                            let date = new Date(msg.created_at);
                            let time = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                            // Si es un grupo y el mensaje es de otra persona, mostramos su nombre
                            let senderName = '';
                            if (isGroupChat && className === 'other' && msg.sender) {
                                senderName = `<div style="font-size: 11px; font-weight: bold; color: #2563eb; margin-bottom: 3px;">${msg.sender.name}</div>`;
                            }

                            html += `
                                <div class="message ${className}">
                                    <div class="bubble">
                                        ${senderName}
                            `;

                            if (msg.message) {
                                html += `<div>${msg.message}</div>`;
                            }

                            // Manejo de archivos (Original)
                            if (msg.file) {
                                let ext = msg.file.split('.').pop().toLowerCase();
                                let fileUrl = "/files/" + msg.file;

                                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                                    html += `
                                        <div class="image-container">
                                            <img src="${fileUrl}" class="chat-image" onclick="openViewer('${fileUrl}')">
                                        </div>
                                    `;
                                } else if (ext === 'pdf') {
                                    html += `<a class="file" href="${fileUrl}" target="_blank">📄 Ver PDF</a>`;
                                } else {
                                    html += `<a class="file" href="${fileUrl}" target="_blank">📁 Descargar archivo</a>`;
                                }
                            }

                            html += `<div class="time">${time}</div></div></div>`;
                        });

                        document.getElementById('messages').innerHTML = html;

                        // Mantiene el scroll automático siempre abajo
                        let box = document.getElementById('messages');
                        box.scrollTop = box.scrollHeight;
                    });
            }

            // 5. Enviar un nuevo mensaje (Original)
            document.getElementById('formSend').addEventListener('submit', function(e) {
                e.preventDefault();

                if (!receiver) {
                    alert('Selecciona un usuario o grupo primero');
                    return;
                }

                let formData = new FormData(this);

                fetch('/send', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    // Limpia el formulario y recarga los mensajes
                    document.getElementById('message').value = '';
                    document.getElementById('file').value = '';
                    document.getElementById('preview').innerHTML = '';
                    loadMessages();
                });
            });

            // 6. Mostrar vista previa al seleccionar un archivo (Original)
            document.getElementById('file').addEventListener('change', function() {
                let file = this.files[0];
                if (!file) return;

                let url = URL.createObjectURL(file);
                let ext = file.name.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                    document.getElementById('preview').innerHTML = `<img src="${url}" style="max-width:120px;border-radius:8px;">`;
                } else {
                    document.getElementById('preview').innerHTML = `<span>${file.name}</span>`;
                }
            });

            // 7. Recarga automática - Polling (Original)
            setInterval(loadMessages, 1000);
        </script>

    </x-app-layout>