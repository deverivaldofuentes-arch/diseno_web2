@extends('layouts.app')

@section('title', 'Producto - NovaMarket')

@section('content')
<div class="producto-container" style="max-width: 1200px; margin: 0 auto;">
    <!-- Ruta de navegación -->
    <div style="margin-bottom: 1.5rem;">
        <nav style="display: flex; align-items: center; gap: 0.5rem; color: var(--gray-light); font-size: 0.875rem;">
            <a href="/" style="color: var(--primary); text-decoration: none;">Inicio</a>
            <i class="fas fa-chevron-right" style="font-size: 0.75rem;"></i>
            <a href="/productos" style="color: var(--primary); text-decoration: none;">Productos</a>
            <i class="fas fa-chevron-right" style="font-size: 0.75rem;"></i>
            <a href="#" id="productCategoria" style="color: var(--primary); text-decoration: none;"></a>
            <i class="fas fa-chevron-right" style="font-size: 0.75rem;"></i>
            <span style="color: var(--light);" id="productNameBreadcrumb"></span>
        </nav>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem;">
        <!-- Galería de Imágenes -->
        <div>
            <div id="mainImage" style="width: 100%; height: 400px; border-radius: 16px; overflow: hidden; margin-bottom: 1rem;">
                <img id="mainImageSrc" src="" alt="" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            
            <div id="thumbnailGallery" style="display: flex; gap: 1rem; overflow-x: auto; padding: 0.5rem 0;">
                <!-- Miniaturas se cargarán aquí -->
            </div>
        </div>
        
        <!-- Información del Producto -->
        <div>
            <!-- Nombre y Rating -->
            <h1 id="productNombre" style="margin-bottom: 0.5rem; color: var(--light); font-size: 1.8rem;"></h1>
            
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.25rem;">
                    <div id="ratingStars" style="color: #fbbf24; font-size: 1.25rem;"></div>
                    <span id="ratingValue" style="color: var(--gray-light); font-size: 0.875rem;"></span>
                </div>
                <span style="color: var(--gray-light); font-size: 0.875rem;">
                    <i class="fas fa-comment"></i> <span id="reviewsCount">0</span> reseñas
                </span>
            </div>
            
            <!-- Precio -->
            <div style="margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span id="productPrecio" style="font-size: 2.5rem; font-weight: 700; color: var(--primary);"></span>
                    
                    <span id="originalPrice" style="font-size: 1.5rem; color: var(--gray); text-decoration: line-through;"></span>
                    
                    <span id="discountBadge" style="background: var(--secondary); color: white; padding: 4px 12px; 
                                                    border-radius: 20px; font-size: 0.875rem; font-weight: 600;"></span>
                </div>
            </div>
            
            <!-- Tienda -->
            <div style="margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: rgba(255,255,255,0.05); 
                            border-radius: 12px;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--secondary) 0%, #059669 100%); 
                                display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                        <i class="fas fa-store"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--light);" id="tiendaNombre"></div>
                        <a href="#" id="tiendaLink" style="color: var(--primary); text-decoration: none; font-size: 0.875rem;">
                            Ver tienda <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Descripción -->
            <div style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 0.5rem; color: var(--light);">Descripción</h3>
                <p id="productDescripcion" style="color: var(--gray-light); line-height: 1.6;"></p>
            </div>
            
            <!-- Especificaciones -->
            <div style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 0.5rem; color: var(--light);">Especificaciones</h3>
                <div id="productSpecs" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <!-- Se llenará con JS -->
                </div>
            </div>
            
            <!-- Formulario de Compra -->
            <div class="glass-effect" style="padding: 1.5rem; border-radius: 16px;">
                <!-- Stock -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div>
                        <div style="font-weight: 600; color: var(--light); margin-bottom: 0.25rem;">Disponibilidad</div>
                        <div id="stockStatus" style="font-size: 0.875rem; color: var(--gray-light);"></div>
                    </div>
                    <div id="stockBadge" style="padding: 6px 12px; border-radius: 20px; font-size: 0.875rem; font-weight: 600;"></div>
                </div>
                
                <!-- Cantidad -->
                <div style="margin-bottom: 1.5rem;">
                    <div style="font-weight: 600; color: var(--light); margin-bottom: 0.5rem;">Cantidad</div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="display: flex; align-items: center; border: 1px solid var(--glass-border); border-radius: 8px; overflow: hidden;">
                            <button onclick="decreaseQuantity()" 
                                    style="background: rgba(255,255,255,0.05); color: var(--light); border: none; 
                                           padding: 10px 16px; cursor: pointer; font-size: 1.2rem;">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" id="quantity" value="1" min="1" max="99" 
                                   style="width: 60px; text-align: center; padding: 10px; border: none; 
                                          background: transparent; color: var(--light); font-size: 1.1rem;">
                            <button onclick="increaseQuantity()" 
                                    style="background: rgba(255,255,255,0.05); color: var(--light); border: none; 
                                           padding: 10px 16px; cursor: pointer; font-size: 1.2rem;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div style="color: var(--gray-light); font-size: 0.875rem;">
                            <span id="maxStockMessage"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Acciones -->
                <div style="display: flex; gap: 1rem;">
                    <button id="addToCartBtn" class="btn-primary" style="flex: 2;" onclick="addToCart()">
                        <i class="fas fa-cart-plus"></i> Agregar al Carrito
                    </button>
                    <button id="buyNowBtn" class="btn-primary" style="flex: 1;" onclick="buyNow()">
                        <i class="fas fa-bolt"></i> Comprar Ahora
                    </button>
                    <button id="wishlistBtn" class="btn-secondary" style="padding: 0 16px;" onclick="toggleWishlist()">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                
                <!-- Mensajes de error -->
                <div id="cartError" style="color: #f87171; font-size: 0.875rem; margin-top: 1rem; display: none;"></div>
            </div>
        </div>
    </div>
    
    <!-- Reseñas -->
    <div style="margin-top: 4rem;">
        <h2 style="margin-bottom: 2rem; color: var(--light);">
            <i class="fas fa-comments"></i> Reseñas de Clientes
        </h2>
        
        <div class="glass-effect" style="padding: 2rem; border-radius: 16px;">
            <!-- Estadísticas de reseñas -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <div>
                    <h3 style="margin-bottom: 1rem; color: var(--light);">Calificación General</h3>
                    <div style="display: flex; align-items: center; gap: 2rem;">
                        <div style="text-align: center;">
                            <div style="font-size: 4rem; font-weight: 700; color: var(--light);" id="averageRating">0.0</div>
                            <div style="color: var(--gray-light);">de 5 estrellas</div>
                        </div>
                        <div style="flex: 1;">
                            <div id="ratingDistribution">
                                <!-- Distribución de ratings -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Formulario para nueva reseña -->
                <div id="reviewFormContainer" style="display: none;">
                    <h3 style="margin-bottom: 1rem; color: var(--light);">Deja tu reseña</h3>
                    <form id="reviewForm">
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <span style="color: var(--gray-light);">Tu calificación:</span>
                                <div id="userRatingStars" style="display: flex; gap: 0.25rem;">
                                    <i class="fas fa-star" data-rating="1" style="color: var(--gray); cursor: pointer;"></i>
                                    <i class="fas fa-star" data-rating="2" style="color: var(--gray); cursor: pointer;"></i>
                                    <i class="fas fa-star" data-rating="3" style="color: var(--gray); cursor: pointer;"></i>
                                    <i class="fas fa-star" data-rating="4" style="color: var(--gray); cursor: pointer;"></i>
                                    <i class="fas fa-star" data-rating="5" style="color: var(--gray); cursor: pointer;"></i>
                                </div>
                                <input type="hidden" id="userRating" name="rating" value="5">
                            </div>
                            <textarea id="reviewComment" name="comentario" rows="3" placeholder="Comparte tu experiencia con este producto..." 
                                      style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                             background: rgba(255,255,255,0.05); color: var(--light); resize: vertical;"></textarea>
                            <div class="error-message" id="reviewError" style="color: #f87171; font-size: 0.875rem;"></div>
                        </div>
                        <div style="display: flex; gap: 1rem;">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-paper-plane"></i> Publicar Reseña
                            </button>
                            <button type="button" onclick="hideReviewForm()" class="btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Botón para agregar reseña -->
                <div id="addReviewBtnContainer">
                    <button onclick="showReviewForm()" class="btn-primary">
                        <i class="fas fa-plus"></i> Escribir una Reseña
                    </button>
                </div>
            </div>
            
            <!-- Lista de Reseñas -->
            <div id="reviewsList">
                <div style="text-align: center; padding: 2rem; color: var(--gray);">
                    <i class="fas fa-spinner"></i> Cargando reseñas...
                </div>
            </div>
            
            <!-- Botón para ver más reseñas -->
            <div id="loadMoreReviews" style="text-align: center; margin-top: 2rem; display: none;">
                <button onclick="loadMoreReviews()" class="btn-secondary">
                    <i class="fas fa-sync"></i> Cargar más reseñas
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let producto = null;
let productoId = window.location.pathname.split('/').pop();
let reviews = [];
let reviewPage = 1;
let hasMoreReviews = true;
let userRating = 5;
let images = [];
let currentImageIndex = 0;
let inWishlist = false;

