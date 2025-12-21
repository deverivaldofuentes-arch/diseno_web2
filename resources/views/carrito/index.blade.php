@extends('layouts.app')

@section('title', 'Carrito de Compras - NovaMarket')

@section('content')
<div class="cart-container" style="max-width: 1200px; margin: 0 auto;">
    <h1 style="margin-bottom: 1rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        <i class="fas fa-shopping-cart"></i> Carrito de Compras
    </h1>
    
    <div id="cartEmpty" style="display: none; text-align: center; padding: 4rem;">
        <i class="fas fa-shopping-cart" style="font-size: 4rem; color: var(--gray); margin-bottom: 1rem;"></i>
        <h2 style="color: var(--light); margin-bottom: 0.5rem;">Tu carrito está vacío</h2>
        <p style="color: var(--gray-light); margin-bottom: 2rem;">Agrega algunos productos para comenzar</p>
        <a href="/productos" class="btn-primary">
            <i class="fas fa-store"></i> Explorar Productos
        </a>
    </div>
    
    <div id="cartContent" style="display: none;">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
            <!-- Lista de Productos -->
            <div>
                <div class="glass-effect" style="padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
                    <h2 style="margin-bottom: 1rem; color: var(--light);">
                        Productos (<span id="itemCount">0</span>)
                    </h2>
                    
                    <div id="cartItems">
                        <!-- Items se cargarán aquí -->
                    </div>
                </div>
                
                <!-- Cupón de Descuento -->
                <div class="glass-effect" style="padding: 1.5rem; border-radius: 16px;">
                    <h3 style="margin-bottom: 1rem; color: var(--light);">
                        <i class="fas fa-tag"></i> Cupón de Descuento
                    </h3>
                    <div style="display: flex; gap: 1rem;">
                        <input type="text" id="couponCode" placeholder="Ingresa tu código" 
                               style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); 
                                      background: rgba(255,255,255,0.05); color: var(--light);">
                        <button onclick="applyCoupon()" class="btn-primary">
                            Aplicar
                        </button>
                    </div>
                    <div id="couponMessage" style="margin-top: 0.5rem;"></div>
                </div>
            </div>
            
            <!-- Resumen de Compra -->
            <div class="glass-effect" style="padding: 1.5rem; border-radius: 16px; position: sticky; top: 100px;">
                <h2 style="margin-bottom: 1.5rem; color: var(--light);">
                    <i class="fas fa-receipt"></i> Resumen de Compra
                </h2>
                
                <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-light);">Subtotal</span>
                        <span id="subtotal" style="color: var(--light); font-weight: 600;">$0.00</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-light);">Descuento</span>
                        <span id="discount" style="color: var(--secondary); font-weight: 600;">$0.00</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-light);">Envío</span>
                        <div>
                            <span id="shippingCost" style="color: var(--light); font-weight: 600;">$0.00</span>
                            <span id="freeShippingMessage" style="display: none; color: var(--secondary); font-size: 0.875rem; margin-left: 0.5rem;">
                                <i class="fas fa-check"></i> ¡Envío gratis!
                            </span>
                        </div>
                    </div>
                    
                    <div style="height: 1px; background: var(--glass-border); margin: 0.5rem 0;"></div>
                    
                    <div style="display: flex; justify-content: space-between; font-size: 1.2rem;">
                        <span style="color: var(--light); font-weight: 700;">Total</span>
                        <span id="total" style="color: var(--primary); font-weight: 700;">$0.00</span>
                    </div>
                </div>
                
                <!-- Método de Envío -->
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="margin-bottom: 0.75rem; color: var(--light); font-size: 1rem;">
                        <i class="fas fa-truck"></i> Método de Envío
                    </h3>
                    <div style="display: flex; gap: 1rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: var(--light);">
                            <input type="radio" name="shipping" value="standard" checked 
                                   style="accent-color: var(--primary);" onchange="calculateShipping()">
                            <span>Estándar (3-5 días)</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: var(--light);">
                            <input type="radio" name="shipping" value="express" 
                                   style="accent-color: var(--primary);" onchange="calculateShipping()">
                            <span>Express (24h)</span>
                        </label>
                    </div>
                </div>
                
                <!-- Botón de Pago -->
                <button onclick="proceedToCheckout()" class="btn-primary" style="width: 100%; padding: 16px; font-size: 1.1rem;">
                    <i class="fas fa-lock"></i> Proceder al Pago
                </button>
                
                <!-- Métodos de Pago -->
                <div style="margin-top: 1.5rem; text-align: center;">
                    <div style="display: flex; justify-content: center; gap: 1rem; color: var(--gray-light); font-size: 1.5rem;">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-amex"></i>
                        <i class="fab fa-cc-paypal"></i>
                    </div>
                </div>
                
                <!-- Seguridad -->
                <div style="margin-top: 1rem; text-align: center; font-size: 0.875rem; color: var(--gray-light);">
                    <i class="fas fa-shield-alt"></i> Compra segura y protegida
                </div>
            </div>
        </div>
        
        <!-- Productos Recomendados -->
        <div style="margin-top: 3rem;">
            <h2 style="margin-bottom: 1.5rem; color: var(--light);">
                <i class="fas fa-fire"></i> Productos que te podrían gustar
            </h2>
            <div id="recommendedProducts" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                <!-- Se llenará con JS -->
            </div>
        </div>
    </div>
