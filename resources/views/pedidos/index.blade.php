@extends('layouts.app')

@section('title', 'Mis Pedidos - NovaMarket')

@section('content')
<div class="orders-container" style="max-width: 1200px; margin: 0 auto;">
    <h1 style="margin-bottom: 1rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        <i class="fas fa-receipt"></i> Mis Pedidos
    </h1>
    <p style="color: var(--gray-light); margin-bottom: 2rem;">Revisa el estado de tus pedidos y su historial</p>
    
    <!-- Filtros -->
    <div class="glass-effect" style="padding: 1.5rem; margin-bottom: 2rem;">
        <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--gray-light); font-weight: 600;">
                    Estado del Pedido
                </label>
                <select id="statusFilter" style="padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                               background: rgba(255,255,255,0.05); color: var(--light); min-width: 200px;">
                    <option value="">Todos los estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="procesando">Procesando</option>
                    <option value="enviado">Enviado</option>
                    <option value="entregado">Entregado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--gray-light); font-weight: 600;">
                    Fecha
                </label>
                <select id="dateFilter" style="padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                             background: rgba(255,255,255,0.05); color: var(--light); min-width: 200px;">
                    <option value="">Todas las fechas</option>
                    <option value="last_month">Último mes</option>
                    <option value="last_3_months">Últimos 3 meses</option>
                    <option value="last_6_months">Últimos 6 meses</option>
                    <option value="last_year">Último año</option>
                </select>
            </div>
            
            <div style="margin-left: auto;">
                <button onclick="clearFilters()" class="btn-secondary">
                    <i class="fas fa-redo"></i> Limpiar Filtros
                </button>
            </div>
        </div>
    </div>
    
    <!-- Estadísticas -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="glass-effect" style="padding: 1.5rem; border-radius: 12px;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(99, 102, 241, 0.2); 
                            display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.5rem;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--light);" id="pendingCount">0</div>
                    <div style="color: var(--gray-light);">Pendientes</div>
                </div>
            </div>
        </div>
        
        <div class="glass-effect" style="padding: 1.5rem; border-radius: 12px;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(16, 185, 129, 0.2); 
                            display: flex; align-items: center; justify-content: center; color: var(--secondary); font-size: 1.5rem;">
                    <i class="fas fa-truck"></i>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--light);" id="deliveredCount">0</div>
                    <div style="color: var(--gray-light);">Entregados</div>
                </div>
            </div>
        </div>
        
        <div class="glass-effect" style="padding: 1.5rem; border-radius: 12px;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(139, 92, 246, 0.2); 
                            display: flex; align-items: center; justify-content: center; color: #8b5cf6; font-size: 1.5rem;">
                    <i class="fas fa-box"></i>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--light);" id="totalCount">0</div>
                    <div style="color: var(--gray-light);">Total Pedidos</div>
                </div>
            </div>
        </div>
        
        <div class="glass-effect" style="padding: 1.5rem; border-radius: 12px;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(245, 158, 11, 0.2); 
                            display: flex; align-items: center; justify-content: center; color: #f59e0b; font-size: 1.5rem;">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--light);" id="totalSpent">$0</div>
                    <div style="color: var(--gray-light);">Total Gastado</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Lista de Pedidos -->
    <div id="ordersList">
        <div style="text-align: center; padding: 3rem; color: var(--gray);">
            <div class="loading" style="width: 40px; height: 40px; margin: 0 auto 1rem;"></div>
            <div>Cargando tus pedidos...</div>
        </div>
    </div>
    
    <!-- No hay pedidos -->
    <div id="noOrders" style="display: none; text-align: center; padding: 4rem;">
        <i class="fas fa-shopping-bag" style="font-size: 4rem; color: var(--gray); margin-bottom: 1rem;"></i>
        <h2 style="color: var(--light); margin-bottom: 0.5rem;">No tienes pedidos aún</h2>
        <p style="color: var(--gray-light); margin-bottom: 2rem;">Cuando hagas un pedido, aparecerá aquí</p>
        <a href="/productos" class="btn-primary">
            <i class="fas fa-store"></i> Comenzar a Comprar
        </a>
    </div>
    
    <!-- Paginación -->
    <div id="pagination" style="margin-top: 2rem; display: flex; justify-content: center;"></div>
</div>

<script>
let orders = [];
let currentPage = 1;
let totalPages = 1;
let filters = {
    estado: '',
    fecha: ''
};

document.addEventListener('DOMContentLoaded', async function() {
    await loadOrders();
    setupEventListeners();
});