document.addEventListener('DOMContentLoaded', async function() {
    await loadProducto();
    await loadReviews();
    setupRatingStars();
    checkWishlist();
});

// Cargar datos del producto
async function loadProducto() {
    try {
        const response = await axios.get(`/api/productos/${productoId}`);
        producto = response.data;
        
        // Actualizar UI
        updateProductUI();
        
    } catch (error) {
        console.error('Error loading producto:', error);
        window.showAlert('Error al cargar el producto', 'error');
    }
}

function updateProductUI() {
    if (!producto) return;
    
    // Actualizar breadcrumb
    document.getElementById('productNameBreadcrumb').textContent = producto.nombre;
    document.getElementById('productCategoria').textContent = producto.categoria || 'Productos';
    document.getElementById('productCategoria').href = `/productos?categoria=${encodeURIComponent(producto.categoria)}`;
    
    // Actualizar imágenes
    updateImages();
    
    // Actualizar nombre
    document.getElementById('productNombre').textContent = producto.nombre;
    
    // Actualizar rating
    updateRatingUI();
    
    // Actualizar precio
    updatePriceUI();
    
    // Actualizar tienda
    document.getElementById('tiendaNombre').textContent = producto.tienda?.nombre || 'Tienda desconocida';
    if (producto.tienda?.id) {
        document.getElementById('tiendaLink').href = `/tiendas/${producto.tienda.id}`;
    }
    
    // Actualizar descripción
    document.getElementById('productDescripcion').textContent = producto.descripcion || 'Sin descripción';
    
    // Actualizar especificaciones
    updateSpecifications();
    
    // Actualizar stock
    updateStockUI();
}