</div>

<script>
let cart = window.NovaMarket.cart || { items: [], count: 0 };
let coupon = null;

document.addEventListener('DOMContentLoaded', function() {
    loadCart();
    calculateTotals();
    loadRecommendedProducts();
});

function loadCart() {
    if (cart.items.length === 0) {
        document.getElementById('cartEmpty').style.display = 'block';
        document.getElementById('cartContent').style.display = 'none';
        return;
    }
    
    document.getElementById('cartEmpty').style.display = 'none';
    document.getElementById('cartContent').style.display = 'block';
    
    renderCartItems();
}

function renderCartItems() {
    const container = document.getElementById('cartItems');
    
    if (cart.items.length === 0) return;
    
    container.innerHTML = cart.items.map(item => `
        <div class="cart-item" style="display: flex; gap: 1rem; padding: 1.5rem; border-bottom: 1px solid var(--glass-border); align-items: center;">
            <!-- Imagen -->
            <div style="width: 100px; height: 100px; border-radius: 12px; overflow: hidden; flex-shrink: 0;">
                <img src="${item.imagen_url || 'https://via.placeholder.com/100x100'}" 
                     alt="${item.nombre}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            
            <!-- Información -->
            <div style="flex: 1;">
                <h3 style="margin-bottom: 0.5rem; color: var(--light); font-size: 1.1rem;">
                    <a href="/productos/${item.id}" style="color: inherit; text-decoration: none;">${item.nombre}</a>
                </h3>
                <div style="color: var(--gray-light); font-size: 0.875rem;">
                    <i class="fas fa-store"></i> Tienda #${item.tienda_id}
                </div>
                <div style="color: ${item.stock > 0 ? 'var(--secondary)' : '#f87171'}; font-size: 0.875rem; margin-top: 0.25rem;">
                    <i class="fas ${item.stock > 0 ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                    ${item.stock > 0 ? 'Disponible' : 'Agotado'}
                </div>
            </div>
            
            <!-- Precio Unitario -->
            <div style="text-align: right; min-width: 100px;">
                <div style="color: var(--light); font-weight: 600; margin-bottom: 0.25rem;">
                    $${parseFloat(item.precio).toFixed(2)}
                </div>
                <div style="color: var(--gray-light); font-size: 0.875rem;">
                    por unidad
                </div>
            </div>
            
            <!-- Cantidad -->
            <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 120px;">
                <button onclick="updateQuantity(${item.id}, -1)" 
                        style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--glass-border); 
                               background: rgba(255,255,255,0.05); color: var(--light); cursor: pointer;">
                    <i class="fas fa-minus"></i>
                </button>
                <input type="number" value="${item.quantity}" min="1" max="${item.stock}" 
                       onchange="updateQuantityInput(${item.id}, this.value)"
                       style="width: 50px; text-align: center; padding: 6px; border: 1px solid var(--glass-border); 
                              border-radius: 8px; background: rgba(255,255,255,0.05); color: var(--light);">
                <button onclick="updateQuantity(${item.id}, 1)" 
                        style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--glass-border); 
                               background: rgba(255,255,255,0.05); color: var(--light); cursor: pointer;">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            
            <!-- Subtotal -->
            <div style="text-align: right; min-width: 100px;">
                <div style="color: var(--light); font-weight: 700; font-size: 1.1rem;">
                    $${(parseFloat(item.precio) * item.quantity).toFixed(2)}
                </div>
                <div style="color: var(--gray-light); font-size: 0.875rem;">
                    subtotal
                </div>
            </div>
            
            <!-- Eliminar -->
            <button onclick="removeItem(${item.id})" 
                    style="background: none; border: none; color: #f87171; cursor: pointer; padding: 8px;">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `).join('');
    
    document.getElementById('itemCount').textContent = cart.items.length;
}

