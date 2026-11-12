<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - DISFARMA HONDURAS</title>
    
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
            
            <p class="login-subtitle">Inicia sesión para acceder al sistema interno</p>

            @if(session('success'))
                <div class="alert alert-success py-2 small">{{ session('success') }}</div>
            @endif
            
            <form action="{{ route('login.post') }}" method="POST" id="loginForm" novalidate>
                @csrf
                
                <!-- Correo Institucional -->
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
                               class="login-input login-input-password @error('password') is-invalid @enderror" 
                               placeholder="••••••••" required>
                        <button type="button" class="password-toggle-btn" id="toggle-password" aria-label="Mostrar contraseña">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="login-options">
                    <label class="custom-control-label">
                        <input type="checkbox" name="remember" class="custom-checkbox-input" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                        <span>Recordar mi sesión</span>
                    </label>
                </div>
                
                <button type="submit" class="btn-login" id="btn-submit">
                    <span>Ingresar al Sistema</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>
            
            <p class="login-footer-text mt-4">
                ¿No tienes cuenta? <a href="{{ route('register') }}" id="link-register">Registrate</a>
            </p>
        </div>
    </div>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
</body>
</html>