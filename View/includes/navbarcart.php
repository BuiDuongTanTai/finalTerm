<!-- Cart Modal -->
<div class="modal fade" id="cart-modal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Giỏ hàng của bạn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="cart-modal-body">
                <!-- Cart content will be loaded here dynamically -->
                <div class="text-center py-4" id="cart-loading" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="cart-modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
// Global cart data để lưu trữ giỏ hàng
let currentCartData = {
    items: [],
    total_amount: 0
};

// Hàm load giỏ hàng động - chỉ gọi khi cần thiết
function loadCartModal() {
    const cartModalBody = document.getElementById('cart-modal-body');
    const cartModalFooter = document.getElementById('cart-modal-footer');
    const cartLoading = document.getElementById('cart-loading');
    
    if (!cartModalBody || !cartModalFooter) return;
    
    // Hiển thị loading chỉ khi chưa có dữ liệu
    if (currentCartData.items.length === 0) {
        if (cartLoading) {
            cartLoading.style.display = 'block';
        }
        cartModalBody.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Đang tải...</span></div></div>';
        
        fetch('index.php?page=ajax_cart')
        .then(response => response.json())
        .then(data => {
            currentCartData = data;
            renderCartModal();
        })
        .catch(error => {
            console.error('Error loading cart:', error);
            renderEmptyCart('Có lỗi xảy ra khi tải giỏ hàng');
        });
    } else {
        // Sử dụng dữ liệu đã có
        renderCartModal();
    }
}