function updateImages() {
    // Agregar imagen principal si existe
    if (producto.imagen_url) {
        images.push(producto.imagen_url);
    }
    
    // Agregar imágenes adicionales si existen
    if (producto.imagenes_adicionales) {
        const adicionales = Array.isArray(producto.imagenes_adicionales) 
            ? producto.imagenes_adicionales 
            : JSON.parse(producto.imagenes_adicionales || '[]');
        images.push(...adicionales);
    }
    
    // Si no hay imágenes, usar placeholder
    if (images.length === 0) {
        images.push('https://via.placeholder.com/600x400?text=Sin+imagen');
    }
    
    // Mostrar imagen principal
    const mainImage = document.getElementById('mainImageSrc');
    mainImage.src = images[0];
    mainImage.alt = producto.nombre;
    
    // Crear miniaturas
    const gallery = document.getElementById('thumbnailGallery');
    gallery.innerHTML = images.map((img, index) => `
        <div onclick="changeMainImage(${index})" 
             style="width: 80px; height: 80px; border-radius: 8px; overflow: hidden; cursor: pointer;
                    border: ${index === 0 ? '2px solid var(--primary)' : '1px solid var(--glass-border)'};">
            <img src="${img}" alt="Imagen ${index + 1}" 
                 style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    `).join('');
}

function changeMainImage(index) {
    if (index < 0 || index >= images.length) return;
    
    currentImageIndex = index;
    document.getElementById('mainImageSrc').src = images[index];
    
    // Actualizar bordes de miniaturas
    const thumbnails = document.querySelectorAll('#thumbnailGallery > div');
    thumbnails.forEach((thumb, i) => {
        thumb.style.border = i === index ? '2px solid var(--primary)' : '1px solid var(--glass-border)';
    });
}

