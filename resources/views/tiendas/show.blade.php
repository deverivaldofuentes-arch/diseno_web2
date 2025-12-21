@extends('layouts.app')

@section('title', 'Tienda - NovaMarket')

@section('content')
<div class="tienda-container" style="max-width: 1200px; margin: 0 auto;">
    <!-- Header de la Tienda -->
    <div class="glass-effect" style="padding: 2rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 2rem; margin-bottom: 1.5rem;">
            <div style="width: 120px; height: 120px; border-radius: 16px; overflow: hidden; 
                        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
                        display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white;">
                <i class="fas fa-store"></i>
            </div>
            
            <div style="flex: 1;">
                <h1 id="tiendaNombre" style="margin-bottom: 0.5rem; color: var(--light);"></h1>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                    <span style="color: var(--gray-light);">
                        <i class="fas fa-user"></i> <span id="tiendaDueno"></span>
                    </span>
                    <span style="color: var(--gray-light);">
                        <i class="fas fa-calendar"></i> Creada el <span id="tiendaFecha"></span>
                    </span>
                </div>
                <p id="tiendaDescripcion" style="color: var(--gray-light); line-height: 1.6;"></p>
            </div>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; gap: 1rem;">
                <div style="text-align: center; padding: 0.5rem 1rem; background: rgba(99, 102, 241, 0.1); border-radius: 8px;">
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);" id="productosCount">0</div>
                    <div style="color: var(--gray-light); font-size: 0.875rem;">Productos</div>
                </div>
                <div style="text-align: center; padding: 0.5rem 1rem; background: rgba(16, 185, 129, 0.1); border-radius: 8px;">
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--secondary);" id="seguidoresCount">0</div>
                    <div style="color: var(--gray-light); font-size: 0.875rem;">Seguidores</div>
                </div>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button id="seguirBtn" class="btn-secondary" onclick="toggleSeguir()">
                    <i class="fas fa-heart"></i> <span id="seguirText">Seguir Tienda</span>
                </button>
                <button class="btn-primary" onclick="window.location.href='#productos'">
                    <i class="fas fa-shopping-bag"></i> Ver Productos
                </button>
            </div>
        </div>
    </div>
    
    <!-- Productos de la Tienda -->
    <div id="productos">
        <h2 style="margin-bottom: 1.5rem; color: var(--light);">
            <i class="fas fa-boxes"></i> Productos Disponibles
        </h2>
        
        <!-- Filtros -->
        <div class="glass-effect" style="padding: 1rem; margin-bottom: 2rem;">
            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <input type="text" id="searchProduct" placeholder="Buscar productos..." 
                           style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                  background: rgba(255,255,255,0.05); color: var(--light);">
                </div>
                <div>
                    <select id="categoriaFilter" style="padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                                       background: rgba(255,255,255,0.05); color: var(--light);">
                        <option value="">Todas las categorías</option>
                        <!-- Se llenará con JS -->
                    </select>
                </div>
                <div>
                    <select id="sortFilter" style="padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                                   background: rgba(255,255,255,0.05); color: var(--light);">
                        <option value="nombre">Ordenar por nombre</option>
                        <option value="precio_asc">Precio: menor a mayor</option>
                        <option value="precio_desc">Precio: mayor a menor</option>
                        <option value="nuevos">Más nuevos primero</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Grid de Productos -->
        <div id="productosGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
            <!-- Productos se cargarán aquí -->
        </div>
        
        <!-- Paginación -->
        <div id="pagination" style="margin-top: 2rem; display: flex; justify-content: center;"></div>
        
        <!-- Loading -->
        <div id="loadingProducts" style="text-align: center; padding: 3rem; color: var(--gray);">
            <div class="loading" style="width: 40px; height: 40px; margin: 0 auto 1rem;"></div>
            <div>Cargando productos...</div>
        </div>
    </div>
    
    <!-- Comentarios -->
    <div style="margin-top: 4rem;">
        <h2 style="margin-bottom: 1.5rem; color: var(--light);">
            <i class="fas fa-comments"></i> Comentarios y Reseñas
        </h2>
        
        <div class="glass-effect" style="padding: 2rem;">
            <!-- Formulario para nuevo comentario -->
            <div id="commentFormContainer" style="margin-bottom: 2rem; display: none;">
                <h3 style="margin-bottom: 1rem; color: var(--light);">Deja tu comentario</h3>
                <form id="commentForm">
                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <span style="color: var(--gray-light);">Calificación:</span>
                            <div id="ratingStars" style="display: flex; gap: 0.25rem;">
                                <i class="fas fa-star" data-rating="1" style="color: var(--gray); cursor: pointer;"></i>
                                <i class="fas fa-star" data-rating="2" style="color: var(--gray); cursor: pointer;"></i>
                                <i class="fas fa-star" data-rating="3" style="color: var(--gray); cursor: pointer;"></i>
                                <i class="fas fa-star" data-rating="4" style="color: var(--gray); cursor: pointer;"></i>
                                <i class="fas fa-star" data-rating="5" style="color: var(--gray); cursor: pointer;"></i>
                            </div>
                            <input type="hidden" id="rating" name="rating" value="5">
                        </div>
                        <textarea id="commentText" name="comentario" rows="3" placeholder="Escribe tu comentario aquí..." 
                                  style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                         background: rgba(255,255,255,0.05); color: var(--light); resize: vertical;"></textarea>
                        <div class="error-message" id="commentError" style="color: #f87171; font-size: 0.875rem;"></div>
                    </div>
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-paper-plane"></i> Publicar Comentario
                        </button>
                        <button type="button" onclick="hideCommentForm()" class="btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Botón para agregar comentario -->
            <div id="addCommentBtnContainer">
                <button onclick="showCommentForm()" class="btn-primary">
                    <i class="fas fa-plus"></i> Agregar Comentario
                </button>
            </div>
            
            <!-- Lista de Comentarios -->
            <div id="commentsList" style="margin-top: 2rem;">
                <div style="text-align: center; padding: 2rem; color: var(--gray);">
                    <i class="fas fa-spinner"></i> Cargando comentarios...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let tiendaId = window.location.pathname.split('/').pop();
