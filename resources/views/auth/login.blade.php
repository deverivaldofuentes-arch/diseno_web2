@extends('layouts.app')

@section('title', 'Iniciar Sesión - NovaMarket')

@section('content')
<div class="auth-container" style="max-width: 400px; margin: 0 auto; padding: 2rem;">
    <div class="glass-effect" style="padding: 2rem;">
        <h2 style="text-align: center; margin-bottom: 2rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
        </h2>
        
        <form id="loginForm" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label for="email" style="font-weight: 600; color: var(--gray-light);">
                    <i class="fas fa-envelope"></i> Correo Electrónico
                </label>
                <input type="email" id="email" name="email" required
                       style="padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); 
                              background: rgba(255,255,255,0.05); color: var(--light); font-size: 1rem;">
                <div class="error-message" id="emailError" style="color: #f87171; font-size: 0.875rem;"></div>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label for="password" style="font-weight: 600; color: var(--gray-light);">
                    <i class="fas fa-lock"></i> Contraseña
                </label>
                <input type="password" id="password" name="password" required
                       style="padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); 
                              background: rgba(255,255,255,0.05); color: var(--light); font-size: 1rem;">
                <div class="error-message" id="passwordError" style="color: #f87171; font-size: 0.875rem;"></div>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" id="remember" name="remember"
                           style="accent-color: var(--primary);">
                    <span style="color: var(--gray-light);">Recordarme</span>
                </label>
                
                <a href="#" style="color: var(--primary); text-decoration: none; font-size: 0.875rem;">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
            
            <button type="submit" class="btn-primary" style="width: 100%;">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
            
            <div style="text-align: center; color: var(--gray-light);">
                ¿No tienes cuenta? 
                <a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none;">
                    Regístrate aquí
                </a>
            </div>
        </form>
        
        <div id="errorContainer" style="margin-top: 1rem;"></div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const button = form.querySelector('button[type="submit"]');
    const originalText = window.showLoading(button);
    
    // Limpiar errores anteriores
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    document.getElementById('errorContainer').innerHTML = '';
    
    const formData = {
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        remember: document.getElementById('remember').checked
    };
    
    try {
        const response = await axios.post('/api/login', formData);
        
        if (response.data.access_token) {
            // Guardar token y datos de usuario
            localStorage.setItem('token', response.data.access_token);
            localStorage.setItem('user', JSON.stringify(response.data.user));
            
            // Configurar headers para futuras peticiones
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.access_token;
            
            // Actualizar estado global
            window.NovaMarket.token = response.data.access_token;
            window.NovaMarket.user = response.data.user;
            
            // Mostrar mensaje de éxito
            window.showAlert('¡Sesión iniciada correctamente! Redirigiendo...', 'success');
            
            // Redirigir después de 1 segundo
            setTimeout(() => {
                window.location.href = '/';
            }, 1000);
        }
    } catch (error) {
        window.hideLoading(button, originalText);
        
        if (error.response?.data?.errors) {
            // Mostrar errores de validación
            const errors = error.response.data.errors;
            Object.keys(errors).forEach(key => {
                const errorEl = document.getElementById(key + 'Error');
                if (errorEl) {
                    errorEl.textContent = errors[key][0];
                }
            });
        } else if (error.response?.data?.message) {
            // Mostrar error general
            document.getElementById('errorContainer').innerHTML = `
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> ${error.response.data.message}
                </div>
            `;
        } else {
            document.getElementById('errorContainer').innerHTML = `
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> Error al iniciar sesión
                </div>
            `;
        }
    }
});
</script>
@endsection