function updateRatingUI() {
    const rating = producto.calificacion_promedio || 0;
    const reviewsCount = producto.resenas_count || 0;
    
    // Actualizar estrellas
    const starsContainer = document.getElementById('ratingStars');
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    
    let starsHTML = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= fullStars) {
            starsHTML += '<i class="fas fa-star"></i>';
        } else if (i === fullStars + 1 && hasHalfStar) {
            starsHTML += '<i class="fas fa-star-half-alt"></i>';
        } else {
            starsHTML += '<i class="far fa-star"></i>';
        }
    }
    starsContainer.innerHTML = starsHTML;
    
    // Actualizar texto
    document.getElementById('ratingValue').textContent = rating.toFixed(1);
    document.getElementById('reviewsCount').textContent = reviewsCount;
}

function updatePriceUI() {
    const precio = parseFloat(producto.precio);
    const precioOriginal = producto.precio_original ? parseFloat(producto.precio_original) : null;
    
    document.getElementById('productPrecio').textContent = `$${precio.toFixed(2)}`;
    
    if (precioOriginal && precioOriginal > precio) {
        document.getElementById('originalPrice').textContent = `$${precioOriginal.toFixed(2)}`;
        const discount = Math.round((1 - precio / precioOriginal) * 100);
        document.getElementById('discountBadge').textContent = `-${discount}%`;
        document.getElementById('discountBadge').style.display = 'inline-block';
    } else {
        document.getElementById('originalPrice').style.display = 'none';
        document.getElementById('discountBadge').style.display = 'none';
    }
}

function updateSpecifications() {
    const specsContainer = document.getElementById('productSpecs');
    const specs = {
        'Categoría': producto.categoria,
        'Marca': producto.marca || 'No especificada',
        'Modelo': producto.modelo || 'No especificado',
        'SKU': producto.sku || 'N/A',
        'Peso': producto.peso ? `${producto.peso} kg` : 'No especificado',
        'Dimensiones': producto.dimensiones || 'No especificado',
        'Material': producto.material || 'No especificado',
        'Color': producto.color || 'No especificado'
    };
    
    specsContainer.innerHTML = Object.entries(specs)
        .filter(([_, value]) => value && value !== 'No especificado' && value !== 'N/A')
        .map(([key, value]) => `
            <div>
                <div style="font-weight: 600; color: var(--gray-light); font-size: 0.875rem;">${key}</div>
                <div style="color: var(--light);">${value}</div>
            </div>
        `).join('');
}

function updateStockUI() {
    const stock = producto.stock || 0;
    const stockStatus = document.getElementById('stockStatus');
    const stockBadge = document.getElementById('stockBadge');
    const maxStockMessage = document.getElementById('maxStockMessage');
    const quantityInput = document.getElementById('quantity');
    
    if (stock > 10) {
        stockStatus.textContent = 'En stock';
        stockBadge.textContent = `${stock} disponibles`;
        stockBadge.style.background = 'var(--secondary)';
        stockBadge.style.color = 'white';
        maxStockMessage.textContent = '';
        quantityInput.max = Math.min(99, stock);
    } else if (stock > 0) {
        stockStatus.textContent = 'Últimas unidades';
        stockBadge.textContent = `${stock} disponibles`;
        stockBadge.style.background = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
        stockBadge.style.color = 'white';
        maxStockMessage.textContent = `Máximo ${stock} unidades`;
        quantityInput.max = stock;
        quantityInput.value = Math.min(quantityInput.value, stock);
    } else {
        stockStatus.textContent = 'Agotado';
        stockBadge.textContent = 'Sin stock';
        stockBadge.style.background = '#ef4444';
        stockBadge.style.color = 'white';
        maxStockMessage.textContent = 'Producto no disponible';
        quantityInput.disabled = true;
        document.getElementById('addToCartBtn').disabled = true;
        document.getElementById('buyNowBtn').disabled = true;
        document.getElementById('addToCartBtn').innerHTML = '<i class="fas fa-times"></i> Agotado';
        document.getElementById('buyNowBtn').innerHTML = '<i class="fas fa-times"></i> Agotado';
    }
}

// Funciones de cantidad
function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const current = parseInt(input.value);
    if (current > 1) {
        input.value = current - 1;
    }
}

function increaseQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