let currentPage = 1;
let totalPages = 1;
let productos = [];
let comentarios = [];
let userRating = 5;
let isFollowing = false;

document.addEventListener('DOMContentLoaded', async function() {
    await loadTiendaData();
    await loadProductos();
    await loadComentarios();
    setupRatingStars();
});

// Cargar datos de la tienda
async function loadTiendaData() {
    try {
        const response = await axios.get(`/api/tiendas/${tiendaId}`);
        const tienda = response.data;
        
        // Actualizar UI
        document.getElementById('tiendaNombre').textContent = tienda.nombre;
        document.getElementById('tiendaDueno').textContent = tienda.dueno?.name || 'Dueño desconocido';
        document.getElementById('tiendaFecha').textContent = new Date(tienda.created_at).toLocaleDateString('es-ES');
        document.getElementById('tiendaDescripcion').textContent = tienda.descripcion;
        document.getElementById('productosCount').textContent = tienda.productos_count || 0;
        document.getElementById('seguidoresCount').textContent = tienda.seguidores_count || 0;
        
        // Verificar si el usuario sigue la tienda
        if (window.NovaMarket.user) {
            const followResponse = await axios.get(`/api/tiendas/${tiendaId}/check-follow`);
            isFollowing = followResponse.data.following;
            updateFollowButton();
        }
        
    } catch (error) {
        console.error('Error loading tienda:', error);
        window.showAlert('Error al cargar la tienda', 'error');
    }
}

// Cargar productos
async function loadProductos(page = 1) {
    currentPage = page;
    
    try {
        document.getElementById('loadingProducts').style.display = 'block';
        document.getElementById('productosGrid').innerHTML = '';
        
        const search = document.getElementById('searchProduct').value;
        const categoria = document.getElementById('categoriaFilter').value;
        const sort = document.getElementById('sortFilter').value;
        
        let url = `/api/tiendas/${tiendaId}/productos?page=${page}`;
        if (search) url += `&search=${search}`;
        if (categoria) url += `&categoria=${categoria}`;
        if (sort) url += `&sort=${sort}`;
        
        const response = await axios.get(url);
        productos = response.data.data || response.data;
        totalPages = response.data.meta?.last_page || 1;
        
        // Actualizar grid
        renderProductosGrid();
        
        // Actualizar paginación
        renderPagination();
        
        // Actualizar filtro de categorías
        updateCategoriasFilter();
        
    } catch (error) {
        console.error('Error loading productos:', error);
    } finally {
        document.getElementById('loadingProducts').style.display = 'none';
    }
}