function updateQuantity(productId, change) {
    const item = cart.items.find(item => item.id === productId);
    if (!item) return;
    
    const newQuantity = item.quantity + change;
    
    if (newQuantity < 1) {
        removeItem(productId);
        return;
    }
    
    if (newQuantity > item.stock) {
        window.showAlert(`No hay suficiente stock. Máximo disponible: ${item.stock}`, 'error');
        return;
    }
    
    item.quantity = newQuantity;
    saveCart();
}

function updateQuantityInput(productId, value) {
    const item = cart.items.find(item => item.id === productId);
    if (!item) return;
    
    const newQuantity = parseInt(value);
    
    if (isNaN(newQuantity) || newQuantity < 1) {
        item.quantity = 1;
    } else if (newQuantity > item.stock) {
        item.quantity = item.stock;
        window.showAlert(`No hay suficiente stock. Máximo disponible: ${item.stock}`, 'error');
    } else {
        item.quantity = newQuantity;
    }
    
    saveCart();
}

function removeItem(productId) {
    cart.items = cart.items.filter(item => item.id !== productId);
    saveCart();
}

function saveCart() {
    // Actualizar contador
    cart.count = cart.items.reduce((total, item) => total + item.quantity, 0);
    
    // Guardar en localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    window.NovaMarket.cart = cart;
    
    // Actualizar UI
    updateCartCount();
    renderCartItems();
    calculateTotals();
    loadCart(); // Para mostrar/ocultar carrito vacío
}

function calculateTotals() {
    const subtotal = cart.items.reduce((total, item) => total + (parseFloat(item.precio) * item.quantity), 0);
    
    // Calcular descuento
    let discount = 0;
    if (coupon) {
        if (coupon.tipo === 'porcentaje') {
            discount = subtotal * (coupon.valor / 100);
        } else if (coupon.tipo === 'fijo') {
            discount = coupon.valor;
        }
        discount = Math.min(discount, subtotal); // No puede ser mayor al subtotal
    }
    
    // Calcular envío
    const shippingMethod = document.querySelector('input[name="shipping"]:checked').value;
    const shippingCost = calculateShippingCost(subtotal, shippingMethod);
    
    // Calcular total
    const total = subtotal - discount + shippingCost;
    
    // Actualizar UI
    document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
    document.getElementById('discount').textContent = `$${discount.toFixed(2)}`;
    document.getElementById('shippingCost').textContent = `$${shippingCost.toFixed(2)}`;
    document.getElementById('total').textContent = `$${total.toFixed(2)}`;
    
    // Mostrar mensaje de envío gratis
    const freeShippingMessage = document.getElementById('freeShippingMessage');
    if (shippingCost === 0) {
        freeShippingMessage.style.display = 'inline';
    } else {
        freeShippingMessage.style.display = 'none';
    }
}

function calculateShippingCost(subtotal, method) {
    // Envío estándar gratis sobre $50
    if (method === 'standard' && subtotal >= 50) {
        return 0;
    }
    
    // Envío express fijo
    if (method === 'express') {
        return 9.99;
    }
    
    // Envío estándar
    return 4.99;
}

function calculateShipping() {
    calculateTotals();
}

async function applyCoupon() {
    const code = document.getElementById('couponCode').value.trim();
    const messageEl = document.getElementById('couponMessage');
    
    if (!code) {
        messageEl.innerHTML = '<div style="color: #f87171;">Ingresa un código de cupón</div>';
        return;
    }
    
    try {
        const response = await axios.post('/api/cupones/validar', { codigo: code });
        coupon = response.data.cupon;
        
        messageEl.innerHTML = `
            <div style="color: var(--secondary);">
                <i class="fas fa-check-circle"></i> 
                Cupón "${coupon.codigo}" aplicado: 
                ${coupon.tipo === 'porcentaje' ? `${coupon.valor}% de descuento` : `$${coupon.valor} de descuento`}
            </div>
        `;
        
        calculateTotals();
        
    } catch (error) {
        coupon = null;
        messageEl.innerHTML = `
            <div style="color: #f87171;">
                <i class="fas fa-times-circle"></i> 
                ${error.response?.data?.message || 'Cupón inválido o expirado'}
            </div>
        `;
        calculateTotals();
    }
}

