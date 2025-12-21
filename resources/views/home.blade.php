@extends('layouts.app')

@section('title', 'NovaMarket - Plataforma de E-commerce para Emprendedores')

@section('content')
<!-- Hero Section -->
<section class="hero" style="position: relative; overflow: hidden; border-radius: 24px; margin-bottom: 4rem;">
    <div class="glass-effect" style="padding: 4rem 2rem; position: relative;">
        <div style="max-width: 800px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1.5rem; 
                       background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
                       -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1.2;">
                Descubre Productos Únicos de Emprendedores Locales
            </h1>
            <p style="font-size: 1.2rem; color: var(--gray-light); margin-bottom: 2.5rem; line-height: 1.6;">
                NovaMarket conecta a emprendedores con clientes que buscan productos auténticos, 
                artesanales y de calidad. Apoya el comercio local y encuentra tesoros únicos.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="/productos" class="btn-primary" style="font-size: 1.1rem; padding: 16px 32px;">
                    <i class="fas fa-shopping-bag"></i> Comenzar a Comprar
                </a>
                <a href="/tiendas" class="btn-secondary" style="font-size: 1.1rem; padding: 16px 32px;">
                    <i class="fas fa-store"></i> Explorar Tiendas
                </a>
            </div>
        </div>
        
        <!-- Elementos decorativos -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; overflow: hidden; z-index: 1;">
            <div style="position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; 
                        border-radius: 50%; background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);">
            </div>
            <div style="position: absolute; bottom: -50px; left: -50px; width: 200px; height: 200px; 
                        border-radius: 50%; background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(236, 72, 153, 0.1) 100%);">
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section style="margin-bottom: 4rem;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
        <div class="glass-effect" style="padding: 2rem; text-align: center; border-radius: 16px;">
            <div style="font-size: 3rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem;" id="storesCount">0</div>
            <div style="color: var(--light); font-weight: 600; margin-bottom: 0.5rem;">Tiendas Activas</div>
            <div style="color: var(--gray-light); font-size: 0.875rem;">Emprendedores confiables</div>
        </div>
        
        <div class="glass-effect" style="padding: 2rem; text-align: center; border-radius: 16px;">
            <div style="font-size: 3rem; font-weight: 700; color: var(--secondary); margin-bottom: 0.5rem;" id="productsCount">0</div>
            <div style="color: var(--light); font-weight: 600; margin-bottom: 0.5rem;">Productos Únicos</div>
            <div style="color: var(--gray-light); font-size: 0.875rem;">Artesanías y más</div>
        </div>
        
        <div class="glass-effect" style="padding: 2rem; text-align: center; border-radius: 16px;">
            <div style="font-size: 3rem; font-weight: 700; color: #8b5cf6; margin-bottom: 0.5rem;" id="ordersCount">0</div>
            <div style="color: var(--light); font-weight: 600; margin-bottom: 0.5rem;">Pedidos Completados</div>
            <div style="color: var(--gray-light); font-size: 0.875rem;">Clientes satisfechos</div>
        </div>
        
        <div class="glass-effect" style="padding: 2rem; text-align: center; border-radius: 16px;">
            <div style="font-size: 3rem; font-weight: 700; color: #f59e0b; margin-bottom: 0.5rem;" id="ratingAvg">0.0</div>
            <div style="color: var(--light); font-weight: 600; margin-bottom: 0.5rem;">Calificación Promedio</div>
            <div style="color: var(--gray-light); font-size: 0.875rem;">Basada en reseñas</div>
        </div>
    </div>
</section>

<!-- Featured Tiendas -->
<section style="margin-bottom: 4rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="color: var(--light); font-size: 1.8rem;">
            <i class="fas fa-store"></i> Tiendas Destacadas
        </h2>
        <a href="/tiendas" style="color: var(--primary); text-decoration: none; font-weight: 600;">
            Ver todas <i class="fas fa-arrow-right" style="font-size: 0.875rem;"></i>
        </a>
    </div>
    
    <div id="featuredStores" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        <!-- Tiendas se cargarán aquí -->
    </div>
    
    <div id="storesLoading" style="text-align: center; padding: 2rem;">
        <div class="loading" style="width: 30px; height: 30px; margin: 0 auto 1rem;"></div>
        <div style="color: var(--gray);">Cargando tiendas destacadas...</div>
    </div>
