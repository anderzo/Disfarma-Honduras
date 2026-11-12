<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario - DISFARMA HONDURAS</title>
    
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>
<body>

    <div class="login-wrapper">
        <div class="login-bg-shape login-bg-shape-1"></div>
        <div class="login-bg-shape login-bg-shape-2"></div>
        
        <div class="login-card">
            <a href="{{ route('login') }}" class="login-brand text-decoration-none">
                <i class="bi bi-asterisk"></i>
                <span>DISFARMA HONDURAS</span>
            </a>
            
            <p class="login-subtitle">Registro de nuevo personal autorizado</p>
            
            <form action="{{ route('register.post') }}" method="POST" novalidate>
                @csrf

                <!-- Nombre de Usuario -->
                <div class="login-form-group">
                    <label for="usuario" class="login-form-label">Nombre de Usuario</label>
                    <div class="login-input-group">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="usuario" id="usuario" 
                               class="login-input @error('usuario') is-invalid @enderror" 
                               value="{{ old('usuario') }}" 
                               placeholder="Ej. jperez" required>
                    </div>
                    @error('usuario')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="login-form-group">
                    <label for="correo" class="login-form-label">Correo Institucional</label>
                    <div class="login-input-group">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="correo" id="correo" 
                               class="login-input @error('correo') is-invalid @enderror" 
                               value="{{ old('correo') }}" 
                               placeholder="usuario@disfarma.hn" required>
                    </div>
                    @error('correo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Contraseña -->
                <div class="login-form-group">
                    <label for="password" class="login-form-label">Contraseña</label>
                    <div class="login-input-group">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" name="password" id="password" 
                               class="login-input @error('password') is-invalid @enderror" 
                               placeholder="Mínimo 6 caracteres" required>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn-login mt-3">
                    <span>Crear Cuenta</span>
                    <i class="bi bi-person-check"></i>
                </button>
            </form>
            
            <p class="login-footer-text mt-4">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
            </p>
        </div>
    </div>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>