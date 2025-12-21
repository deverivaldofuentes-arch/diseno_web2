@extends('layouts.app')

@section('title', 'Mi Perfil - NovaMarket')

@section('content')
<div class="profile-container" style="max-width: 1200px; margin: 0 auto;">
    <h1 style="margin-bottom: 2rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        <i class="fas fa-user-circle"></i> Mi Perfil
    </h1>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        <!-- Información del Perfil -->
        <div class="glass-effect" style="padding: 2rem;">
            <h2 style="margin-bottom: 1.5rem; color: var(--light);">
                <i class="fas fa-info-circle"></i> Información Personal
            </h2>
            
            <div id="profileInfo">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <div style="font-weight: 600; color: var(--gray-light); margin-bottom: 0.25rem;">
                            <i class="fas fa-user"></i> Nombre
                        </div>
                        <div id="userName" style="font-size: 1.1rem; color: var(--light);"></div>
                    </div>
                    
                    <div>
                        <div style="font-weight: 600; color: var(--gray-light); margin-bottom: 0.25rem;">
                            <i class="fas fa-envelope"></i> Correo Electrónico
                        </div>
                        <div id="userEmail" style="font-size: 1.1rem; color: var(--light);"></div>
                    </div>
                    
                    <div>
                        <div style="font-weight: 600; color: var(--gray-light); margin-bottom: 0.25rem;">
                            <i class="fas fa-calendar"></i> Miembro desde
                        </div>
                        <div id="userCreated" style="font-size: 1.1rem; color: var(--light);"></div>
                    </div>
                </div>
                
                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button onclick="openEditForm()" class="btn-primary">
                        <i class="fas fa-edit"></i> Editar Perfil
                    </button>
                    <button onclick="openChangePasswordForm()" class="btn-secondary">
                        <i class="fas fa-key"></i> Cambiar Contraseña
                    </button>
                </div>
            </div>
            
            <!-- Formulario de Edición -->
            <form id="editProfileForm" style="display: none; flex-direction: column; gap: 1.5rem; margin-top: 2rem;">
                <h3 style="color: var(--light);">
                    <i class="fas fa-edit"></i> Editar Información
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="editName" style="font-weight: 600; color: var(--gray-light);">Nombre</label>
                    <input type="text" id="editName" name="name" required minlength="3"
                           style="padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                  background: rgba(255,255,255,0.05); color: var(--light); font-size: 1rem;">
                    <div class="error-message" id="editNameError" style="color: #f87171; font-size: 0.875rem;"></div>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="editEmail" style="font-weight: 600; color: var(--gray-light);">Correo Electrónico</label>
                    <input type="email" id="editEmail" name="email" required
                           style="padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                  background: rgba(255,255,255,0.05); color: var(--light); font-size: 1rem;">
                    <div class="error-message" id="editEmailError" style="color: #f87171; font-size: 0.875rem;"></div>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <button type="button" onclick="closeEditForm()" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </form>
            
            <!-- Formulario Cambiar Contraseña -->
            <form id="changePasswordForm" style="display: none; flex-direction: column; gap: 1.5rem; margin-top: 2rem;">
                <h3 style="color: var(--light);">
                    <i class="fas fa-key"></i> Cambiar Contraseña
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="currentPassword" style="font-weight: 600; color: var(--gray-light);">Contraseña Actual</label>
                    <input type="password" id="currentPassword" name="current_password" required
                           style="padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                  background: rgba(255,255,255,0.05); color: var(--light); font-size: 1rem;">
                    <div class="error-message" id="currentPasswordError" style="color: #f87171; font-size: 0.875rem;"></div>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="newPassword" style="font-weight: 600; color: var(--gray-light);">Nueva Contraseña</label>
                    <input type="password" id="newPassword" name="password" required minlength="8"
                           style="padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                  background: rgba(255,255,255,0.05); color: var(--light); font-size: 1rem;">
                    <div class="error-message" id="newPasswordError" style="color: #f87171; font-size: 0.875rem;"></div>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="confirmPassword" style="font-weight: 600; color: var(--gray-light);">Confirmar Nueva Contraseña</label>
                    <input type="password" id="confirmPassword" name="password_confirmation" required
                           style="padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                  background: rgba(255,255,255,0.05); color: var(--light); font-size: 1rem;">
                    <div class="error-message" id="confirmPasswordError" style="color: #f87171; font-size: 0.875rem;"></div>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Actualizar Contraseña
                    </button>
                    <button type="button" onclick="closeChangePasswordForm()" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Estadísticas -->
        <div class="glass-effect" style="padding: 2rem;">
            <h2 style="margin-bottom: 1.5rem; color: var(--light);">
                <i class="fas fa-chart-bar"></i> Mis Estadísticas
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem;">
                <div style="text-align: center; padding: 1.5rem; background: rgba(99, 102, 241, 0.1); border-radius: 12px;">
                    <div style="font-size: 2rem; color: var(--primary); margin-bottom: 0.5rem;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div id="ordersCount" style="font-size: 1.5rem; font-weight: 700; color: var(--light);">0</div>
                    <div style="color: var(--gray-light); font-size: 0.875rem;">Pedidos</div>
                </div>
                
                <div style="text-align: center; padding: 1.5rem; background: rgba(16, 185, 129, 0.1); border-radius: 12px;">
                    <div style="font-size: 2rem; color: var(--secondary); margin-bottom: 0.5rem;">
                        <i class="fas fa-store"></i>
                    </div>
                    <div id="tiendasCount" style="font-size: 1.5rem; font-weight: 700; color: var(--light);">0</div>
                    <div style="color: var(--gray-light); font-size: 0.875rem;">Tiendas</div>
                </div>
            </div>
            
            <!-- Últimos Pedidos -->
            <div style="margin-top: 2rem;">
                <h3 style="color: var(--light); margin-bottom: 1rem;">
                    <i class="fas fa-history"></i> Últimos Pedidos
                </h3>
                <div id="recentOrders" style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div style="text-align: center; padding: 1rem; color: var(--gray);">
                        <i class="fas fa-spinner"></i> Cargando pedidos...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async function() {
    await loadProfileData();
    await loadUserStats();
    await loadRecentOrders();
});

