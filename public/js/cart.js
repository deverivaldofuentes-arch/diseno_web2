// Gestión del carrito

class CartManager {
    constructor() {
        this.cart = JSON.parse(localStorage.getItem('cart') || '{"items":[],"count":0}');
    }

    // Obtener carrito
    getCart() {
        return this.cart;
    }

    // Agregar producto
    addProduct(product, quantity = 1) {
        // Verificar stock
        if (quantity > product.stock) {
            throw new Error(`Stock insuficiente. Máximo disponible: ${product.stock}`);
        }

        const existingItem = this.cart.items.find(item => item.id === product.id);

        if (existingItem) {
            const newQuantity = existingItem.quantity + quantity;
            if (newQuantity > product.stock) {
                throw new Error(`Stock insuficiente. Máximo disponible: ${product.stock}`);
            }
            existingItem.quantity = newQuantity;
        } else {
            this.cart.items.push({
                id: product.id,
                nombre: product.nombre,
                precio: product.precio,
                imagen_url: product.imagen_url,
                stock: product.stock,
                tienda_id: product.tienda_id,
                quantity: quantity
            });
        }

        this.updateCount();
        this.save();
        this.updateUI();
    }

    // Actualizar cantidad
    updateQuantity(productId, quantity) {
        const item = this.cart.items.find(item => item.id === productId);
        if (!item) return;

        if (quantity < 1) {
            this.removeProduct(productId);
            return;
        }

        if (quantity > item.stock) {
            throw new Error(`Stock insuficiente. Máximo disponible: ${item.stock}`);
        }

        item.quantity = quantity;
        this.updateCount();
        this.save();
        this.updateUI();
    }

    // Eliminar producto
    removeProduct(productId) {
        this.cart.items = this.cart.items.filter(item => item.id !== productId);
        this.updateCount();
        this.save();
        this.updateUI();
    }

    // Limpiar carrito
    clear() {
        this.cart = { items: [], count: 0 };
        this.save();
        this.updateUI();
    }

    // Actualizar contador
    updateCount() {
        this.cart.count = this.cart.items.reduce((total, item) => total + item.quantity, 0);
    }

    // Calcular subtotal
    getSubtotal() {
        return this.cart.items.reduce((total, item) => total + (parseFloat(item.precio) * item.quantity), 0);
    }

    // Calcular total con descuento y envío
    getTotal(discount = 0, shipping = 0) {
        const subtotal = this.getSubtotal();
        return subtotal - discount + shipping;
    }

    // Verificar disponibilidad de stock
    checkStock() {
        const errors = [];
        
        this.cart.items.forEach(item => {
            if (item.quantity > item.stock) {
                errors.push({
                    productId: item.id,
                    productName: item.nombre,
                    availableStock: item.stock,
                    requestedQuantity: item.quantity
                });
            }
        });

        return errors;
    }

    // Guardar en localStorage
    save() {
        localStorage.setItem('cart', JSON.stringify(this.cart));
        window.NovaMarket.cart = this.cart;
    }

    // Actualizar UI
    updateUI() {
        // Actualizar contador en navbar
        const cartCount = document.getElementById('cartCount');
        if (cartCount) {
            cartCount.textContent = this.cart.count || 0;
        }

        // Si estamos en la página del carrito, actualizar la lista
        if (window.location.pathname.includes('/carrito')) {
            this.renderCartPage();
        }
    }

    // Renderizar página del carrito
    renderCartPage() {
        if (!document.getElementById('cartItems')) return;

        if (this.cart.items.length === 0) {
            document.getElementById('cartEmpty').style.display = 'block';
            document.getElementById('cartContent').style.display = 'none';
            return;
        }

        document.getElementById('cartEmpty').style.display = 'none';
        document.getElementById('cartContent').style.display = 'block';

        // Renderizar items
        this.renderCartItems();
        this.calculateTotals();
    }

    renderCartItems() {
        const container = document.getElementById('cartItems');
        if (!container) return;

        container.innerHTML = this.cart.items.map(item => `
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
                    <button onclick="cartManager.updateQuantity(${item.id}, ${item.quantity - 1})" 
                            style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--glass-border); 
                                   background: rgba(255,255,255,0.05); color: var(--light); cursor: pointer;">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" value="${item.quantity}" min="1" max="${item.stock}" 
                           onchange="cartManager.updateQuantity(${item.id}, this.value)"
                           style="width: 50px; text-align: center; padding: 6px; border: 1px solid var(--glass-border); 
                                  border-radius: 8px; background: rgba(255,255,255,0.05); color: var(--light);">
                    <button onclick="cartManager.updateQuantity(${item.id}, ${item.quantity + 1})" 
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
                <button onclick="cartManager.removeProduct(${item.id})" 
                        style="background: none; border: none; color: #f87171; cursor: pointer; padding: 8px;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `).join('');
    }

    calculateTotals() {
        const subtotal = this.getSubtotal();
        const discount = 0; // Se calcularía con cupón
        const shipping = 0; // Se calcularía con método de envío
        
        document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('discount').textContent = `$${discount.toFixed(2)}`;
        document.getElementById('shippingCost').textContent = `$${shipping.toFixed(2)}`;
        document.getElementById('total').textContent = `$${this.getTotal(discount, shipping).toFixed(2)}`;
    }
}

// Instanciar y exportar
const cartManager = new CartManager();
window.cartManager = cartManager;

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    cartManager.updateUI();
});
