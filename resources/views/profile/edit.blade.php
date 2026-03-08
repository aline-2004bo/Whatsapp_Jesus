<x-app-layout>
    <!-- Font Awesome para iconos (si no está ya en app.blade.php) -->
    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @endpush

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .profile-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .profile-card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }
        
        /* Efecto decorativo superior */
        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, #00a884, #008069, #00a884);
        }
        
        /* Cabecera con gradiente */
        .profile-header {
            background: linear-gradient(145deg, #00a884, #008069);
            padding: 40px 40px 60px 40px;
            color: white;
            position: relative;
        }
        
        .profile-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            background: white;
            border-radius: 30px 30px 0 0;
        }
        
        .profile-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .profile-title i {
            font-size: 32px;
        }
        
        .profile-subtitle {
            font-size: 16px;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Contenido del perfil */
        .profile-content {
            padding: 40px;
            background: white;
        }
        
        /* Sección de avatar */
        .avatar-section {
            text-align: center;
            margin-top: -80px;
            margin-bottom: 40px;
            position: relative;
        }
        
        .avatar-wrapper {
            display: inline-block;
            position: relative;
        }
        
        .avatar-preview {
            width: 120px;
            height: 120px;
            border-radius: 30px;
            background: linear-gradient(145deg, #00a884, #008069);
            border: 4px solid white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .avatar-preview i {
            font-size: 50px;
            color: white;
        }
        
        .avatar-upload {
            position: absolute;
            bottom: -10px;
            right: -10px;
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #00a884;
        }
        
        .avatar-upload:hover {
            transform: scale(1.1);
            background: #00a884;
        }
        
        .avatar-upload:hover i {
            color: white;
        }
        
        .avatar-upload i {
            color: #00a884;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        
        .avatar-upload input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        /* Grupos de input */
        .input-group {
            margin-bottom: 25px;
        }
        
        .input-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .input-label i {
            color: #00a884;
            margin-right: 8px;
        }
        
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            color: #00a884;
            font-size: 18px;
        }
        
        .input-field {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .input-field:focus {
            border-color: #00a884;
            background: white;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 168, 132, 0.1);
        }
        
        .input-field::placeholder {
            color: #999;
            font-weight: 300;
        }
        
        /* Grid de dos columnas para información adicional */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .info-card:hover {
            border-color: #00a884;
            box-shadow: 0 5px 15px rgba(0, 168, 132, 0.1);
        }
        
        .info-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            color: #00a884;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-card-header i {
            font-size: 20px;
        }
        
        .info-card-content {
            color: #333;
            font-size: 16px;
            font-weight: 500;
        }
        
        .info-card-content small {
            display: block;
            color: #666;
            font-size: 13px;
            margin-top: 5px;
            font-weight: 400;
        }
        
        /* Botón de guardar */
        .save-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(145deg, #00a884, #008069);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 30px 0 20px;
            box-shadow: 0 10px 20px rgba(0, 168, 132, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 168, 132, 0.4);
        }
        
        .save-btn:active {
            transform: translateY(0);
        }
        
        .save-btn i {
            font-size: 18px;
        }
        
        /* Mensajes de éxito/error */
        .alert-success {
            background: #f0f9f7;
            border-left: 4px solid #00a884;
            color: #008069;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }
        
        .alert-success i {
            color: #00a884;
            font-size: 20px;
        }
        
        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .error-message i {
            font-size: 12px;
        }
        
        /* Línea divisoria */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #8696a0;
            font-size: 12px;
            margin: 30px 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .divider::before {
            margin-right: 1rem;
        }
        
        .divider::after {
            margin-left: 1rem;
        }
        
        /* Adaptación para móviles */
        @media (max-width: 640px) {
            .profile-header {
                padding: 30px 20px 50px 20px;
            }
            
            .profile-content {
                padding: 30px 20px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .profile-title {
                font-size: 24px;
            }
        }
    </style>

    <div class="profile-container">
        <div class="profile-card">
            
            <!-- Cabecera decorativa -->
            <div class="profile-header">
                <div class="profile-title">
                    <i class="fab fa-whatsapp"></i>
                    Mi Perfil
                </div>
                <div class="profile-subtitle">
                    <i class="fas fa-user-circle"></i>
                    Gestiona tu información personal
                </div>
            </div>
            
            <div class="profile-content">
                
                <!-- Mensaje de éxito (si existe) -->
                @if (session('status') === 'profile-updated')
                    <div class="alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>¡Perfil actualizado correctamente!</span>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <!-- Sección de avatar mejorada -->
                    <div class="avatar-section">
                        <div class="avatar-wrapper">
                            <div class="avatar-preview">
                                @if (Auth::user()->avatar)
                                    <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar">
                                @else
                                    <i class="fas fa-user"></i>
                                @endif
                            </div>
                            <label class="avatar-upload">
                                <i class="fas fa-camera"></i>
                                <input type="file" name="avatar" accept="image/*">
                            </label>
                        </div>
                        <p style="color: #666; font-size: 13px; margin-top: 10px;">
                            <i class="fas fa-info-circle" style="color: #00a884;"></i>
                            Formatos: JPG, PNG. Máximo 2MB
                        </p>
                        @error('avatar')
                            <div class="error-message" style="justify-content: center;">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Grid de información adicional -->
                    <div class="info-grid">
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="fas fa-calendar-alt"></i>
                                Miembro desde
                            </div>
                            <div class="info-card-content">
                                {{ Auth::user()->created_at->format('d M, Y') }}
                                <small>Fecha de registro</small>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="fas fa-shield-alt"></i>
                                Estado de cuenta
                            </div>
                            <div class="info-card-content">
                                <span style="color: #00a884;">✓ Activa</span>
                                <small>Cuenta verificada</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Campo Nombre -->
                    <div class="input-group">
                        <label class="input-label" for="name">
                            <i class="fas fa-user"></i>
                            Nombre completo
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input 
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', Auth::user()->name) }}"
                                class="input-field"
                                placeholder="Tu nombre completo"
                                required
                            >
                        </div>
                        @error('name')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Campo Email -->
                    <div class="input-group">
                        <label class="input-label" for="email">
                            <i class="fas fa-envelope"></i>
                            Correo electrónico
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input 
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', Auth::user()->email) }}"
                                class="input-field"
                                placeholder="tu@email.com"
                                required
                            >
                        </div>
                        @error('email')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Divisor -->
                    <div class="divider">
                        <span>OPCIONES ADICIONALES</span>
                    </div>
                    
                    <!-- Botón Guardar Cambios -->
                    <button type="submit" class="save-btn">
                        <i class="fas fa-save"></i>
                        Guardar cambios
                    </button>
                    
                </form>
                
                <!-- Enlaces adicionales -->
                <div style="display: flex; justify-content: center; gap: 20px; margin-top: 20px;">
                    <a href="{{ route('password.request') }}" style="color: #666; text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-key" style="color: #00a884;"></i>
                        Cambiar contraseña
                    </a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #dc2626; text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-sign-out-alt"></i>
                        Cerrar sesión
                    </a>
                </div>
                
                <!-- Formulario oculto para logout -->
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
                
            </div>
        </div>
    </div>
    
    <!-- Script para previsualizar la imagen antes de subirla -->
    <script>
        document.querySelector('input[name="avatar"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.avatar-preview');
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    
</x-app-layout>