// Cargar datos del perfil
async function loadProfileData() {
    if (!window.NovaMarket.token) {
        window.location.href = '/login';
        return;
    }
    
    try {
        const response = await axios.get('/api/profile');
        const user = response.data;
        
        document.getElementById('userName').textContent = user.name;
        document.getElementById('userEmail').textContent = user.email;
        document.getElementById('userCreated').textContent = new Date(user.created_at).toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Rellenar formulario de edición
        document.getElementById('editName').value = user.name;
        document.getElementById('editEmail').value = user.email;
        
    } catch (error) {
        console.error('Error loading profile:', error);
        window.showAlert('Error al cargar el perfil', 'error');
    }
}

// Cargar estadísticas
async function loadUserStats() {
    try {
        // Obtener conteo de pedidos
        const ordersResponse = await axios.get('/api/pedidos');
        document.getElementById('ordersCount').textContent = ordersResponse.data.meta?.total || ordersResponse.data.length || 0;
        
        // Obtener conteo de tiendas (si el usuario es emprendedor)
        const tiendasResponse = await axios.get('/api/mis-tiendas');
        document.getElementById('tiendasCount').textContent = tiendasResponse.data.length || 0;
        
    } catch (error) {
        console.error('Error loading stats:', error);
    }
}

// Cargar pedidos recientes
async function loadRecentOrders() {
    try {
        const response = await axios.get('/api/pedidos?limit=5');
        const orders = response.data.data || response.data.slice(0, 5) || [];
        
        const container = document.getElementById('recentOrders');
        if (orders.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 1rem; color: var(--gray);">
                    <i class="fas fa-shopping-bag"></i> No hay pedidos recientes
                </div>
            `;
            return;
        }
        
        container.innerHTML = orders.map(order => `
            <a href="/pedidos/${order.id}" style="text-decoration: none; color: inherit;">
                <div style="display: flex; justify-content: space-between; align-items: center; 
                            padding: 0.75rem; background: rgba(255,255,255,0.05); 
                            border-radius: 8px; transition: var(--transition);">
                    <div>
                        <div style="font-weight: 600; color: var(--light);">Pedido #${order.id}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-light);">
                            ${new Date(order.created_at).toLocaleDateString('es-ES')}
                        </div>
                    </div>
                    <div>
                        <span style="padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; 
                                     background: ${getStatusColor(order.estado)};">
                            ${order.estado}
                        </span>
                    </div>
                </div>
            </a>
        `).join('');
        
    } catch (error) {
        console.error('Error loading recent orders:', error);
    }
}

function getStatusColor(status) {
    const colors = {
        'pendiente': 'rgba(251, 191, 36, 0.2)',
        'procesando': 'rgba(59, 130, 246, 0.2)',
        'enviado': 'rgba(16, 185, 129, 0.2)',
        'entregado': 'rgba(16, 185, 129, 0.3)',
        'cancelado': 'rgba(239, 68, 68, 0.2)'
    };
    return colors[status.toLowerCase()] || 'rgba(100, 116, 139, 0.2)';
}

// Funciones para mostrar/ocultar formularios
function openEditForm() {
    document.getElementById('profileInfo').style.display = 'none';
    document.getElementById('editProfileForm').style.display = 'flex';
}

function closeEditForm() {
    document.getElementById('profileInfo').style.display = 'block';
    document.getElementById('editProfileForm').style.display = 'none';
    document.querySelectorAll('#editProfileForm .error-message').forEach(el => el.textContent = '');
}

function openChangePasswordForm() {
    document.getElementById('profileInfo').style.display = 'none';
    document.getElementById('changePasswordForm').style.display = 'flex';
}

function closeChangePasswordForm() {
    document.getElementById('profileInfo').style.display = 'block';
    document.getElementById('changePasswordForm').style.display = 'none';
    document.querySelectorAll('#changePasswordForm .error-message').forEach(el => el.textContent = '');
    document.getElementById('changePasswordForm').reset();
}

// Actualizar perfil
document.getElementById('editProfileForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const button = this.querySelector('button[type="submit"]');
    const originalText = window.showLoading(button);
    
    const formData = {
        name: document.getElementById('editName').value,
        email: document.getElementById('editEmail').value
    };
    
    try {
        const response = await axios.put('/api/profile', formData);
        
        // Actualizar en localStorage
        const user = JSON.parse(localStorage.getItem('user') || '{}');
        user.name = formData.name;
        user.email = formData.email;
        localStorage.setItem('user', JSON.stringify(user));
        
        // Actualizar estado global
        window.NovaMarket.user = user;
        
        // Actualizar UI
        document.getElementById('userName').textContent = formData.name;
        document.getElementById('userEmail').textContent = formData.email;
        
        window.showAlert('Perfil actualizado correctamente', 'success');
        closeEditForm();
        
    } catch (error) {
        window.hideLoading(button, originalText);
        
        if (error.response?.data?.errors) {
            const errors = error.response.data.errors;
            Object.keys(errors).forEach(key => {
                const errorEl = document.getElementById('edit' + key.charAt(0).toUpperCase() + key.slice(1) + 'Error');
                if (errorEl) {
                    errorEl.textContent = errors[key][0];
                }
            });
        } else {
            window.showAlert('Error al actualizar el perfil', 'error');
        }
    }
});

// Cambiar contraseña
document.getElementById('changePasswordForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const button = this.querySelector('button[type="submit"]');
    const originalText = window.showLoading(button);
    
    const formData = {
        current_password: document.getElementById('currentPassword').value,
        password: document.getElementById('newPassword').value,
        password_confirmation: document.getElementById('confirmPassword').value
    };
    
    // Validar que las contraseñas coincidan
    if (formData.password !== formData.password_confirmation) {
        window.hideLoading(button, originalText);
        document.getElementById('confirmPasswordError').textContent = 'Las contraseñas no coinciden';
        return;
    }
    
    try {
        await axios.put('/api/profile/password', formData);
        
        window.showAlert('Contraseña actualizada correctamente', 'success');
        closeChangePasswordForm();
        
    } catch (error) {
        window.hideLoading(button, originalText);
        
        if (error.response?.data?.errors) {
            const errors = error.response.data.errors;
            Object.keys(errors).forEach(key => {
                const errorEl = document.getElementById(key + 'Error');
                if (errorEl) {
                    errorEl.textContent = errors[key][0];
                }
            });
        } else if (error.response?.data?.message) {
            window.showAlert(error.response.data.message, 'error');
        } else {
            window.showAlert('Error al cambiar la contraseña', 'error');
        }
    }
});
</script>
@endsection
