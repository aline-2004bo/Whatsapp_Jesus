<x-app-layout>
    <style>
        /* Reset y estilos base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Contenedor principal - Ocupa toda la pantalla */
        .whatsapp-container {
            display: flex;
            height: 100vh;
            width: 100%;
            background: #f0f2f5;
        }

        /* Panel de contactos (sidebar) */
        .contacts-sidebar {
            width: 100%;
            max-width: 400px;
            background: white;
            border-right: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            transition: transform 0.3s ease;
            z-index: 20;
        }

        /* Cuando el chat está abierto en móvil, ocultamos contactos */
        .contacts-sidebar.hidden-mobile {
            transform: translateX(-100%);
        }

        /* Header de contactos */
        .contacts-header {
            background: #2563eb;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 70px;
        }

        .contacts-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .new-group-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            font-size: 26px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .new-group-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        /* Botón cerrar sidebar (móvil) */
        .close-sidebar-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            font-size: 26px;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .close-sidebar-btn:active {
            background: rgba(255,255,255,0.3);
        }

        /* Búsqueda */
        .search-container {
            padding: 12px;
            background: #f0f2f5;
        }

        .search-box {
            width: 100%;
            padding: 10px 18px;
            border: none;
            border-radius: 25px;
            background: white;
            font-size: 15px;
            outline: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .search-box:focus {
            box-shadow: 0 2px 5px rgba(37,99,235,0.2);
        }

        /* Lista de contactos con SCROLL SUAVE */
        .contacts-list {
            flex: 1;
            overflow-y: auto;
            background: white;
            -webkit-overflow-scrolling: touch;
        }

        .contacts-list::-webkit-scrollbar {
            width: 5px;
        }

        .contacts-list::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .contacts-list::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 5px;
        }

        /* Títulos de sección */
        .section-title {
            padding: 10px 20px;
            background: #f0f2f5;
            font-size: 14px;
            font-weight: 600;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        /* Items de contacto */
        .contact-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
            -webkit-tap-highlight-color: transparent;
        }

        .contact-item:hover {
            background: #f5f5f5;
        }

        .contact-item:active {
            background: #e8e8e8;
        }

        .contact-item.active {
            background: #e3f2fd;
        }

        .contact-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #2563eb;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .group-avatar {
            background: #10b981;
        }

        .contact-info {
            flex: 1;
            min-width: 0;
        }

        .contact-name {
            font-weight: 600;
            font-size: 16px;
            color: #333;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-preview {
            font-size: 13px;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-time {
            font-size: 11px;
            color: #999;
            margin-left: 10px;
        }

        /* Grupo con botón eliminar */
        .group-wrapper {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .group-wrapper .contact-item {
            flex: 1;
            border-bottom: none;
        }

        .delete-group-btn {
            background: transparent;
            border: none;
            color: #dc2626;
            font-size: 20px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: all 0.2s;
            flex-shrink: 0;
            -webkit-tap-highlight-color: transparent;
        }

        .delete-group-btn:active {
            background: #fee2e2;
        }

        /* Panel de chat */
        .chat-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #efeae2;
            height: 100%;
            overflow: hidden;
            position: relative;
        }

        /* Header del chat */
        .chat-header {
            background: #f0f2f5;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
            min-height: 70px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Botón hamburguesa (móvil) */
        .hamburger-btn {
            background: transparent;
            border: none;
            font-size: 28px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: #2563eb;
            -webkit-tap-highlight-color: transparent;
        }

        .hamburger-btn:active {
            background: rgba(0,0,0,0.05);
        }

        .back-btn {
            background: transparent;
            border: none;
            font-size: 28px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: #2563eb;
            -webkit-tap-highlight-color: transparent;
        }

        .back-btn:active {
            background: rgba(0,0,0,0.05);
        }

        .chat-header-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #2563eb;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .chat-header-info {
            flex: 1;
            min-width: 0;
        }

        .chat-header-name {
            font-weight: 600;
            font-size: 16px;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-header-status {
            font-size: 12px;
            color: #666;
        }

        /* Área de mensajes con SCROLL SUAVE */
        .messages-area {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            background: #efeae2;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="%23efeae2" opacity="0.4"/></svg>');
            -webkit-overflow-scrolling: touch;
        }

        .messages-area::-webkit-scrollbar {
            width: 4px;
        }

        .messages-area::-webkit-scrollbar-track {
            background: transparent;
        }

        .messages-area::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.2);
            border-radius: 4px;
        }

        /* Burbujas de mensaje */
        .message-wrapper {
            margin: 8px 0;
            display: flex;
        }

        .message-wrapper.me {
            justify-content: flex-end;
        }

        .message-wrapper.other {
            justify-content: flex-start;
        }

        .message-bubble {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 18px;
            position: relative;
            word-wrap: break-word;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .me .message-bubble {
            background: #d9fdd3;
            border-bottom-right-radius: 4px;
        }

        .other .message-bubble {
            background: white;
            border-bottom-left-radius: 4px;
        }

        .sender-name {
            font-size: 12px;
            font-weight: 600;
            color: #2563eb;
            margin-bottom: 4px;
        }

        .message-time {
            font-size: 10px;
            color: #666;
            text-align: right;
            margin-top: 4px;
        }

        /* Archivos adjuntos */
        .file-attachment {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            background: rgba(0,0,0,0.05);
            border-radius: 10px;
            margin-top: 5px;
            text-decoration: none;
            color: inherit;
            -webkit-tap-highlight-color: transparent;
        }

        .file-attachment:active {
            background: rgba(0,0,0,0.1);
        }

        .file-icon {
            font-size: 30px;
            margin-right: 12px;
        }

        .file-info {
            flex: 1;
            min-width: 0;
        }

        .file-name {
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-size {
            font-size: 10px;
            color: #666;
        }

        /* Imágenes */
        .image-container {
            max-width: 250px;
            margin-top: 5px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            position: relative;
            -webkit-tap-highlight-color: transparent;
        }

        .chat-image {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.2s;
        }

        .chat-image:active {
            transform: scale(1.02);
        }

        /* Área de entrada */
        .input-area {
            background: #f0f2f5;
            padding: 10px 15px;
            border-top: 1px solid #e0e0e0;
        }

        .input-container {
            display: flex;
            gap: 8px;
            align-items: center;
            background: white;
            border-radius: 25px;
            padding: 5px 5px 5px 18px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .input-container input[type="text"] {
            flex: 1;
            border: none;
            padding: 12px 0;
            font-size: 15px;
            outline: none;
            background: transparent;
            min-width: 0;
        }

        .input-container input[type="file"] {
            display: none;
        }

        .attach-btn {
            background: transparent;
            border: none;
            color: #2563eb;
            font-size: 26px;
            cursor: pointer;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
            flex-shrink: 0;
            -webkit-tap-highlight-color: transparent;
        }

        .attach-btn:active {
            background: #e3f2fd;
        }

        .send-btn {
            background: #2563eb;
            border: none;
            color: white;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            transition: background 0.2s;
            flex-shrink: 0;
            -webkit-tap-highlight-color: transparent;
        }

        .send-btn:active {
            background: #1d4ed8;
        }

        .send-btn:disabled {
            background: #93c5fd;
            cursor: not-allowed;
        }

        /* Preview de archivo */
        .preview-container {
            margin-top: 10px;
            padding: 12px;
            background: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .preview-image {
            max-width: 60px;
            max-height: 60px;
            border-radius: 8px;
        }

        .preview-file-info {
            flex: 1;
            font-size: 13px;
        }

        .remove-preview {
            color: #dc2626;
            cursor: pointer;
            font-size: 22px;
            padding: 5px 10px;
            -webkit-tap-highlight-color: transparent;
        }

        .remove-preview:active {
            background: #fee2e2;
            border-radius: 50%;
        }

        /* Visor de imágenes */
        .image-viewer {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.95);
            z-index: 10000;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .image-viewer.active {
            display: flex;
        }

        .close-viewer {
            position: absolute;
            top: 20px;
            right: 25px;
            color: white;
            font-size: 45px;
            cursor: pointer;
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            transition: 0.2s;
            z-index: 10001;
        }

        .close-viewer:active {
            background: rgba(255,255,255,0.3);
        }

        .viewer-image {
            max-width: 95%;
            max-height: 80%;
            object-fit: contain;
            border-radius: 8px;
        }

        .viewer-caption {
            color: white;
            margin-top: 15px;
            font-size: 15px;
            padding: 0 20px;
            text-align: center;
        }

        /* Modal de grupo */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 25px;
            border-radius: 20px;
            width: 90%;
            max-width: 400px;
            max-height: 80vh;
            overflow-y: auto;
            margin: 20px;
        }

        .modal-content h3 {
            margin: 0 0 20px 0;
            color: #2563eb;
            font-size: 22px;
        }

        .modal-input {
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 16px;
            outline: none;
        }

        .modal-input:focus {
            border-color: #2563eb;
        }

        .users-list {
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid #e5e7eb;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            -webkit-overflow-scrolling: touch;
        }

        .user-checkbox {
            display: block;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 16px;
            padding: 5px 0;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .modal-btn {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 500;
            font-size: 15px;
            transition: background 0.2s;
            -webkit-tap-highlight-color: transparent;
        }

        .modal-btn.cancel {
            background: #9ca3af;
            color: white;
        }

        .modal-btn.cancel:active {
            background: #6b7280;
        }

        .modal-btn.save {
            background: #10b981;
            color: white;
        }

        .modal-btn.save:active {
            background: #059669;
        }

        /* Descarga APK */
        .apk-download {
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            text-align: center;
        }

        .apk-download-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: white;
            color: #4a5568;
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.2s;
            -webkit-tap-highlight-color: transparent;
        }

        .apk-download-btn:active {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        /* Mensaje de bienvenida */
        .welcome-message {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #666;
            font-size: 16px;
            text-align: center;
            padding: 20px;
            background: #f0f2f5;
        }

        /* ============================================
           MEDIA QUERIES PARA MÓVIL
           ============================================ */
        @media (max-width: 768px) {
            .contacts-sidebar {
                max-width: 85%;
                position: fixed;
                left: 0;
                top: 0;
                height: 100%;
                width: 85%;
                z-index: 1000;
                box-shadow: 2px 0 8px rgba(0,0,0,0.15);
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .contacts-sidebar.hidden-mobile {
                transform: translateX(-100%);
            }

            .contacts-sidebar:not(.hidden-mobile) {
                transform: translateX(0);
            }

            .close-sidebar-btn {
                display: flex;
            }

            .chat-panel {
                width: 100%;
                position: relative;
                left: 0;
                top: 0;
            }

            .hamburger-btn {
                display: flex;
            }

            .back-btn {
                display: none;
            }

            .message-bubble {
                max-width: 85%;
                font-size: 15px;
                padding: 12px 16px;
            }

            .contact-item {
                padding: 15px 20px;
            }

            .contact-avatar {
                width: 55px;
                height: 55px;
                font-size: 22px;
            }

            .contact-name {
                font-size: 17px;
            }

            .contact-preview {
                font-size: 14px;
            }

            .input-container input[type="text"] {
                font-size: 16px;
                padding: 14px 0;
            }

            .send-btn {
                width: 52px;
                height: 52px;
                font-size: 24px;
            }

            .attach-btn {
                font-size: 28px;
                width: 48px;
                height: 48px;
            }

            .modal-content {
                padding: 20px;
            }

            .modal-btn {
                padding: 14px 30px;
                font-size: 16px;
            }

            .chat-header {
                padding: 8px 12px;
            }

            .chat-header-avatar {
                width: 48px;
                height: 48px;
                font-size: 20px;
            }

            .chat-header-name {
                font-size: 17px;
            }

            .chat-header-status {
                font-size: 13px;
            }
        }

        /* Para pantallas muy pequeñas */
        @media (max-width: 380px) {
            .message-bubble {
                max-width: 90%;
            }

            .contact-avatar {
                width: 48px;
                height: 48px;
                font-size: 20px;
            }

            .contacts-header h3 {
                font-size: 18px;
            }

            .contacts-sidebar {
                max-width: 90%;
                width: 90%;
            }
        }
    </style>

    <div class="whatsapp-container">
        <!-- Panel de contactos (sidebar) -->
        <div class="contacts-sidebar hidden-mobile" id="contactsSidebar">
            <div class="contacts-header">
                <h3>WhatsApp</h3>
                <div style="display: flex; gap: 8px;">
                    <button onclick="cerrarSidebar()" class="close-sidebar-btn" title="Cerrar menú">✕</button>
                    <button onclick="abrirModal()" class="new-group-btn" title="Nuevo grupo">+</button>
                </div>
            </div>

            <!-- Búsqueda -->
            <div class="search-container">
                <input type="text" class="search-box" placeholder="Buscar chat..." id="searchInput">
            </div>

            <!-- Descarga APK -->
            <div class="apk-download">
                <a href="{{ asset('apk/Whats.apk') }}" class="apk-download-btn" download>
                    <span style="font-size: 22px;">📱</span>
                    <span>Descargar App</span>
                </a>
            </div>

            <!-- Lista de contactos con scroll -->
            <div class="contacts-list" id="contactsList">
                <!-- Grupos -->
                <div class="section-title">MIS GRUPOS</div>
                @if(isset($groups) && $groups->count() > 0)
                    @foreach($groups as $group)
                        <div class="group-wrapper">
                            <div class="contact-item" onclick="openChat({{ $group->id }}, '{{ $group->name }}', true, '👥')">
                                <div class="contact-avatar group-avatar">👥</div>
                                <div class="contact-info">
                                    <div class="contact-name">{{ $group->name }}</div>
                                    <div class="contact-preview">Toca para abrir</div>
                                </div>
                            </div>
                            @if($group->created_by == auth()->id())
                                <button onclick="eliminarGrupo({{ $group->id }})" class="delete-group-btn" title="Eliminar grupo">🗑️</button>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div style="padding: 20px; text-align: center; color: #999;">No tienes grupos aún</div>
                @endif

                <!-- Usuarios -->
                <div class="section-title">CONTACTOS</div>
                @foreach($users as $user)
                    <div class="contact-item" onclick="openChat({{ $user->id }}, '{{ $user->name }}', false, '{{ substr($user->name, 0, 1) }}')">
                        <div class="contact-avatar">{{ substr($user->name, 0, 1) }}</div>
                        <div class="contact-info">
                            <div class="contact-name">{{ $user->name }}</div>
                            <div class="contact-preview">En línea</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Panel de chat -->
        <div class="chat-panel" id="chatPanel">
            <div class="chat-header" id="chatHeader">
                <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleSidebar()">☰</button>
                <button class="back-btn" onclick="goBackToContacts()" id="backBtn">←</button>
                <div class="chat-header-avatar" id="chatAvatar"></div>
                <div class="chat-header-info">
                    <div class="chat-header-name" id="chatHeaderName">WhatsApp</div>
                    <div class="chat-header-status" id="chatHeaderStatus"></div>
                </div>
            </div>

            <!-- Área de mensajes con scroll -->
            <div class="messages-area" id="messages"></div>

            <!-- Área de entrada -->
            <div class="input-area" id="inputArea" style="display: none;">
                <form id="formSend">
                    <input type="hidden" id="receiver_id" name="receiver_id">
                    <input type="hidden" id="is_group" name="is_group" value="false">
                    
                    <div class="input-container">
                        <input type="text" name="message" id="message" placeholder="Mensaje" autocomplete="off">
                        
                        <label for="file" class="attach-btn" title="Adjuntar">📎</label>
                        <input type="file" name="file" id="file" accept="image/*,.pdf,.doc,.docx,.txt,.xls,.xlsx">
                        
                        <button type="submit" class="send-btn" id="sendBtn">➤</button>
                    </div>
                </form>

                <!-- Preview de archivo -->
                <div id="preview" class="preview-container" style="display: none;"></div>
            </div>

            <!-- Mensaje de bienvenida -->
            <div class="welcome-message" id="welcomeMessage">
                <div>
                    <h3 style="margin-bottom: 10px; font-size: 22px;">WhatsApp</h3>
                    <p style="font-size: 16px;">Selecciona un chat para comenzar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Visor de imágenes -->
    <div id="imageViewer" class="image-viewer" onclick="closeViewer()">
        <span class="close-viewer" onclick="event.stopPropagation(); closeViewer()">×</span>
        <img id="viewerImg" class="viewer-image" onclick="event.stopPropagation()">
        <div id="viewerCaption" class="viewer-caption"></div>
    </div>

    <!-- Modal para crear grupo -->
    <div id="modalGrupo" class="modal" onclick="cerrarModal()">
        <div class="modal-content" onclick="event.stopPropagation()">
            <h3>Crear Nuevo Grupo</h3>
            
            <input type="text" id="nombreGrupoNuevo" class="modal-input" placeholder="Nombre del grupo">
            
            <p style="margin: 0 0 12px 0; font-weight: 500;">Selecciona integrantes:</p>
            <div class="users-list">
                @foreach($users as $user)
                    <label class="user-checkbox">
                        <input type="checkbox" class="check-usuario" value="{{ $user->id }}">
                        {{ $user->name }}
                    </label>
                @endforeach
            </div>

            <div class="modal-buttons">
                <button onclick="cerrarModal()" class="modal-btn cancel">Cancelar</button>
                <button onclick="guardarGrupo()" class="modal-btn save">Guardar</button>
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        let receiver = null;
        let isGroupChat = false;
        let currentUserId = {{ auth()->id() }};
        let loadingMessages = false;
        let messageInterval = null;
        let currentChatName = '';
        let currentChatAvatar = '';

        // Elementos del DOM
        const contactsSidebar = document.getElementById('contactsSidebar');
        const chatPanel = document.getElementById('chatPanel');
        const messagesArea = document.getElementById('messages');
        const inputArea = document.getElementById('inputArea');
        const welcomeMessage = document.getElementById('welcomeMessage');
        const chatHeader = document.getElementById('chatHeader');
        const chatHeaderName = document.getElementById('chatHeaderName');
        const chatHeaderStatus = document.getElementById('chatHeaderStatus');
        const chatAvatar = document.getElementById('chatAvatar');
        const receiverInput = document.getElementById('receiver_id');
        const isGroupInput = document.getElementById('is_group');
        const messageInput = document.getElementById('message');
        const fileInput = document.getElementById('file');
        const preview = document.getElementById('preview');
        const sendBtn = document.getElementById('sendBtn');
        const formSend = document.getElementById('formSend');
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const backBtn = document.getElementById('backBtn');
        const searchInput = document.getElementById('searchInput');

        // Detectar si es móvil
        const isMobile = window.innerWidth <= 768;

        // Función para formatear tamaño
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
        }

        function getFileIcon(ext) {
            const icons = {
                'pdf': '📕', 'doc': '📘', 'docx': '📘',
                'xls': '📗', 'xlsx': '📗',
                'txt': '📄',
                'jpg': '🖼️', 'jpeg': '🖼️', 'png': '🖼️', 'gif': '🖼️'
            };
            return icons[ext] || '📎';
        }

        // Función para abrir/cerrar sidebar (móvil)
        function toggleSidebar() {
            if (!isMobile) return;
            contactsSidebar.classList.toggle('hidden-mobile');
        }

        function cerrarSidebar() {
            if (!isMobile) return;
            contactsSidebar.classList.add('hidden-mobile');
        }

        // Función para abrir chat
        function openChat(id, name, isGroup = false, avatar = '') {
            console.log('Abriendo chat:', id, name, isGroup);
            
            receiver = id;
            isGroupChat = isGroup;
            currentChatName = name;
            currentChatAvatar = avatar;

            receiverInput.value = id;
            isGroupInput.value = isGroup ? 'true' : 'false';

            // Actualizar UI
            welcomeMessage.style.display = 'none';
            inputArea.style.display = 'block';
            
            // Configurar header del chat
            chatHeaderName.textContent = name;
            chatHeaderStatus.textContent = isGroup ? 'Grupo' : 'En línea';
            chatAvatar.textContent = avatar || (isGroup ? '👥' : name.charAt(0));
            chatAvatar.style.display = 'flex';
            chatHeaderName.style.display = 'block';
            chatHeaderStatus.style.display = 'block';
            
            // En móvil, cerrar sidebar automáticamente
            if (isMobile) {
                cerrarSidebar();
            }

            messagesArea.innerHTML = '<div style="text-align: center; padding: 25px; color: #666;">Cargando...</div>';
            
            loadMessages();
            startMessagePolling();

            setTimeout(() => {
                messagesArea.scrollTop = messagesArea.scrollHeight;
            }, 200);
        }

        // Volver a contactos (solo escritorio)
        function goBackToContacts() {
            if (isMobile) return; // En móvil se usa hamburguesa
            // En escritorio no hacemos nada porque el sidebar siempre visible
        }

        // Cargar mensajes
        function loadMessages() {
            if (!receiver) return;

            if (loadingMessages) return;

            loadingMessages = true;

            let url = `/messages/${receiver}?is_group=${isGroupChat}`;
            
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (!data || data.length === 0) {
                        messagesArea.innerHTML = '<div style="text-align: center; padding: 30px; color: #666;">No hay mensajes aún</div>';
                        loadingMessages = false;
                        return;
                    }

                    let html = '';

                    data.forEach(msg => {
                        let className = msg.sender_id == currentUserId ? 'me' : 'other';
                        
                        let date = new Date(msg.created_at);
                        let time = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                        html += `<div class="message-wrapper ${className}">`;
                        html += `<div class="message-bubble">`;

                        if (isGroupChat && className === 'other' && msg.sender) {
                            html += `<div class="sender-name">${msg.sender.name}</div>`;
                        }

                        if (msg.message) {
                            html += `<div>${msg.message}</div>`;
                        }

                        if (msg.file) {
                            let ext = msg.file.split('.').pop().toLowerCase();
                            let fileUrl = "/files/" + msg.file;
                            let fileName = msg.file.split('/').pop() || msg.file;

                            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                                html += `
                                    <div class="image-container" onclick="openViewer('${fileUrl}', '${fileName}')">
                                        <img src="${fileUrl}" class="chat-image" alt="${fileName}" loading="lazy">
                                    </div>
                                `;
                            } else {
                                let icon = getFileIcon(ext);
                                html += `
                                    <a href="${fileUrl}" target="_blank" class="file-attachment" download>
                                        <span class="file-icon">${icon}</span>
                                        <div class="file-info">
                                            <div class="file-name">${fileName}</div>
                                            <div class="file-size">${ext.toUpperCase()}</div>
                                        </div>
                                        <span style="font-size: 20px;">⬇️</span>
                                    </a>
                                `;
                            }
                        }

                        html += `<div class="message-time">${time}</div>`;
                        html += `</div></div>`;
                    });

                    messagesArea.innerHTML = html;
                    
                    let shouldScroll = messagesArea.scrollHeight - messagesArea.scrollTop - messagesArea.clientHeight < 150;
                    if (shouldScroll) {
                        messagesArea.scrollTop = messagesArea.scrollHeight;
                    }
                    
                    loadingMessages = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    messagesArea.innerHTML = '<div style="text-align: center; color: red; padding: 30px;">Error al cargar</div>';
                    loadingMessages = false;
                });
        }

        // Enviar mensaje
        formSend.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!receiver) {
                alert('Selecciona un chat');
                return;
            }

            if (!messageInput.value.trim() && !fileInput.files.length) {
                return;
            }

            let formData = new FormData(this);
            
            formData.append('receiver_id', receiver);
            formData.append('is_group', isGroupChat);

            sendBtn.disabled = true;
            sendBtn.style.opacity = '0.5';

            fetch('/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                messageInput.value = '';
                fileInput.value = '';
                preview.innerHTML = '';
                preview.style.display = 'none';
                loadMessages();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al enviar');
            })
            .finally(() => {
                sendBtn.disabled = false;
                sendBtn.style.opacity = '1';
            });
        });

        // Preview de archivo
        fileInput.addEventListener('change', function() {
            let file = this.files[0];
            if (!file) {
                preview.style.display = 'none';
                return;
            }

            let url = URL.createObjectURL(file);
            let ext = file.name.split('.').pop().toLowerCase();
            
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                preview.innerHTML = `
                    <img src="${url}" class="preview-image">
                    <div class="preview-file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-size">${formatFileSize(file.size)}</div>
                    </div>
                    <span class="remove-preview" onclick="removeFile()">✕</span>
                `;
            } else {
                let icon = getFileIcon(ext);
                preview.innerHTML = `
                    <span style="font-size: 35px;">${icon}</span>
                    <div class="preview-file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-size">${formatFileSize(file.size)}</div>
                    </div>
                    <span class="remove-preview" onclick="removeFile()">✕</span>
                `;
            }
            
            preview.style.display = 'flex';
        });

        function removeFile() {
            fileInput.value = '';
            preview.innerHTML = '';
            preview.style.display = 'none';
        }

        // Visor de imágenes
        function openViewer(src, caption = '') {
            document.getElementById('viewerImg').src = src;
            document.getElementById('viewerCaption').innerText = caption;
            document.getElementById('imageViewer').classList.add('active');
        }

        function closeViewer() {
            document.getElementById('imageViewer').classList.remove('active');
        }

        document.getElementById('viewerImg').addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Polling
        function startMessagePolling() {
            if (messageInterval) {
                clearInterval(messageInterval);
            }
            messageInterval = setInterval(() => {
                if (receiver) {
                    loadMessages();
                }
            }, 2000);
        }

        window.addEventListener('beforeunload', function() {
            if (messageInterval) {
                clearInterval(messageInterval);
            }
        });

        // Modal de grupo
        function abrirModal() {
            document.getElementById('modalGrupo').classList.add('active');
            if (isMobile) cerrarSidebar(); // Opcional: cerrar sidebar al abrir modal
        }

        function cerrarModal() {
            document.getElementById('modalGrupo').classList.remove('active');
            document.getElementById('nombreGrupoNuevo').value = '';
        }

        function guardarGrupo() {
            let nombre = document.getElementById('nombreGrupoNuevo').value;
            if (!nombre) {
                alert("Ingresa un nombre");
                return;
            }

            let checkboxes = document.querySelectorAll('.check-usuario:checked');
            let usuariosSeleccionados = Array.from(checkboxes).map(cb => cb.value);

            if (usuariosSeleccionados.length === 0) {
                alert("Selecciona al menos un integrante");
                return;
            }

            let formData = new FormData();
            formData.append('name', nombre);
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
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al crear');
            });
        }

        function eliminarGrupo(id) {
            if(confirm("¿Eliminar grupo?")) {
                fetch('/groups/' + id, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'ok') {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar');
                });
            }
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('modalGrupo').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModal();
            }
        });

        // Búsqueda de contactos
        searchInput.addEventListener('input', function() {
            let term = this.value.toLowerCase();
            let items = document.querySelectorAll('.contact-item');
            
            items.forEach(item => {
                let name = item.querySelector('.contact-name')?.textContent.toLowerCase() || '';
                if (name.includes(term)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Inicialización: ajustar UI según móvil/escritorio
        function initUI() {
            if (isMobile) {
                // En móvil: sidebar oculta al inicio
                contactsSidebar.classList.add('hidden-mobile');
                // Configurar header por defecto (sin chat seleccionado)
                chatAvatar.style.display = 'none';
                chatHeaderName.textContent = 'WhatsApp';
                chatHeaderStatus.textContent = '';
                welcomeMessage.style.display = 'flex';
                inputArea.style.display = 'none';
                // Asegurar que el botón hamburguesa se muestre
                hamburgerBtn.style.display = 'flex';
                backBtn.style.display = 'none';
            } else {
                // En escritorio: sidebar siempre visible
                contactsSidebar.classList.remove('hidden-mobile');
                hamburgerBtn.style.display = 'none';
                backBtn.style.display = 'flex';
                // Mostrar mensaje de bienvenida si no hay chat seleccionado
                if (!receiver) {
                    welcomeMessage.style.display = 'flex';
                    inputArea.style.display = 'none';
                    chatAvatar.style.display = 'none';
                    chatHeaderName.textContent = 'WhatsApp';
                    chatHeaderStatus.textContent = '';
                }
            }
        }

        // Detectar cambio de tamaño de ventana
        window.addEventListener('resize', function() {
            location.reload(); // Recargar para aplicar cambios de diseño correctamente
        });

        // Prevenir zoom en input (iOS)
        messageInput.addEventListener('touchstart', function() {
            this.style.fontSize = '16px';
        });

        // Inicializar
        initUI();

        // Debug
        window.debug = {
            state: () => ({ receiver, isGroupChat, currentUserId, isMobile })
        };
    </script>
</x-app-layout>