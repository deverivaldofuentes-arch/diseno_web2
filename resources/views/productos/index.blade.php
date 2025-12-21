@extends('layouts.app')

@section('title', 'Productos - NovaMarket')

@section('content')
<div class="productos-container" style="max-width: 1400px; margin: 0 auto;">
    <h1 style="margin-bottom: 1rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        <i class="fas fa-boxes"></i> Catálogo de Productos
    </h1>
    <p style="color: var(--gray-light); margin-bottom: 2rem;">Descubre los mejores productos de nuestros emprendedores</p>
    
    <!-- Filtros y Búsqueda -->
    <div class="glass-effect" style="padding: 1.5rem; margin-bottom: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--gray-light); font-weight: 600;">
                    <i class="fas fa-search"></i> Buscar
                </label>
                <input type="text" id="searchInput" placeholder="Nombre del producto..." 
                       style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                              background: rgba(255,255,255,0.05); color: var(--light);">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--gray-light); font-weight: 600;">
                    <i class="fas fa-store"></i> Tienda
                </label>
                <select id="tiendaFilter" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                                 background: rgba(255,255,255,0.05); color: var(--light);">
                    <option value="">Todas las tiendas</option>
                    <!-- Se llenará con JS -->
                </select>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--gray-light); font-weight: 600;">
                    <i class="fas fa-tags"></i> Categoría
                </label>
                <select id="categoriaFilter" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                                    background: rgba(255,255,255,0.05); color: var(--light);">
                    <option value="">Todas las categorías</option>
                    <!-- Se llenará con JS -->
                </select>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--gray-light); font-weight: 600;">
                    <i class="fas fa-filter"></i> Ordenar por
                </label>
                <select id="sortFilter" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                               background: rgba(255,255,255,0.05); color: var(--light);">
                    <option value="recientes">Más recientes</option>
                    <option value="nombre_asc">Nombre (A-Z)</option>
                    <option value="nombre_desc">Nombre (Z-A)</option>
                    <option value="precio_asc">Precio (menor a mayor)</option>
                    <option value="precio_desc">Precio (mayor a menor)</option>
                    <option value="popularidad">Más populares</option>
                </select>
            </div>
        </div>
        
        <!-- Filtros de Precio -->
        <div style="margin-top: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--gray-light); font-weight: 600;">
                <i class="fas fa-money-bill-wave"></i> Rango de Precio
            </label>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <input type="number" id="minPrice" placeholder="Mínimo" min="0" step="0.01"
                       style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                              background: rgba(255,255,255,0.05); color: var(--light);">
                <span style="color: var(--gray-light);">-</span>
                <input type="number" id="maxPrice" placeholder="Máximo" min="0" step="0.01"
                       style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                              background: rgba(255,255,255,0.05); color: var(--light);">
                <button onclick="applyPriceFilter()" class="btn-secondary" style="padding: 10px 20px;">
                    <i class="fas fa-check"></i>
                </button>
                <button onclick="clearPriceFilter()" class="btn-secondary" style="padding: 10px 20px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Grid de Productos -->
    <div id="productosGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        <!-- Productos se cargarán aquí -->
    </div>
    
    <!-- Paginación -->
    <div id="pagination" style="margin-top: 3rem; display: flex; justify-content: center;"></div>
    
    <!-- Loading -->
    <div id="loadingProducts" style="text-align: center; padding: 3rem; color: var(--gray);">
        <div class="loading" style="width: 40px; height: 40px; margin: 0 auto 1rem;"></div>
        <div>Cargando productos...</div>
    </div>
    
    <!-- No hay resultados -->
    <div id="noResults" style="display: none; text-align: center; padding: 4rem; color: var(--gray);">
        <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem;"></i>
        <h3 style="color: var(--light); margin-bottom: 0.5rem;">No se encontraron productos</h3>
        <p>Intenta con otros filtros de búsqueda</p>
        <button onclick="clearAllFilters()" class="btn-primary" style="margin-top: 1rem;">
            <i class="fas fa-redo"></i> Limpiar filtros
        </button>
    </div>
</div>

<script>
let productos = [];
let tiendas = [];
let categorias = [];
let currentPage = 1;
let totalPages = 1;
let filters = {
    search: '',
    tienda: '',
    categoria: '',
    sort: 'recientes',
    minPrice: '',
    maxPrice: ''
};

document.addEventListener('DOMContentLoaded', async function() {
    await loadTiendas();
    await loadProductos();
    setupEventListeners();
});

