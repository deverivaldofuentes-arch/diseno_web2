class AuthManager {
    constructor() {
        this.token = localStorage.getItem('token');
        this.user = JSON.parse(localStorage.getItem('user') || 'null');
    }

    // Verificar autenticación
    isAuthenticated() {
        return !!this.token;
    }

    // Verificar si es emprendedor
    isEmprendedor() {
        return this.user?.role === 'emprendedor' || this.user?.tiene_tienda === true;
    }

    // Verificar si es administrador
    isAdmin() {
        return this.user?.role === 'admin';
    }

    // Guardar sesión
    saveSession(token, user) {
        this.token = token;
        this.user = user;
        
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(user));
        
        // Actualizar headers de Axios
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        
        // Actualizar estado global
        window.NovaMarket.token = token;
        window.NovaMarket.user = user;
        
        // Actualizar UI
        this.updateAuthUI();
    }

    // Cerrar sesión
    logout() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        localStorage.removeItem('cart');
        
        this.token = null;
        this.user = null;
        
        // Remover headers de Axios
        delete axios.defaults.headers.common['Authorization'];
        
        // Actualizar estado global
        window.NovaMarket.token = null;
        window.NovaMarket.user = null;
        window.NovaMarket.cart = { items: [], count: 0 };
        
        // Actualizar UI
        this.updateAuthUI();
        
        // Redirigir al home
        window.location.href = '/';
    }

    // Actualizar UI de autenticación
    updateAuthUI() {
        const authSection = document.getElementById('authSection');
        if (!authSection) return;

        if (this.isAuthenticated()) {
            authSection.innerHTML = `
                <div class="user-dropdown">
                    <div class="user-avatar" onclick="this.nextElementSibling.classList.toggle('active')">
                        ${this.user?.name?.charAt(0).toUpperCase() || 'U'}
                    </div>
                    <div class="dropdown-menu glass-effect">
                        <a href="/profile" class="dropdown-item">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                        ${this.isEmprendedor() ? `
                        <a href="/mis-tiendas" class="dropdown-item">
                            <i class="fas fa-store"></i> Mis Tiendas
                        </a>
                        ` : ''}
                        <a href="/pedidos" class="dropdown-item">
                            <i class="fas fa-receipt"></i> Mis Pedidos
                        </a>
                        <div class="dropdown-divider"></div>
                        <button onclick="authManager.logout()" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </div>
                </div>
            `;
        } else {
            authSection.innerHTML = `
                <a href="/login" class="btn-secondary">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
                <a href="/register" class="btn-primary">
                    <i class="fas fa-user-plus"></i> Registrarse
                </a>
            `;
        }
    }

    // Validar token
    async validateToken() {
        if (!this.token) return false;

        try {
            const response = await axios.get('/api/profile');
            return response.status === 200;
        } catch (error) {
            if (error.response?.status === 401) {
                this.logout();
            }
            return false;
        }
    }

    // Proteger rutas
    protectRoute() {
        if (!this.isAuthenticated()) {
            window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
            return false;
        }
        return true;
    }

    // Proteger rutas de emprendedor
    protectEmprendedorRoute() {
        if (!this.isAuthenticated()) {
            window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
            return false;
        }
        
        if (!this.isEmprendedor()) {
            window.showAlert('Esta sección es solo para emprendedores', 'error');
            window.location.href = '/';
            return false;
        }
        
        return true;
    }

    // Proteger rutas de admin
    protectAdminRoute() {
        if (!this.isAuthenticated()) {
            window.location.href = '/login';
            return false;
        }
        
        if (!this.isAdmin()) {
            window.showAlert('Acceso no autorizado', 'error');
            window.location.href = '/';
            return false;
        }
        
        return true;
    }
}

// Instanciar y exportar
const authManager = new AuthManager();
window.authManager = authManager;

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    // Validar token periódicamente
    if (authManager.isAuthenticated()) {
        setInterval(() => {
            authManager.validateToken();
        }, 5 * 60 * 1000); // Cada 5 minutos
    }
    
    // Actualizar UI
    authManager.updateAuthUI();
});