function renderProductosGrid() {
    const grid = document.getElementById('productosGrid');
    
    if (productos.length === 0) {
        grid.innerHTML = `
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--gray);">
                <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h3>No hay productos disponibles</h3>
                <p>Esta tienda aún no ha agregado productos.</p>
            </div>
        `;
        return;
    }
    
    grid.innerHTML = productos.map(producto => `
        <div class="glass-effect" style="padding: 1.5rem; display: flex; flex-direction: column; 
                                         transition: var(--transition); cursor: pointer;"
             onclick="window.location.href='/productos/${producto.id}'">
            <div style="width: 100%; height: 200px; border-radius: 12px; overflow: hidden; margin-bottom: 1rem;">
                <img src="${producto.imagen_url || 'https://via.placeholder.com/300x200'}" 
                     alt="${producto.nombre}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <h3 style="margin-bottom: 0.5rem; color: var(--light); font-size: 1.1rem;">${producto.nombre}</h3>
            <p style="color: var(--gray-light); font-size: 0.875rem; margin-bottom: 1rem; flex: 1;">
                ${producto.descripcion?.substring(0, 100) || 'Sin descripción'}...
            </p>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                    $${parseFloat(producto.precio).toFixed(2)}
                </span>
                <span style="font-size: 0.875rem; color: ${producto.stock > 0 ? 'var(--secondary)' : '#f87171'}">
                    <i class="fas ${producto.stock > 0 ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                    ${producto.stock > 0 ? 'Disponible' : 'Agotado'}
                </span>
            </div>
        </div>
    `).join('');
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
        html += `<button onclick="loadProductos(${currentPage - 1})" class="btn-secondary" style="padding: 8px 16px;">
                    <i class="fas fa-chevron-left"></i>
                 </button>`;
    }
    
    // Páginas
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            html += `<button onclick="loadProductos(${i})" 
                             class="${i === currentPage ? 'btn-primary' : 'btn-secondary'}" 
                             style="padding: 8px 16px;">
                        ${i}
                     </button>`;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            html += '<span style="padding: 8px; color: var(--gray);">...</span>';
        }
    }
    
    // Botón siguiente
    if (currentPage < totalPages) {
        html += `<button onclick="loadProductos(${currentPage + 1})" class="btn-secondary" style="padding: 8px 16px;">
                    <i class="fas fa-chevron-right"></i>
                 </button>`;
    }
    
    pagination.innerHTML = html;
}

function updateCategoriasFilter() {
    const categorias = [...new Set(productos.map(p => p.categoria).filter(Boolean))];
    const select = document.getElementById('categoriaFilter');
    
    // Mantener opciones existentes
    const currentValue = select.value;
    
    // Actualizar opciones
    select.innerHTML = '<option value="">Todas las categorías</option>' +
        categorias.map(cat => `<option value="${cat}">${cat}</option>`).join('');
    
    // Restaurar valor seleccionado
    select.value = currentValue;
}

// Event listeners para filtros
document.getElementById('searchProduct').addEventListener('input', debounce(() => loadProductos(1), 500));
document.getElementById('categoriaFilter').addEventListener('change', () => loadProductos(1));
document.getElementById('sortFilter').addEventListener('change', () => loadProductos(1));

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

// Funciones para seguir/deseguir tienda
async function toggleSeguir() {
    if (!window.NovaMarket.token) {
        window.showAlert('Debes iniciar sesión para seguir tiendas', 'error');
        window.location.href = '/login';
        return;
    }
    
    try {
        if (isFollowing) {
            await axios.delete(`/api/tiendas/${tiendaId}/seguir`);
            isFollowing = false;
            window.showAlert('Has dejado de seguir esta tienda', 'info');
        } else {
            await axios.post(`/api/tiendas/${tiendaId}/seguir`);
            isFollowing = true;
            window.showAlert('Ahora sigues esta tienda', 'success');
        }
        
        updateFollowButton();
        
        // Actualizar contador de seguidores
        const seguidoresEl = document.getElementById('seguidoresCount');
        let count = parseInt(seguidoresEl.textContent) || 0;
        seguidoresEl.textContent = isFollowing ? count + 1 : Math.max(0, count - 1);
        
    } catch (error) {
        console.error('Error toggling follow:', error);
        window.showAlert('Error al actualizar seguimiento', 'error');
    }
}