// Cargar tiendas para el filtro
async function loadTiendas() {
    try {
        const response = await axios.get('/api/tiendas?limit=100');
        tiendas = response.data.data || response.data;
        
        const select = document.getElementById('tiendaFilter');
        tiendas.forEach(tienda => {
            const option = document.createElement('option');
            option.value = tienda.id;
            option.textContent = tienda.nombre;
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Error loading tiendas:', error);
    }
}

// Cargar productos
async function loadProductos(page = 1) {
    currentPage = page;
    
    try {
        document.getElementById('loadingProducts').style.display = 'block';
        document.getElementById('noResults').style.display = 'none';
        document.getElementById('productosGrid').innerHTML = '';
        
        // Construir URL con filtros
        let url = `/api/productos?page=${page}`;
        
        const params = [];
        if (filters.search) params.push(`search=${encodeURIComponent(filters.search)}`);
        if (filters.tienda) params.push(`tienda=${filters.tienda}`);
        if (filters.categoria) params.push(`categoria=${encodeURIComponent(filters.categoria)}`);
        if (filters.sort) params.push(`sort=${filters.sort}`);
        if (filters.minPrice) params.push(`min_price=${filters.minPrice}`);
        if (filters.maxPrice) params.push(`max_price=${filters.maxPrice}`);
        
        if (params.length > 0) {
            url += '&' + params.join('&');
        }
        
        const response = await axios.get(url);
        productos = response.data.data || response.data;
        totalPages = response.data.meta?.last_page || 1;
        
        // Actualizar categorías disponibles
        updateCategorias();
        
        // Renderizar productos
        renderProductosGrid();
        
        // Renderizar paginación
        renderPagination();
        
        // Mostrar/ocultar mensaje de no resultados
        if (productos.length === 0) {
            document.getElementById('noResults').style.display = 'block';
        }
        
    } catch (error) {
        console.error('Error loading productos:', error);
        window.showAlert('Error al cargar los productos', 'error');
    } finally {
        document.getElementById('loadingProducts').style.display = 'none';
    }
}

function renderProductosGrid() {
    const grid = document.getElementById('productosGrid');
    
    if (productos.length === 0) return;
    
    grid.innerHTML = productos.map(producto => `
        <div class="glass-effect" style="padding: 1.5rem; display: flex; flex-direction: column; 
                                         transition: var(--transition); cursor: pointer; height: 100%;"
             onclick="window.location.href='/productos/${producto.id}'">
            <!-- Imagen del Producto -->
            <div style="width: 100%; height: 200px; border-radius: 12px; overflow: hidden; margin-bottom: 1rem; position: relative;">
                <img src="${producto.imagen_url || 'https://via.placeholder.com/300x200'}" 
                     alt="${producto.nombre}" 
                     style="width: 100%; height: 100%; object-fit: cover;">
                
                <!-- Etiquetas -->
                <div style="position: absolute; top: 10px; left: 10px; display: flex; gap: 0.5rem;">
                    ${producto.destacado ? `
                    <span style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); 
                                 color: white; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                        <i class="fas fa-star"></i> Destacado
                    </span>
                    ` : ''}
                    
                    ${producto.stock <= 5 && producto.stock > 0 ? `
                    <span style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); 
                                 color: white; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                        <i class="fas fa-exclamation"></i> Últimas unidades
                    </span>
                    ` : ''}
                </div>
                
                <!-- Stock Agotado -->
                ${producto.stock <= 0 ? `
                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.7); 
                            display: flex; align-items: center; justify-content: center;">
                    <span style="background: #ef4444; color: white; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                        <i class="fas fa-times-circle"></i> Agotado
                    </span>
                </div>
                ` : ''}
            </div>
            
            <!-- Información del Producto -->
            <div style="flex: 1;">
                <h3 style="margin-bottom: 0.5rem; color: var(--light); font-size: 1.1rem; line-height: 1.4;">
                    ${producto.nombre}
                </h3>
                
                <p style="color: var(--gray-light); font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.5;">
                    ${producto.descripcion?.substring(0, 100) || 'Sin descripción'}...
                </p>
                
                <!-- Tienda -->
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, var(--secondary) 0%, #059669 100%); 
                                display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem;">
                        <i class="fas fa-store"></i>
                    </div>
                    <span style="color: var(--gray-light); font-size: 0.875rem;">
                        ${producto.tienda?.nombre || 'Tienda desconocida'}
                    </span>
                </div>
            </div>
            
            <!-- Precio y Acciones -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                <div>
                    <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
                        $${parseFloat(producto.precio).toFixed(2)}
                    </span>
                    ${producto.precio_original && producto.precio_original > producto.precio ? `
                    <span style="font-size: 0.875rem; color: var(--gray); text-decoration: line-through; margin-left: 0.5rem;">
                        $${parseFloat(producto.precio_original).toFixed(2)}
                    </span>
                    <span style="font-size: 0.875rem; color: var(--secondary); margin-left: 0.5rem;">
                        <i class="fas fa-arrow-down"></i> ${Math.round((1 - producto.precio/producto.precio_original) * 100)}%
                    </span>
                    ` : ''}
                </div>
                
                <!-- Botón de acción -->
                ${producto.stock > 0 ? `
                <button onclick="event.stopPropagation(); addToCart(${producto.id})" 
                        class="btn-primary" style="padding: 8px 16px; font-size: 0.875rem;">
                    <i class="fas fa-cart-plus"></i>
                </button>
                ` : `
                <button class="btn-secondary" style="padding: 8px 16px; font-size: 0.875rem;" disabled>
                    <i class="fas fa-times"></i> Agotado
                </button>
                `}
            </div>
        </div>
    `).join('');
}

