@extends('layouts.app')

@section('title', 'Registrarse - NovaMarket')

@section('content')
<div class="auth-container" style="max-width: 400px; margin: 0 auto; padding: 2rem;">
    <div class="glass-effect" style="padding: 2rem;">
        <h2 style="text-align: center; margin-bottom: 2rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <i class="fas fa-user-plus"></i> Crear Cuenta
        </h2>
        
        <form id="registerForm" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label for="name" style="font-weight: 600; color: var(--gray-light);">
                    <i class="fas fa-user"></i> Nombre Completo
                </label>
                <input type="text" id="name" name="name" required minlength="3"
                       style="padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); 
                              background: rgba(255,255,255,0.05); color: var(--light); font-size: 1rem;">
                <div class="error-message" id="nameError" style="color: #f87171; font-size: 0.875rem;"></div>
            </div>
            
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
                <input type="password" id="password" name="password" required minlength="8"
                       style="padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); 
                              background: rgba(255,255,255,0.05); color: var(--light); font-size: 1rem;">
                <div class="error-message" id="passwordError" style="color: #f87171; font-size: 0.875rem;">
                    <div style="font-size: 0.75rem; margin-top: 0.25rem; color: var(--gray);">
                        Mínimo 8 caracteres
                    </div>
                </div>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label for="password_confirmation" style="font-weight: 600; color: var(--gray-light);">
                    <i class="fas fa-lock"></i> Confirmar Contraseña
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       style="padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); 
                              background: rgba(255,255,255,0.05); color: var(--light); font-size: 1rem;">
                <div class="error-message" id="password_confirmationError" style="color: #f87171; font-size: 0.875rem;"></div>
            </div>
            
            <div style="display: flex; align-items: start; gap: 0.5rem;">
                <input type="checkbox" id="terms" name="terms" required
                       style="margin-top: 0.3rem; accent-color: var(--primary);">
                <label for="terms" style="color: var(--gray-light); font-size: 0.875rem;">
                    Acepto los 
                    <a href="#" style="color: var(--primary); text-decoration: none;">Términos y Condiciones</a>
                    y la 
                    <a href="#" style="color: var(--primary); text-decoration: none;">Política de Privacidad</a>
                </label>
            </div>
            <div class="error-message" id="termsError" style="color: #f87171; font-size: 0.875rem;"></div>
            
            <button type="submit" class="btn-primary" style="width: 100%;">
                <i class="fas fa-user-plus"></i> Crear Cuenta
            </button>
            
            <div style="text-align: center; color: var(--gray-light);">
                ¿Ya tienes cuenta? 
                <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none;">
                    Inicia sesión aquí
                </a>
            </div>
        </form>
        
        <div id="errorContainer" style="margin-top: 1rem;"></div>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const button = form.querySelector('button[type="submit"]');
    const originalText = window.showLoading(button);
    
    // Limpiar errores anteriores
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    document.getElementById('errorContainer').innerHTML = '';
    
    // Validación de contraseñas
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirmation').value;
    
    if (password !== passwordConfirm) {
        window.hideLoading(button, originalText);
        document.getElementById('password_confirmationError').textContent = 'Las contraseñas no coinciden';
        return;
    }
    
    const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        password: password,
        password_confirmation: passwordConfirm,
        terms: document.getElementById('terms').checked
    };
    
    try {
        const response = await axios.post('/api/register', formData);
        
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
            window.showAlert('¡Cuenta creada correctamente! Redirigiendo...', 'success');
            
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
                    <i class="fas fa-exclamation-circle"></i> Error al crear la cuenta
                </div>
            `;
        }
    }
});
</script>
@endsection