function updateFollowButton() {
    const btn = document.getElementById('seguirBtn');
    const text = document.getElementById('seguirText');
    
    if (isFollowing) {
        btn.classList.remove('btn-secondary');
        btn.classList.add('btn-primary');
        text.innerHTML = '<i class="fas fa-heart"></i> Siguiendo';
    } else {
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-secondary');
        text.innerHTML = '<i class="far fa-heart"></i> Seguir Tienda';
    }
}

// Funciones para comentarios
async function loadComentarios() {
    try {
        const response = await axios.get(`/api/tiendas/${tiendaId}/comentarios`);
        comentarios = response.data;
        renderComentarios();
    } catch (error) {
        console.error('Error loading comentarios:', error);
    }
}

function renderComentarios() {
    const container = document.getElementById('commentsList');
    
    if (comentarios.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: var(--gray);">
                <i class="fas fa-comment-slash" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                <p>No hay comentarios aún. ¡Sé el primero en comentar!</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = comentarios.map(comentario => `
        <div style="padding: 1rem; border-bottom: 1px solid var(--glass-border);">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
                                display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                        ${comentario.usuario?.name?.charAt(0).toUpperCase() || 'U'}
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--light);">${comentario.usuario?.name || 'Usuario'}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-light);">
                            ${new Date(comentario.created_at).toLocaleDateString('es-ES', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            })}
                        </div>
                    </div>
                </div>
                <div style="color: #fbbf24; font-size: 1.25rem;">
                    ${'★'.repeat(comentario.calificacion)}${'☆'.repeat(5 - comentario.calificacion)}
                </div>
            </div>
            <p style="color: var(--light); line-height: 1.6;">${comentario.comentario}</p>
        </div>
    `).join('');
}

function showCommentForm() {
    if (!window.NovaMarket.token) {
        window.showAlert('Debes iniciar sesión para comentar', 'error');
        window.location.href = '/login';
        return;
    }
    
    document.getElementById('addCommentBtnContainer').style.display = 'none';
    document.getElementById('commentFormContainer').style.display = 'block';
}

function hideCommentForm() {
    document.getElementById('addCommentBtnContainer').style.display = 'block';
    document.getElementById('commentFormContainer').style.display = 'none';
    document.getElementById('commentForm').reset();
    userRating = 5;
    updateStars();
}

function setupRatingStars() {
    const stars = document.querySelectorAll('#ratingStars i');
    stars.forEach(star => {
        star.addEventListener('click', function() {
            userRating = parseInt(this.getAttribute('data-rating'));
            updateStars();
        });
        
        star.addEventListener('mouseover', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            highlightStars(rating);
        });
    });
    
    document.getElementById('ratingStars').addEventListener('mouseleave', updateStars);
}

function updateStars() {
    const stars = document.querySelectorAll('#ratingStars i');
    stars.forEach(star => {
        const starRating = parseInt(star.getAttribute('data-rating'));
        if (starRating <= userRating) {
            star.style.color = '#fbbf24';
            star.classList.remove('far');
            star.classList.add('fas');
        } else {
            star.style.color = 'var(--gray)';
            star.classList.remove('fas');
            star.classList.add('far');
        }
    });
    document.getElementById('rating').value = userRating;
}

function highlightStars(rating) {
    const stars = document.querySelectorAll('#ratingStars i');
    stars.forEach(star => {
        const starRating = parseInt(star.getAttribute('data-rating'));
        if (starRating <= rating) {
            star.style.color = '#fbbf24';
        } else {
            star.style.color = 'var(--gray)';
        }
    });
}

// Enviar comentario
document.getElementById('commentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const button = this.querySelector('button[type="submit"]');
    const originalText = window.showLoading(button);
    
    const formData = {
        tienda_id: tiendaId,
        comentario: document.getElementById('commentText').value,
        calificacion: userRating
    };
    
    try {
        const response = await axios.post('/api/comentarios', formData);
        
        window.showAlert('Comentario publicado correctamente', 'success');
        hideCommentForm();
        await loadComentarios();
        
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
        } else {
            window.showAlert('Error al publicar el comentario', 'error');
        }
    }
});
</script>
@endsection