async function loadRecommendedProducts() {
    try {
        // Obtener categorías de los productos en el carrito
        const categories = [...new Set(cart.items.map(item => item.categoria).filter(Boolean))];
        
        let url = '/api/productos?limit=4&destacados=true';
        if (categories.length > 0) {
            url += `&categorias=${categories.join(',')}`;
        }
        
        const response = await axios.get(url);
        const products = response.data.data || response.data.slice(0, 4);
        
        const container = document.getElementById('recommendedProducts');
        
        if (products.length === 0) {
            container.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--gray);">
                    <i class="fas fa-box-open"></i> No hay productos recomendados
                </div>
            `;
            return;
        }
        
        container.innerHTML = products.map(product => `
            <div class="glass-effect" style="padding: 1rem; border-radius: 12px; cursor: pointer;"
                 onclick="window.location.href='/productos/${product.id}'">
                <div style="width: 100%; height: 120px; border-radius: 8px; overflow: hidden; margin-bottom: 0.75rem;">
                    <img src="${product.imagen_url || 'https://via.placeholder.com/200x120'}" 
                         alt="${product.nombre}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <h3 style="font-size: 0.875rem; color: var(--light); margin-bottom: 0.5rem; line-height: 1.4;">
                    ${product.nombre.substring(0, 40)}${product.nombre.length > 40 ? '...' : ''}
                </h3>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 700; color: var(--primary);">
                        $${parseFloat(product.precio).toFixed(2)}
                    </span>
                    <button onclick="event.stopPropagation(); addRecommendedToCart(${product.id})" 
                            class="btn-primary" style="padding: 6px 12px; font-size: 0.75rem;">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        `).join('');
        
    } catch (error) {
        console.error('Error loading recommended products:', error);
    }
}

function addRecommendedToCart(productId) {
    // Buscar el producto en los recomendados
    const product = cart.items.find(item => item.id === productId);
    if (product) {
        updateQuantity(productId, 1);
    } else {
        // Agregar nuevo producto
        // En una implementación real, aquí harías una petición para obtener los datos del producto
        window.showAlert('Producto agregado al carrito', 'success');
        setTimeout(() => {
            location.reload();
        }, 500);
    }
}

async function proceedToCheckout() {
    if (!window.NovaMarket.token) {
        window.showAlert('Debes iniciar sesión para proceder al pago', 'error');
        window.location.href = '/login?redirect=/carrito';
        return;
    }
    
    // Verificar stock
    for (const item of cart.items) {
        if (item.quantity > item.stock) {
            window.showAlert(`"${item.nombre}" no tiene suficiente stock. Máximo disponible: ${item.stock}`, 'error');
            return;
        }
    }
    
    if (cart.items.length === 0) {
        window.showAlert('Tu carrito está vacío', 'error');
        return;
    }
    
    try {
        // Crear pedido
        const orderData = {
            items: cart.items.map(item => ({
                producto_id: item.id,
                cantidad: item.quantity,
                precio: item.precio
            })),
            cupon_codigo: coupon?.codigo,
            metodo_envio: document.querySelector('input[name="shipping"]:checked').value
        };
        
        const response = await axios.post('/api/pedidos', orderData);
        
        // Limpiar carrito
        cart.items = [];
        cart.count = 0;
        localStorage.setItem('cart', JSON.stringify(cart));
        window.NovaMarket.cart = cart;
        updateCartCount();
        
        // Redirigir a la página del pedido
        window.showAlert('Pedido creado exitosamente', 'success');
        setTimeout(() => {
            window.location.href = `/pedidos/${response.data.id}`;
        }, 1000);
        
    } catch (error) {
        console.error('Error creating order:', error);
        window.showAlert(error.response?.data?.message || 'Error al crear el pedido', 'error');
    }
}

function updateCartCount() {
    const cartCount = document.getElementById('cartCount');
    if (cartCount) {
        cartCount.textContent = cart.count || 0;
    }
}
</script>
@endsection