function updateCategorias() {
    // Extraer categorías únicas de los productos
    const nuevasCategorias = [...new Set(productos.map(p => p.categoria).filter(Boolean))];
    
    // Agregar nuevas categorías al filtro
    nuevasCategorias.forEach(categoria => {
        if (!categorias.includes(categoria)) {
            categorias.push(categoria);
            
            const option = document.createElement('option');
            option.value = categoria;
            option.textContent = categoria;
            document.getElementById('categoriaFilter').appendChild(option);
        }
    });
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
            <button onclick="loadProductos(${currentPage - 1})" class="btn-secondary" 
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
            <button onclick="loadProductos(${i})" 
                    class="${i === currentPage ? 'btn-primary' : 'btn-secondary'}" 
                    style="padding: 8px 16px;">
                ${i}
            </button>
        `;
    }
    
    // Botón siguiente
    if (currentPage < totalPages) {
        html += `
            <button onclick="loadProductos(${currentPage + 1})" class="btn-secondary" 
                    style="padding: 8px 16px; border-radius: 0 8px 8px 0;">
                <i class="fas fa-chevron-right"></i>
            </button>
        `;
    }
    
    pagination.innerHTML = html;
}

function setupEventListeners() {
    // Búsqueda
    document.getElementById('searchInput').addEventListener('input', debounce(function() {
        filters.search = this.value;
        loadProductos(1);
    }, 500));
    
    // Filtros
    document.getElementById('tiendaFilter').addEventListener('change', function() {
        filters.tienda = this.value;
        loadProductos(1);
    });
    
    document.getElementById('categoriaFilter').addEventListener('change', function() {
        filters.categoria = this.value;
        loadProductos(1);
    });
    
    document.getElementById('sortFilter').addEventListener('change', function() {
        filters.sort = this.value;
        loadProductos(1);
    });
}

function applyPriceFilter() {
    const minPrice = document.getElementById('minPrice').value;
    const maxPrice = document.getElementById('maxPrice').value;
    
    if (minPrice && parseFloat(minPrice) < 0) {
        window.showAlert('El precio mínimo no puede ser negativo', 'error');
        return;
    }
    
    if (maxPrice && parseFloat(maxPrice) < 0) {
        window.showAlert('El precio máximo no puede ser negativo', 'error');
        return;
    }
    
    if (minPrice && maxPrice && parseFloat(minPrice) > parseFloat(maxPrice)) {
        window.showAlert('El precio mínimo no puede ser mayor al máximo', 'error');
        return;
    }
    
    filters.minPrice = minPrice;
    filters.maxPrice = maxPrice;
    loadProductos(1);
}

function clearPriceFilter() {
    document.getElementById('minPrice').value = '';
    document.getElementById('maxPrice').value = '';
    filters.minPrice = '';
    filters.maxPrice = '';
    loadProductos(1);
}

function clearAllFilters() {
    // Resetear inputs
    document.getElementById('searchInput').value = '';
    document.getElementById('tiendaFilter').value = '';
    document.getElementById('categoriaFilter').value = '';
    document.getElementById('sortFilter').value = 'recientes';
    document.getElementById('minPrice').value = '';
    document.getElementById('maxPrice').value = '';
    
    // Resetear filtros
    filters = {
        search: '',
        tienda: '',
        categoria: '',
        sort: 'recientes',
        minPrice: '',
        maxPrice: ''
    };
    
    // Recargar productos
    loadProductos(1);
}

function addToCart(productoId) {
    if (!window.NovaMarket.token) {
        window.showAlert('Debes iniciar sesión para agregar al carrito', 'error');
        window.location.href = '/login';
        return;
    }
    
    // Buscar el producto
    const producto = productos.find(p => p.id === productoId);
    if (!producto) return;
    
    // Agregar al carrito
    const cart = window.NovaMarket.cart || { items: [], count: 0 };
    
    // Verificar si el producto ya está en el carrito
    const existingItem = cart.items.find(item => item.id === productoId);
    
    if (existingItem) {
        if (existingItem.quantity >= producto.stock) {
            window.showAlert('No hay suficiente stock disponible', 'error');
            return;
        }
        existingItem.quantity += 1;
    } else {
        cart.items.push({
            id: producto.id,
            nombre: producto.nombre,
            precio: producto.precio,
            imagen_url: producto.imagen_url,
            stock: producto.stock,
            tienda_id: producto.tienda_id,
            quantity: 1
        });
    }
    
    // Actualizar contador
    cart.count = cart.items.reduce((total, item) => total + item.quantity, 0);
    
    // Guardar en localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    window.NovaMarket.cart = cart;
    
    // Actualizar UI
    updateCartCount();
    
    // Mostrar mensaje de éxito
    window.showAlert(`"${producto.nombre}" agregado al carrito`, 'success');
}

function updateCartCount() {
    const cartCount = document.getElementById('cartCount');
    if (cartCount) {
        cartCount.textContent = window.NovaMarket.cart?.count || 0;
    }
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endsection