</section>

<!-- Featured Products -->
<section style="margin-bottom: 4rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="color: var(--light); font-size: 1.8rem;">
            <i class="fas fa-fire"></i> Productos Populares
        </h2>
        <a href="/productos" style="color: var(--primary); text-decoration: none; font-weight: 600;">
            Ver todos <i class="fas fa-arrow-right" style="font-size: 0.875rem;"></i>
        </a>
    </div>
    
    <div id="featuredProducts" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
        <!-- Productos se cargarán aquí -->
    </div>
    
    <div id="productsLoading" style="text-align: center; padding: 2rem;">
        <div class="loading" style="width: 30px; height: 30px; margin: 0 auto 1rem;"></div>
        <div style="color: var(--gray);">Cargando productos populares...</div>
    </div>
</section>

<!-- Categorías -->
<section style="margin-bottom: 4rem;">
    <h2 style="color: var(--light); font-size: 1.8rem; margin-bottom: 1.5rem; text-align: center;">
        <i class="fas fa-tags"></i> Explora por Categorías
    </h2>
    
    <div id="categoriesGrid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <!-- Categorías se cargarán aquí -->
    </div>
</section>

<!-- CTA Section -->
<section class="glass-effect" style="padding: 4rem 2rem; border-radius: 24px; text-align: center; margin-bottom: 4rem;">
    <h2 style="font-size: 2.5rem; color: var(--light); margin-bottom: 1rem;">
        ¿Eres un emprendedor?
    </h2>
    <p style="font-size: 1.2rem; color: var(--gray-light); margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
        Únete a NovaMarket y lleva tu negocio al siguiente nivel. Conecta con miles de clientes 
        y comienza a vender tus productos hoy mismo.
    </p>
    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <a href="/register" class="btn-primary" style="font-size: 1.1rem; padding: 16px 32px;">
            <i class="fas fa-rocket"></i> Crear Mi Tienda
        </a>
        <a href="#" class="btn-secondary" style="font-size: 1.1rem; padding: 16px 32px;">
            <i class="fas fa-question-circle"></i> Más Información
        </a>
    </div>
</section>

<!-- Testimonios -->
<section style="margin-bottom: 4rem;">
    <h2 style="color: var(--light); font-size: 1.8rem; margin-bottom: 1.5rem; text-align: center;">
        <i class="fas fa-comment"></i> Lo que dicen nuestros usuarios
    </h2>
    
    <div id="testimonials" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <!-- Testimonios se cargarán aquí -->
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', async function() {
    await loadStats();
    await loadFeaturedStores();
    await loadFeaturedProducts();
    await loadCategories();
    await loadTestimonials();
});

// Cargar estadísticas
async function loadStats() {
    try {
        // En una implementación real, esto vendría de una API
        // Por ahora, usaremos valores por defecto
        document.getElementById('storesCount').textContent = '250+';
        document.getElementById('productsCount').textContent = '5,000+';
        document.getElementById('ordersCount').textContent = '10,000+';
        document.getElementById('ratingAvg').textContent = '4.8';
    } catch (error) {
        console.error('Error loading stats:', error);
    }
}

