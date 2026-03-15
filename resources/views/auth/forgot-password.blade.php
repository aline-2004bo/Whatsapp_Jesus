<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp · Reset Password</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts para tipografía más elegante -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        .reset-container {
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            padding: 50px 40px;
            position: relative;
            overflow: hidden;
        }
        
        /* Efecto decorativo superior */
        .reset-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, #00a884, #008069, #00a884);
        }
        
        .whatsapp-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(145deg, #00a884, #008069);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(0, 168, 132, 0.3);
        }
        
        .whatsapp-icon i {
            font-size: 35px;
            color: white;
        }
        
        h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1e1e1e;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        
        .subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            font-weight: 400;
            line-height: 1.5;
        }
        
        .info-box {
            background: #f0f9f7;
            border-left: 4px solid #00a884;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }
        
        .info-box i {
            color: #00a884;
            font-size: 24px;
            flex-shrink: 0;
        }
        
        .info-box p {
            color: #2c3e50;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
        }
        
        .input-group {
            margin-bottom: 30px;
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
        
        .reset-btn {
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
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(0, 168, 132, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .reset-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 168, 132, 0.4);
        }
        
        .reset-btn:active {
            transform: translateY(0);
        }
        
        .reset-btn i {
            font-size: 18px;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .back-link a:hover {
            color: #00a884;
        }
        
        /* Estilo para mensajes de sesión */
        .session-status {
            background: #f0f9f7;
            border: 1px solid #00a884;
            color: #008069;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .session-status i {
            color: #00a884;
            font-size: 18px;
        }
        
        /* Estilo para mensajes de error */
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
        
        /* Adaptación para móviles */
        @media (max-width: 480px) {
            .reset-container {
                padding: 40px 25px;
            }
            
            h1 {
                font-size: 28px;
            }
            
            .info-box {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<div class="reset-container">
    
    <!-- Icono de WhatsApp -->
    <div class="whatsapp-icon">
        <i class="fab fa-whatsapp"></i>
    </div>
    
    <!-- Título -->
    <h1>Reset Password</h1>
    
    <!-- Subtítulo con instrucciones (mejorado) -->
    <div class="info-box">
        <i class="fas fa-lock"></i>
        <p>
            <strong>¿Olvidaste tu contraseña?</strong> No te preocupes. Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
        </p>
    </div>
    
    <!-- Session Status -->
    @if (session('status'))
        <div class="session-status">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif
    
    <!-- FORMULARIO DE RECUPERACIÓN -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
        <!-- Campo Email -->
        <div class="input-group">
            <label class="input-label" for="email">
                <i class="fas fa-envelope" style="margin-right: 5px; color: #00a884;"></i>
                Email Address
            </label>
            <div class="input-wrapper">
                <i class="fas fa-envelope input-icon"></i>
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    value="{{ old('email') }}"
                    class="input-field" 
                    placeholder="Enter your email address"
                    required
                    autofocus
                >
            </div>
            @error('email')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <!-- Botón de envío -->
        <button type="submit" class="reset-btn">
            <i class="fas fa-paper-plane"></i>
            Send Reset Link
        </button>
        
        <!-- Enlace para volver al login -->
        <div class="back-link">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left"></i>
                Back to Login
            </a>
        </div>
        
    </form>
    
    <!-- Footer sutil -->
    <div style="margin-top: 30px; text-align: center;">
        <p style="color: #999; font-size: 12px;">
            <i class="fas fa-shield-alt" style="margin-right: 5px;"></i>
            Tu información está segura y encriptada
        </p>
    </div>
    
</div>

</body>
</html>