// Agregar al carrito
function addToCart() {
    if (!window.NovaMarket.token) {
        window.showAlert('Debes iniciar sesión para agregar al carrito', 'error');
        window.location.href = '/login';
        return;
    }
    
    const quantity = parseInt(document.getElementById('quantity').value);
    const stock = producto.stock || 0;
    
    if (quantity > stock) {
        document.getElementById('cartError').textContent = `Solo hay ${stock} unidades disponibles`;
        document.getElementById('cartError').style.display = 'block';
        return;
    }
    
    // Agregar al carrito
    const cart = window.NovaMarket.cart || { items: [], count: 0 };
    
    // Verificar si el producto ya está en el carrito
    const existingItem = cart.items.find(item => item.id === producto.id);
    
    if (existingItem) {
        const newQuantity = existingItem.quantity + quantity;
        if (newQuantity > stock) {
            document.getElementById('cartError').textContent = `No puedes agregar más de ${stock} unidades`;
            document.getElementById('cartError').style.display = 'block';
            return;
        }
        existingItem.quantity = newQuantity;
    } else {
        cart.items.push({
            id: producto.id,
            nombre: producto.nombre,
            precio: producto.precio,
            imagen_url: producto.imagen_url,
            stock: producto.stock,
            tienda_id: producto.tienda_id,
            quantity: quantity
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
    window.showAlert(`${quantity} x "${producto.nombre}" agregado al carrito`, 'success');
    
    // Limpiar error
    document.getElementById('cartError').style.display = 'none';
}

// Comprar ahora
function buyNow() {
    addToCart();
    if (window.NovaMarket.token) {
        // Redirigir al carrito
        setTimeout(() => {
            window.location.href = '/carrito';
        }, 1000);
    }
}

// Wishlist
async function checkWishlist() {
    if (!window.NovaMarket.token) return;
    
    try {
        const response = await axios.get(`/api/wishlist/check/${productoId}`);
        inWishlist = response.data.in_wishlist;
        updateWishlistButton();
    } catch (error) {
        console.error('Error checking wishlist:', error);
    }
}

async function toggleWishlist() {
    if (!window.NovaMarket.token) {
        window.showAlert('Debes iniciar sesión para usar la wishlist', 'error');
        window.location.href = '/login';
        return;
    }
    
    try {
        if (inWishlist) {
            await axios.delete(`/api/wishlist/${productoId}`);
            inWishlist = false;
            window.showAlert('Producto eliminado de tu wishlist', 'info');
        } else {
            await axios.post(`/api/wishlist`, { producto_id: productoId });
            inWishlist = true;
            window.showAlert('Producto agregado a tu wishlist', 'success');
        }
        
        updateWishlistButton();
    } catch (error) {
        console.error('Error toggling wishlist:', error);
        window.showAlert('Error al actualizar la wishlist', 'error');
    }
}

function updateWishlistButton() {
    const btn = document.getElementById('wishlistBtn');
    if (inWishlist) {
        btn.innerHTML = '<i class="fas fa-heart" style="color: #ef4444;"></i>';
    } else {
        btn.innerHTML = '<i class="far fa-heart"></i>';
    }
}

// Funciones para reseñas
async function loadReviews(page = 1) {
    try {
        const response = await axios.get(`/api/productos/${productoId}/resenas?page=${page}`);
        const newReviews = response.data.data || response.data;
        
        if (page === 1) {
            reviews = newReviews;
        } else {
            reviews.push(...newReviews);
        }
        
        hasMoreReviews = response.data.meta?.current_page < response.data.meta?.last_page;
        renderReviews();
        updateReviewStats();
        
        // Mostrar/ocultar botón de cargar más
        document.getElementById('loadMoreReviews').style.display = hasMoreReviews ? 'block' : 'none';
        
    } catch (error) {
        console.error('Error loading reviews:', error);
    }
}

function renderReviews() {
    const container = document.getElementById('reviewsList');
    
    if (reviews.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: var(--gray);">
                <i class="fas fa-comment-slash" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                <p>No hay reseñas aún. ¡Sé el primero en opinar!</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = reviews.map(review => `
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--glass-border);">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
                                display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                        ${review.usuario?.name?.charAt(0).toUpperCase() || 'U'}
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--light);">${review.usuario?.name || 'Usuario'}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-light);">
                            ${new Date(review.created_at).toLocaleDateString('es-ES', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            })}
                        </div>
                    </div>
                </div>
                <div style="color: #fbbf24; font-size: 1.25rem;">
                    ${'★'.repeat(review.calificacion)}${'☆'.repeat(5 - review.calificacion)}
                </div>
            </div>
            <p style="color: var(--light); line-height: 1.6;">${review.comentario}</p>
        </div>
    `).join('');
}

function loadMoreReviews() {
    reviewPage++;
    loadReviews(reviewPage);
}

function updateReviewStats() {
    if (!producto) return;
    
    const avgRating = producto.calificacion_promedio || 0;
    const totalReviews = producto.resenas_count || 0;
    
    document.getElementById('averageRating').textContent = avgRating.toFixed(1);
    
    // Distribución de ratings
    const distribution = [0, 0, 0, 0, 0]; // 5,4,3,2,1 estrellas
    reviews.forEach(review => {
        if (review.calificacion >= 1 && review.calificacion <= 5) {
            distribution[5 - review.calificacion]++;
        }
    });
    
    const distributionHTML = distribution.map((count, index) => {
        const stars = 5 - index;
        const percentage = totalReviews > 0 ? (count / totalReviews) * 100 : 0;
        return `
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                <div style="width: 80px; color: var(--gray-light);">
                    ${stars} estrella${stars !== 1 ? 's' : ''}
                </div>
                <div style="flex: 1; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden;">
                    <div style="width: ${percentage}%; height: 100%; background: #fbbf24;"></div>
                </div>
                <div style="width: 40px; text-align: right; color: var(--gray-light); font-size: 0.875rem;">
                    ${count}
                </div>
            </div>
        `;
    }).join('');
    
    document.getElementById('ratingDistribution').innerHTML = distributionHTML;
}

function showReviewForm() {
    if (!window.NovaMarket.token) {
        window.showAlert('Debes iniciar sesión para escribir una reseña', 'error');
        window.location.href = '/login';
        return;
    }
    
    document.getElementById('addReviewBtnContainer').style.display = 'none';
    document.getElementById('reviewFormContainer').style.display = 'block';
}

function hideReviewForm() {
    document.getElementById('addReviewBtnContainer').style.display = 'block';
    document.getElementById('reviewFormContainer').style.display = 'none';
    document.getElementById('reviewForm').reset();
    userRating = 5;
    updateUserStars();
}

function setupRatingStars() {
    const stars = document.querySelectorAll('#userRatingStars i');
    stars.forEach(star => {
        star.addEventListener('click', function() {
            userRating = parseInt(this.getAttribute('data-rating'));
            updateUserStars();
        });
        
        star.addEventListener('mouseover', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            highlightUserStars(rating);
        });
    });
    
    document.getElementById('userRatingStars').addEventListener('mouseleave', updateUserStars);
}

function updateUserStars() {
    const stars = document.querySelectorAll('#userRatingStars i');
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
    document.getElementById('userRating').value = userRating;
}

function highlightUserStars(rating) {
    const stars = document.querySelectorAll('#userRatingStars i');
    stars.forEach(star => {
        const starRating = parseInt(star.getAttribute('data-rating'));
        if (starRating <= rating) {
            star.style.color = '#fbbf24';
        } else {
            star.style.color = 'var(--gray)';
        }
    });
}

// Enviar reseña
document.getElementById('reviewForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const button = this.querySelector('button[type="submit"]');
    const originalText = window.showLoading(button);
    
    const formData = {
        producto_id: productoId,
        comentario: document.getElementById('reviewComment').value,
        calificacion: userRating
    };
    
    try {
        await axios.post('/api/resenas', formData);
        
        window.showAlert('Reseña publicada correctamente', 'success');
        hideReviewForm();
        
        // Recargar producto y reseñas
        await loadProducto();
        reviewPage = 1;
        await loadReviews();
        
    } catch (error) {
        window.hideLoading(button, originalText);
        
        if (error.response?.data?.errors) {
            const errors = error.response.data.errors;
            Object.keys(errors).forEach(key => {
                const errorEl = document.getElementById('reviewError');
                if (errorEl) {
                    errorEl.textContent = errors[key][0];
                }
            });
        } else {
            window.showAlert('Error al publicar la reseña', 'error');
        }
    }
});
</script>
@endsection