// Cargar tiendas destacadas
async function loadFeaturedStores() {
    try {
        const response = await axios.get('/api/tiendas?destacadas=true&limit=3');
        const stores = response.data.data || response.data.slice(0, 3);
        
        const container = document.getElementById('featuredStores');
        const loading = document.getElementById('storesLoading');
        
        if (stores.length === 0) {
            container.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--gray);">
                    <i class="fas fa-store-slash" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                    <p>No hay tiendas destacadas en este momento</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = stores.map(store => `
            <div class="glass-effect" style="padding: 1.5rem; border-radius: 16px; cursor: pointer;"
                 onclick="window.location.href='/tiendas/${store.id}'">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
                                display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                        <i class="fas fa-store"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="color: var(--light); margin-bottom: 0.25rem;">${store.nombre}</h3>
                        <div style="color: var(--gray-light); font-size: 0.875rem;">
                            <i class="fas fa-user"></i> ${store.dueno?.name || 'Emprendedor'}
                        </div>
                    </div>
                </div>
                <p style="color: var(--gray-light); font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.5;">
                    ${store.descripcion?.substring(0, 100) || 'Sin descripción'}...
                </p>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--gray-light); font-size: 0.875rem;">
                            <i class="fas fa-box"></i> ${store.productos_count || 0} productos
                        </div>
                    </div>
                    <div style="color: var(--secondary); font-weight: 600;">
                        ${store.calificacion_promedio ? '★'.repeat(Math.round(store.calificacion_promedio)) : ''}
                    </div>
                </div>
            </div>
        `).join('');
        
        loading.style.display = 'none';
        
    } catch (error) {
        console.error('Error loading featured stores:', error);
        document.getElementById('storesLoading').innerHTML = `
            <div style="color: #f87171;">
                <i class="fas fa-exclamation-triangle"></i> Error al cargar las tiendas
            </div>
        `;
    }
}

// Cargar productos destacados
async function loadFeaturedProducts() {
    try {
        const response = await axios.get('/api/productos?destacados=true&limit=4');
        const products = response.data.data || response.data.slice(0, 4);
        
        const container = document.getElementById('featuredProducts');
        const loading = document.getElementById('productsLoading');
        
        if (products.length === 0) {
            container.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--gray);">
                    <i class="fas fa-box-open" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                    <p>No hay productos destacados en este momento</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = products.map(product => `
            <div class="glass-effect" style="padding: 1.5rem; border-radius: 16px; cursor: pointer;"
                 onclick="window.location.href='/productos/${product.id}'">
                <div style="width: 100%; height: 150px; border-radius: 12px; overflow: hidden; margin-bottom: 1rem;">
                    <img src="${product.imagen_url || 'https://via.placeholder.com/250x150'}" 
                         alt="${product.nombre}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <h3 style="color: var(--light); font-size: 1rem; margin-bottom: 0.5rem; line-height: 1.4;">
                    ${product.nombre.substring(0, 50)}${product.nombre.length > 50 ? '...' : ''}
                </h3>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 700; color: var(--primary);">
                            $${parseFloat(product.precio).toFixed(2)}
                        </div>
                        <div style="font-size: 0.75rem; color: var(--gray-light);">
                            ${product.tienda?.nombre?.substring(0, 20) || 'Tienda'}${product.tienda?.nombre?.length > 20 ? '...' : ''}
                        </div>
                    </div>
                    <button onclick="event.stopPropagation(); addToCart(${product.id})" 
                            class="btn-primary" style="padding: 6px 12px;">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        `).join('');
        
        loading.style.display = 'none';
        
    } catch (error) {
        console.error('Error loading featured products:', error);
        document.getElementById('productsLoading').innerHTML = `
            <div style="color: #f87171;">
                <i class="fas fa-exclamation-triangle"></i> Error al cargar los productos
            </div>
        `;
    }
}