// Hàm render giỏ hàng
function renderCartModal() {
    const cartModalBody = document.getElementById('cart-modal-body');
    const cartModalFooter = document.getElementById('cart-modal-footer');
    const cartLoading = document.getElementById('cart-loading');
    
    if (!cartModalBody || !cartModalFooter) return;
    
    // Ẩn loading
    if (cartLoading) {
        cartLoading.style.display = 'none';
    }
    
    const cart_items = currentCartData.items || [];
    const total = currentCartData.total_amount || 0;
    
    if (cart_items.length === 0) {
        renderEmptyCart();
        return;
    }
    
    let cartHTML = '<div class="cart-items">';
    
    cart_items.forEach(item => {
        cartHTML += `
            <div class="card mb-3" id="cart-item-${item.id}">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <div class="cart-thumbnail" style="background-image: url('${item.image_url}'); width: 80px; height: 80px; background-size: contain; background-position: center; background-repeat: no-repeat; border-radius: 10px; background-color: #f8f9fa;"></div>
                        </div>
                        <div class="col-9">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title mb-1">${item.name}</h6>
                                <button type="button" class="btn btn-sm btn-outline-danger cart-remove-btn" data-cart-id="${item.id}">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-0 text-primary fw-bold">
                                        ${formatPrice(item.price)}đ
                                        ${item.old_price && item.old_price > item.price ? 
                                            `<span class="text-muted text-decoration-line-through ms-2 small">${formatPrice(item.old_price)}đ</span>` 
                                            : ''}
                                    </p>
                                    <div class="mt-2 d-flex align-items-center">
                                        <span class="me-2">Số lượng:</span>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-sm btn-outline-secondary cart-quantity-decrease" data-cart-id="${item.id}">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <span class="mx-2 fw-bold" id="quantity-${item.id}">${item.quantity}</span>
                                            <button type="button" class="btn btn-sm btn-outline-secondary cart-quantity-increase" data-cart-id="${item.id}" data-max="${item.stock}">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 fw-bold text-primary" id="subtotal-${item.id}">
                                    ${formatPrice(item.price * item.quantity)}đ
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    cartHTML += '</div>';
    
    // Tính phí vận chuyển
    const shipping = total >= 5000000 ? 0 : 50000;
    
    cartHTML += `
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span>Tạm tính:</span>
                <span class="fw-bold" id="cart-subtotal">${formatPrice(total)}đ</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span>Phí vận chuyển:</span>
                <span class="fw-bold" id="cart-shipping">
                    ${shipping > 0 ? formatPrice(shipping) + 'đ' : 'Miễn phí'}
                </span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-bold">Tổng cộng:</span>
                <span class="h5 mb-0 text-primary fw-bold" id="cart-total">
                    ${formatPrice(total + shipping)}đ
                </span>
            </div>
        </div>
    `;
    
    cartModalBody.innerHTML = cartHTML;
    cartModalFooter.innerHTML = `
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <a href="index.php?page=cart" class="btn btn-outline-primary">Xem giỏ hàng</a>
        <a href="index.php?page=checkout" class="btn btn-primary">Thanh toán</a>
    `;
    
    // Gắn sự kiện cho các nút trong modal
    attachCartModalEvents();
}

// Hàm render giỏ hàng trống
function renderEmptyCart(message = 'Giỏ hàng của bạn đang trống') {
    const cartModalBody = document.getElementById('cart-modal-body');
    const cartModalFooter = document.getElementById('cart-modal-footer');
    
    if (!cartModalBody || !cartModalFooter) return;
    
    cartModalBody.innerHTML = `
        <div class="text-center py-4">
            <i class="bi bi-cart-x" style="font-size: 3rem; color: #ccc;"></i>
            <p class="mt-3">${message}</p>
            <a href="index.php?page=all_products" class="btn btn-primary mt-2">Tiếp tục mua sắm</a>
        </div>
    `;
    cartModalFooter.innerHTML = `
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
    `;
}

// Hàm thêm sản phẩm vào cart data (cập nhật trực tiếp)
function addItemToCartData(newItem) {
    // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
    const existingItemIndex = currentCartData.items.findIndex(item => item.product_id === newItem.product_id);
    
    if (existingItemIndex !== -1) {
        // Cập nhật số lượng
        currentCartData.items[existingItemIndex].quantity += newItem.quantity;
    } else {
        // Thêm sản phẩm mới
        currentCartData.items.push(newItem);
    }
    
    // Tính lại tổng tiền
    currentCartData.total_amount = currentCartData.items.reduce((total, item) => {
        return total + (item.price * item.quantity);
    }, 0);
    
    // Render lại modal nếu đang mở
    const cartModal = document.getElementById('cart-modal');
    if (cartModal && cartModal.classList.contains('show')) {
        renderCartModal();
    }
}

// Hàm xóa sản phẩm khỏi cart data (cập nhật trực tiếp)
function removeItemFromCartData(cartId) {
    currentCartData.items = currentCartData.items.filter(item => item.id != cartId);
    
    // Tính lại tổng tiền
    currentCartData.total_amount = currentCartData.items.reduce((total, item) => {
        return total + (item.price * item.quantity);
    }, 0);
    
    // Render lại modal
    if (currentCartData.items.length === 0) {
        renderEmptyCart();
    } else {
        renderCartModal();
    }
}

// Hàm cập nhật số lượng trong cart data
function updateItemQuantityInCartData(cartId, newQuantity) {
    const itemIndex = currentCartData.items.findIndex(item => item.id == cartId);
    
    if (itemIndex !== -1) {
        if (newQuantity <= 0) {
            // Xóa sản phẩm
            currentCartData.items.splice(itemIndex, 1);
        } else {
            // Cập nhật số lượng
            currentCartData.items[itemIndex].quantity = newQuantity;
        }
        
        // Tính lại tổng tiền
        currentCartData.total_amount = currentCartData.items.reduce((total, item) => {
            return total + (item.price * item.quantity);
        }, 0);
        
        // Render lại modal
        if (currentCartData.items.length === 0) {
            renderEmptyCart();
        } else {
            renderCartModal();
        }
    }
}

// Hàm format giá tiền
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price);
}

// Hàm gắn sự kiện cho các nút trong modal
function attachCartModalEvents() {
    // Xử lý nút xóa sản phẩm
    const removeButtons = document.querySelectorAll('.cart-remove-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                removeFromCartModal(cartId);
            }
        });
    });
    
    // Xử lý nút tăng số lượng
    const increaseButtons = document.querySelectorAll('.cart-quantity-increase');
    increaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            const maxQuantity = parseInt(this.getAttribute('data-max'));
            const currentQuantity = parseInt(document.getElementById(`quantity-${cartId}`).textContent);
            
            if (currentQuantity < maxQuantity) {
                updateCartQuantityModal(cartId, currentQuantity + 1);
            } else {
                alert('Số lượng sản phẩm trong kho không đủ.');
            }
        });
    });
    
    // Xử lý nút giảm số lượng
    const decreaseButtons = document.querySelectorAll('.cart-quantity-decrease');
    decreaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            const currentQuantity = parseInt(document.getElementById(`quantity-${cartId}`).textContent);
            
            if (currentQuantity > 1) {
                updateCartQuantityModal(cartId, currentQuantity - 1);
            } else {
                if (confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                    removeFromCartModal(cartId);
                }
            }
        });
    });
}

// Hàm xóa sản phẩm khỏi giỏ hàng trong modal
function removeFromCartModal(cartId) {
    fetch('index.php?page=remove_from_cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `cart_id=${cartId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật cart data ngay lập tức
            removeItemFromCartData(cartId);
            
            // Cập nhật số lượng giỏ hàng
            document.querySelectorAll('.cart-count').forEach(element => {
                element.textContent = data.cart_count || '0';
            });
        } else {
            alert(data.message || 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng.');
        }
    })
    .catch(error => {
        console.error('Error removing from cart:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
    });
}

// Hàm cập nhật số lượng sản phẩm trong modal
function updateCartQuantityModal(cartId, newQuantity) {
    fetch('index.php?page=update_cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `cart_id=${cartId}&quantity=${newQuantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật cart data ngay lập tức
            updateItemQuantityInCartData(cartId, newQuantity);
            
            // Cập nhật số lượng giỏ hàng
            document.querySelectorAll('.cart-count').forEach(element => {
                element.textContent = data.cart_count || '0';
            });
        } else {
            alert(data.message || 'Có lỗi xảy ra khi cập nhật giỏ hàng');
        }
    })
    .catch(error => {
        console.error('Error updating cart:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
    });
}

// Load giỏ hàng khi mở modal - chỉ khi chưa có dữ liệu
document.addEventListener('DOMContentLoaded', function() {
    const cartModal = document.getElementById('cart-modal');
    if (cartModal) {
        cartModal.addEventListener('show.bs.modal', function() {
            loadCartModal();
        });
    }
});

// Hàm public để cập nhật cart từ bên ngoài
window.updateCartModal = function(action, data) {
    switch(action) {
        case 'add':
            addItemToCartData(data);
            break;
        case 'remove':
            removeItemFromCartData(data.cartId);
            break;
        case 'update':
            updateItemQuantityInCartData(data.cartId, data.quantity);
            break;
        case 'clear':
            currentCartData = { items: [], total_amount: 0 };
            renderEmptyCart();
            break;
        case 'refresh':
            currentCartData = { items: [], total_amount: 0 };
            loadCartModal();
            break;
    }
};

// Hàm để thêm sản phẩm vào cart modal ngay lập tức (không cần fetch)
window.addProductToCartModal = function(productData) {
    const newItem = {
        id: productData.cart_id || Date.now(), // Temporary ID
        product_id: productData.product_id,
        name: productData.name,
        price: productData.price,
        old_price: productData.old_price,
        quantity: productData.quantity || 1,
        stock: productData.stock,
        image_url: productData.image_url
    };
    
    addItemToCartData(newItem);
};
</script>