async function loadOrders(page = 1) {
    currentPage = page;
    
    try {
        document.getElementById('ordersList').innerHTML = `
            <div style="text-align: center; padding: 3rem; color: var(--gray);">
                <div class="loading" style="width: 40px; height: 40px; margin: 0 auto 1rem;"></div>
                <div>Cargando tus pedidos...</div>
            </div>
        `;
        
        // Construir URL con filtros
        let url = `/api/pedidos?page=${page}`;
        
        const params = [];
        if (filters.estado) params.push(`estado=${filters.estado}`);
        if (filters.fecha) params.push(`fecha=${filters.fecha}`);
        
        if (params.length > 0) {
            url += '&' + params.join('&');
        }
        
        const response = await axios.get(url);
        orders = response.data.data || response.data;
        totalPages = response.data.meta?.last_page || 1;
        
        renderOrders();
        updateStats();
        renderPagination();
        
    } catch (error) {
        console.error('Error loading orders:', error);
        
        if (error.response?.status === 401) {
            window.showAlert('Debes iniciar sesión para ver tus pedidos', 'error');
            window.location.href = '/login';
        } else {
            document.getElementById('ordersList').innerHTML = `
                <div style="text-align: center; padding: 3rem; color: #f87171;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                    <h3>Error al cargar los pedidos</h3>
                    <button onclick="loadOrders()" class="btn-secondary" style="margin-top: 1rem;">
                        <i class="fas fa-redo"></i> Reintentar
                    </button>
                </div>
            `;
        }
    }
}