// Cargar categorías
async function loadCategories() {
    try {
        const response = await axios.get('/api/categorias');
        const categories = response.data.slice(0, 6);
        
        const container = document.getElementById('categoriesGrid');
        
        if (categories.length === 0) {
            // Si no hay categorías en la API, mostrar algunas por defecto
            const defaultCategories = [
                { nombre: 'Artesanías', icon: 'fas fa-hands', color: '#8b5cf6' },
                { nombre: 'Ropa', icon: 'fas fa-tshirt', color: '#3b82f6' },
                { nombre: 'Alimentos', icon: 'fas fa-utensils', color: '#10b981' },
                { nombre: 'Hogar', icon: 'fas fa-home', color: '#f59e0b' },
                { nombre: 'Tecnología', icon: 'fas fa-laptop', color: '#6366f1' },
                { nombre: 'Belleza', icon: 'fas fa-spa', color: '#ec4899' }
            ];
            
            container.innerHTML = defaultCategories.map(cat => `
                <div class="glass-effect" style="padding: 1.5rem; border-radius: 16px; cursor: pointer; text-align: center;"
                     onclick="window.location.href='/productos?categoria=${encodeURIComponent(cat.nombre)}'">
                    <div style="font-size: 2rem; color: ${cat.color}; margin-bottom: 0.5rem;">
                        <i class="${cat.icon}"></i>
                    </div>
                    <div style="font-weight: 600; color: var(--light);">${cat.nombre}</div>
                    <div style="font-size: 0.875rem; color: var(--gray-light); margin-top: 0.25rem;">
                        Ver productos
                    </div>
                </div>
            `).join('');
            
            return;
        }
        
        container.innerHTML = categories.map(cat => `
            <div class="glass-effect" style="padding: 1.5rem; border-radius: 16px; cursor: pointer; text-align: center;"
                 onclick="window.location.href='/productos?categoria=${encodeURIComponent(cat.nombre)}'">
                <div style="font-size: 2rem; color: var(--primary); margin-bottom: 0.5rem;">
                    <i class="fas fa-tag"></i>
                </div>
                <div style="font-weight: 600; color: var(--light);">${cat.nombre}</div>
                <div style="font-size: 0.875rem; color: var(--gray-light); margin-top: 0.25rem;">
                    ${cat.productos_count || 0} productos
                </div>
            </div>
        `).join('');
        
    } catch (error) {
        console.error('Error loading categories:', error);
    }
}

// Cargar testimonios
async function loadTestimonials() {
    try {
        // En una implementación real, esto vendría de una API
        const testimonials = [
            {
                name: "María González",
                role: "Compradora",
                comment: "Encontré productos únicos que no consigo en ninguna otra tienda. La calidad es excelente y los emprendedores son muy atentos.",
                rating: 5,
                avatar: "M"
            },
            {
                name: "Carlos Rodríguez",
                role: "Emprendedor",
                comment: "NovaMarket me ha permitido llegar a muchos más clientes. La plataforma es fácil de usar y el soporte es excelente.",
                rating: 5,
                avatar: "C"
            },
            {
                name: "Ana Martínez",
                role: "Compradora frecuente",
                comment: "Me encanta apoyar a emprendedores locales. Siempre encuentro regalos especiales para mi familia y amigos.",
                rating: 4,
                avatar: "A"
            }
        ];
        
        const container = document.getElementById('testimonials');
        
        container.innerHTML = testimonials.map(testimonial => `
            <div class="glass-effect" style="padding: 1.5rem; border-radius: 16px;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
                                display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.2rem;">
                        ${testimonial.avatar}
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--light);">${testimonial.name}</div>
                        <div style="color: var(--gray-light); font-size: 0.875rem;">${testimonial.role}</div>
                    </div>
                </div>
                <div style="color: #fbbf24; margin-bottom: 1rem;">
                    ${'★'.repeat(testimonial.rating)}${'☆'.repeat(5 - testimonial.rating)}
                </div>
                <p style="color: var(--light); line-height: 1.6; font-style: italic;">
                    "${testimonial.comment}"
                </p>
            </div>
        `).join('');
        
    } catch (error) {
        console.error('Error loading testimonials:', error);
    }
}

// Función para agregar al carrito
async function addToCart(productId) {
    if (!window.NovaMarket.token) {
        window.showAlert('Debes iniciar sesión para agregar al carrito', 'error');
        window.location.href = '/login';
        return;
    }
    
    try {
        const response = await axios.get(`/api/productos/${productId}`);
        const producto = response.data;
        
        // Agregar al carrito
        const cart = window.NovaMarket.cart || { items: [], count: 0 };
        
        const existingItem = cart.items.find(item => item.id === producto.id);
        
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
        
    } catch (error) {
        console.error('Error adding to cart:', error);
        window.showAlert('Error al agregar al carrito', 'error');
    }
}

function updateCartCount() {
    const cartCount = document.getElementById('cartCount');
    if (cartCount) {
        cartCount.textContent = window.NovaMarket.cart?.count || 0;
    }
}
</script>
@endsection
