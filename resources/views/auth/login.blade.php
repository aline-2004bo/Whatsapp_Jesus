<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp · Log In</title>
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
        
        .login-container {
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
        .login-container::before {
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
            margin-bottom: 40px;
            font-weight: 400;
        }
        
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
        
        .login-btn {
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
            margin-top: 15px;
            margin-bottom: 25px;
            box-shadow: 0 10px 20px rgba(0, 168, 132, 0.3);
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 168, 132, 0.4);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .forgot-password {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .forgot-password a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .forgot-password a:hover {
            color: #00a884;
        }
        
        .signup-section {
            text-align: center;
            border-top: 2px solid #f0f0f0;
            padding-top: 25px;
            margin-top: 5px;
        }
        
        .signup-text {
            color: #666;
            font-size: 15px;
            margin-bottom: 15px;
        }
        
        .signup-btn {
            display: inline-block;
            padding: 12px 35px;
            background: transparent;
            border: 2px solid #00a884;
            color: #00a884;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .signup-btn:hover {
            background: #00a884;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 168, 132, 0.2);
        }
        
        .signup-btn i {
            margin-right: 8px;
        }
        
        /* Estilo para mensajes de error - CORREGIDO */
        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .error-message i {
            font-size: 12px;
        }
        
        /* Estilo para mensajes de sesión */
        .session-status {
            background: #f0f9f7;
            border: 1px solid #00a884;
            color: #008069;
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .session-status i {
            color: #00a884;
            font-size: 16px;
        }
        
        /* Adaptación para móviles */
        @media (max-width: 480px) {
            .login-container {
                padding: 40px 25px;
            }
            
            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    
    <!-- Icono de WhatsApp -->
    <div class="whatsapp-icon">
        <i class="fab fa-whatsapp"></i>
    </div>
    
    <!-- Título y subtítulo exactamente como en el diseño -->
    <h1>Log In</h1>
    <div class="subtitle">Login here using your username and password</div>
    
    <!-- Mensaje de sesión -->
    @if (session('status'))
        <div class="session-status">
            <i class="fas fa-info-circle"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif
    
    <!-- FORMULARIO LOGIN -->
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <!-- Campo Username/Email -->
        <div class="input-group">
            <label class="input-label">
                <i class="fas fa-user" style="margin-right: 5px; color: #00a884;"></i>
                @UserName
            </label>
            <div class="input-wrapper">
                <i class="fas fa-user input-icon"></i>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    class="input-field" 
                    placeholder="Enter your username or email"
                    required
                >
            </div>
            <!-- CORRECCIÓN: Mostrar errores sin usar $message -->
            @error('email')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <!-- Campo Password -->
        <div class="input-group">
            <label class="input-label">
                <i class="fas fa-lock" style="margin-right: 5px; color: #00a884;"></i>
                Password
            </label>
            <div class="input-wrapper">
                <i class="fas fa-lock input-icon"></i>
                <input 
                    type="password" 
                    name="password" 
                    class="input-field" 
                    placeholder="Enter your password"
                    required
                >
            </div>
            <!-- CORRECCIÓN: Mostrar errores sin usar $message -->
            @error('password')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <!-- Checkbox Recordarme (oculto pero funcional) -->
        <input type="checkbox" name="remember" id="remember" checked style="display: none;">
        
        <!-- Botón Log In -->
        <button type="submit" class="login-btn">
            <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
            Log In
        </button>
        
        <!-- Forgot Password -->
        <div class="forgot-password">
            <a href="{{ route('password.request') }}">
                <i class="fas fa-question-circle"></i>
                Forgot Password
            </a>
        </div>
        
    </form>
    
    <!-- Sign Up Section -->
    <div class="signup-section">
        <div class="signup-text">Don't have an account?</div>
        <a href="{{ route('register') }}" class="signup-btn">
            <i class="fas fa-user-plus"></i>
            Sign Up
        </a>
    </div>
    
</div>

<!-- Script para mantener la funcionalidad del checkbox recordarme -->
<script>
    // El checkbox está oculto pero funcional - siempre marcado por defecto
    document.getElementById('remember').checked = true;
</script>

</body>
</html>