function renderOrders() {
    const container = document.getElementById('ordersList');
    
    if (orders.length === 0) {
        document.getElementById('noOrders').style.display = 'block';
        container.innerHTML = '';
        return;
    }
    
    document.getElementById('noOrders').style.display = 'none';
    
    container.innerHTML = orders.map(order => `
        <div class="glass-effect" style="padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div>
                    <h3 style="color: var(--light); margin-bottom: 0.25rem;">
                        <a href="/pedidos/${order.id}" style="color: inherit; text-decoration: none;">
                            Pedido #${order.id}
                        </a>
                    </h3>
                    <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.875rem; color: var(--gray-light);">
                        <span>
                            <i class="fas fa-calendar"></i> 
                            ${new Date(order.created_at).toLocaleDateString('es-ES', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            })}
                        </span>
                        <span>•</span>
                        <span>
                            <i class="fas fa-box"></i> 
                            ${order.items?.length || 0} producto${order.items?.length !== 1 ? 's' : ''}
                        </span>
                    </div>
                </div>
                
                <div>
                    <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.875rem; font-weight: 600; 
                                background: ${getStatusColor(order.estado)};">
                        ${getStatusText(order.estado)}
                    </span>
                </div>
            </div>
            
            <!-- Items del Pedido -->
            <div style="margin-bottom: 1.5rem;">
                ${(order.items || []).slice(0, 2).map(item => `
                    <div style="display: flex; gap: 1rem; padding: 1rem; border-bottom: 1px solid var(--glass-border); align-items: center;">
                        <div style="width: 60px; height: 60px; border-radius: 8px; overflow: hidden; flex-shrink: 0;">
                            <img src="${item.producto?.imagen_url || 'https://via.placeholder.com/60x60'}" 
                                 alt="${item.producto?.nombre}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: var(--light);">
                                ${item.producto?.nombre || 'Producto'}
                            </div>
                            <div style="font-size: 0.875rem; color: var(--gray-light);">
                                Cantidad: ${item.cantidad} × $${parseFloat(item.precio).toFixed(2)}
                            </div>
                        </div>
                        <div style="color: var(--light); font-weight: 600;">
                            $${(parseFloat(item.precio) * item.cantidad).toFixed(2)}
                        </div>
                    </div>
                `).join('')}
                
                ${order.items && order.items.length > 2 ? `
                    <div style="text-align: center; padding: 0.75rem; color: var(--primary);">
                        <i class="fas fa-ellipsis-h"></i>
                        y ${order.items.length - 2} producto${order.items.length - 2 !== 1 ? 's' : ''} más
                    </div>
                ` : ''}
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-light);">Total del pedido</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
                        $${parseFloat(order.total).toFixed(2)}
                    </div>
                </div>
                
                <div style="display: flex; gap: 1rem;">
                    <a href="/pedidos/${order.id}" class="btn-secondary">
                        <i class="fas fa-eye"></i> Ver Detalles
                    </a>
                    
                    ${order.estado === 'pendiente' ? `
                    <button onclick="cancelOrder(${order.id})" class="btn-secondary" style="background: rgba(239, 68, 68, 0.1); color: #f87171;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    ` : ''}
                    
                    ${order.estado === 'entregado' ? `
                    <button onclick="reorder(${order.id})" class="btn-primary">
                        <i class="fas fa-redo"></i> Volver a Pedir
                    </button>
                    ` : ''}
                </div>
            </div>
        </div>
    `).join('');
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

function getStatusText(status) {
    const texts = {
        'pendiente': 'Pendiente',
        'procesando': 'Procesando',
        'enviado': 'Enviado',
        'entregado': 'Entregado',
        'cancelado': 'Cancelado'
    };
    return texts[status.toLowerCase()] || status;
}

function updateStats() {
    const pending = orders.filter(o => o.estado === 'pendiente').length;
    const delivered = orders.filter(o => o.estado === 'entregado').length;
    const totalOrders = orders.length;
    const totalSpent = orders.reduce((sum, order) => sum + parseFloat(order.total), 0);
    
    document.getElementById('pendingCount').textContent = pending;
    document.getElementById('deliveredCount').textContent = delivered;
    document.getElementById('totalCount').textContent = totalOrders;
    document.getElementById('totalSpent').textContent = `$${totalSpent.toFixed(2)}`;
}

function renderPagination() {
    const pagination = document.getElementById('pagination');
    
    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }
    
    let html = '';
    
    // Botón anterior
    if (currentPage > 1) {
        html += `
            <button onclick="loadOrders(${currentPage - 1})" class="btn-secondary" 
                    style="padding: 8px 16px; border-radius: 8px 0 0 8px;">
                <i class="fas fa-chevron-left"></i>
            </button>
        `;
    }
    
    // Páginas
    const maxVisible = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
    let endPage = Math.min(totalPages, startPage + maxVisible - 1);
    
    if (endPage - startPage + 1 < maxVisible) {
        startPage = Math.max(1, endPage - maxVisible + 1);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        html += `
            <button onclick="loadOrders(${i})" 
                    class="${i === currentPage ? 'btn-primary' : 'btn-secondary'}" 
                    style="padding: 8px 16px;">
                ${i}
            </button>
        `;
    }
    
    // Botón siguiente
    if (currentPage < totalPages) {
        html += `
            <button onclick="loadOrders(${currentPage + 1})" class="btn-secondary" 
                    style="padding: 8px 16px; border-radius: 0 8px 8px 0;">
                <i class="fas fa-chevron-right"></i>
            </button>
        `;
    }
    
    pagination.innerHTML = html;
}

function setupEventListeners() {
    document.getElementById('statusFilter').addEventListener('change', function() {
        filters.estado = this.value;
        loadOrders(1);
    });
    
    document.getElementById('dateFilter').addEventListener('change', function() {
        filters.fecha = this.value;
        loadOrders(1);
    });
}

function clearFilters() {
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFilter').value = '';
    
    filters = {
        estado: '',
        fecha: ''
    };
    
    loadOrders(1);
}

async function cancelOrder(orderId) {
    if (!confirm('¿Estás seguro de que deseas cancelar este pedido?')) {
        return;
    }
    
    try {
        const response = await axios.put(`/api/pedidos/${orderId}/cancelar`);
        
        window.showAlert('Pedido cancelado exitosamente', 'success');
        loadOrders(currentPage);
        
    } catch (error) {
        console.error('Error cancelling order:', error);
        window.showAlert(error.response?.data?.message || 'Error al cancelar el pedido', 'error');
    }
}

async function reorder(orderId) {
    try {
        const response = await axios.post(`/api/pedidos/${orderId}/reordenar`);
        
        window.showAlert('Productos agregados al carrito', 'success');
        
        // Actualizar carrito
        if (response.data.cart) {
            localStorage.setItem('cart', JSON.stringify(response.data.cart));
            window.NovaMarket.cart = response.data.cart;
            updateCartCount();
        }
        
        // Redirigir al carrito
        setTimeout(() => {
            window.location.href = '/carrito';
        }, 1000);
        
    } catch (error) {
        console.error('Error reordering:', error);
        window.showAlert(error.response?.data?.message || 'Error al reordenar', 'error');
    }
}

function updateCartCount() {
    const cartCount = document.getElementById('cartCount');
    if (cartCount) {
        const cart = window.NovaMarket.cart || { count: 0 };
        cartCount.textContent = cart.count || 0;
    }
}
</script>
@endsection
