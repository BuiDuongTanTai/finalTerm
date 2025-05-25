<main>
    <!-- Page Header -->
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="fw-bold mb-3">Giỏ hàng</h1>
            </div>
        </div>
    </div>
    <!-- Cart Section -->
    <section class="py-5">
        <div class="container">
            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <?php if(empty($cart_items)): ?>
            <!-- Empty Cart -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-cart-x" style="font-size: 5rem; color: #ccc;"></i>
                </div>
                <h3>Giỏ hàng của bạn đang trống</h3>
                <p class="text-muted mb-4">Có vẻ như bạn chưa thêm bất kỳ sản phẩm nào vào giỏ hàng.</p>
                <a href="index.php?page=all_products" class="btn btn-primary">
                    <i class="bi bi-shop me-2"></i>Tiếp tục mua sắm
                </a>
            </div>
            <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <!-- Cart Items -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Giỏ hàng của bạn (<?php echo count($cart_items); ?> sản phẩm)</h5>
                                <button type="button" class="btn btn-outline-danger btn-sm" id="clearCart">
                                    <i class="bi bi-trash"></i> Xóa tất cả
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <?php foreach($cart_items as $item): ?>
                            <div class="cart-item p-3 border-bottom" id="cart-item-<?php echo $item->id; ?>" data-price="<?php echo $item->price; ?>">
                                <div class="row align-items-center">
                                    <div class="col-md-2 mb-3 mb-md-0">
                                        <div class="cart-thumbnail" style="background-image: url('<?php echo $item->image_url; ?>');"></div>
                                    </div>
                                    <div class="col-md-5 mb-3 mb-md-0">
                                        <h6 class="cart-product-title mb-1">
                                            <a href="index.php?page=product_detail&id=<?php echo $item->product_id; ?>" class="text-decoration-none"><?php echo $item->name; ?></a>
                                        </h6>
                                        <?php if(!empty($item->options)): 
                                            $options = json_decode($item->options);
                                            if(is_object($options)):
                                                foreach($options as $key => $value):
                                        ?>
                                        <small class="text-muted d-block"><?php echo ucfirst($key); ?>: <?php echo $value; ?></small>
                                        <?php 
                                                endforeach;
                                            endif;
                                        endif; 
                                        ?>
                                        <div class="mt-2">
                                            <span class="text-primary fw-bold">
                                                <?php echo number_format($item->price, 0, ',', '.'); ?>đ
                                                <?php if(!empty($item->old_price) && $item->old_price > $item->price): 
                                                    $discount_percent = round(100 - ($item->price / $item->old_price * 100));
                                                ?>
                                                <span class="text-muted text-decoration-line-through ms-2 small">
                                                    <?php echo number_format($item->old_price, 0, ',', '.'); ?>đ
                                                </span>
                                                <span class="badge bg-danger ms-2">-<?php echo $discount_percent; ?>%</span>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-8 mb-3 mb-md-0">
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-outline-secondary btn-sm cart-quantity-decrease" data-cart-id="<?php echo $item->id; ?>">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <span class="mx-2 fw-bold" id="quantity-<?php echo $item->id; ?>"><?php echo $item->quantity; ?></span>
                                            <button type="button" class="btn btn-outline-secondary btn-sm cart-quantity-increase" data-cart-id="<?php echo $item->id; ?>" data-max="<?php echo $item->stock; ?>">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-4 text-end">
                                        <div class="fw-bold text-primary mb-2" id="subtotal-<?php echo $item->id; ?>">
                                            <?php echo number_format($item->price * $item->quantity, 0, ',', '.'); ?>đ
                                        </div>
                                        <button type="button" class="btn btn-outline-danger btn-sm cart-remove-btn" data-cart-id="<?php echo $item->id; ?>">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Continue Shopping -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="index.php?page=all_products" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Cart Summary -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Tổng tiền giỏ hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tạm tính:</span>
                                    <span id="cart-subtotal"><?php echo number_format($total_amount, 0, ',', '.'); ?>đ</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Phí vận chuyển:</span>
                                    <span id="cart-shipping">
                                        <?php
                                        $shipping_fee = $total_amount >= 5000000 ? 0 : 50000;
                                        echo $shipping_fee > 0 ? number_format($shipping_fee, 0, ',', '.') . 'đ' : 'Miễn phí';
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center h5 mb-0">
                                <span>Tổng cộng:</span>
                                <span class="text-primary" id="cart-total"><?php echo number_format($total_amount + $shipping_fee, 0, ',', '.'); ?>đ</span>
                            </div>
                            
                            <div class="d-grid mt-4 gap-2">
                                <a href="index.php?page=checkout" class="btn btn-primary">
                                    Tiến hành thanh toán <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Shipping Policy -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Chính sách giao hàng</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Miễn phí giao hàng cho đơn hàng từ 5 triệu đồng</span>
                                </li>
                                <li class="d-flex mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Giao hàng dự kiến trong 2-5 ngày làm việc</span>
                                </li>
                                <li class="d-flex mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Đổi trả miễn phí trong 30 ngày</span>
                                </li>
                                <li class="d-flex">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Bảo hành chính hãng lên đến 24 tháng</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
// Hàm format giá tiền
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price);
}

// Hàm cập nhật tổng tiền
function updateCartTotals(data) {
    const shipping = data.total_amount >= 5000000 ? 0 : 50000;
    
    document.getElementById('cart-subtotal').textContent = formatPrice(data.total_amount) + 'đ';
    document.getElementById('cart-shipping').textContent = shipping > 0 ? formatPrice(shipping) + 'đ' : 'Miễn phí';
    document.getElementById('cart-total').textContent = formatPrice(data.total_amount + shipping) + 'đ';
    
    // Cập nhật số lượng giỏ hàng
    document.querySelectorAll('.cart-count').forEach(element => {
        element.textContent = data.cart_count || '0';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Xử lý nút tăng số lượng
    document.querySelectorAll('.cart-quantity-increase').forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            const maxQuantity = parseInt(this.getAttribute('data-max'));
            const quantityElement = document.getElementById(`quantity-${cartId}`);
            const currentQuantity = parseInt(quantityElement.textContent);
            
            if (currentQuantity < maxQuantity) {
                updateCartQuantity(cartId, currentQuantity + 1);
            } else {
                alert('Số lượng sản phẩm trong kho không đủ.');
            }
        });
    });
    
    // Xử lý nút giảm số lượng
    document.querySelectorAll('.cart-quantity-decrease').forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            const quantityElement = document.getElementById(`quantity-${cartId}`);
            const currentQuantity = parseInt(quantityElement.textContent);
            
            if (currentQuantity > 1) {
                updateCartQuantity(cartId, currentQuantity - 1);
            } else {
                if (confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                    removeCartItem(cartId);
                }
            }
        });
    });
    
    // Xử lý nút xóa sản phẩm
    document.querySelectorAll('.cart-remove-btn').forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                removeCartItem(cartId);
            }
        });
    });
    
    // Xử lý nút xóa tất cả
    const clearCartButton = document.getElementById('clearCart');
    if (clearCartButton) {
        clearCartButton.addEventListener('click', function() {
            if (confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm khỏi giỏ hàng?')) {
                clearCart();
            }
        });
    }
});

// Hàm cập nhật số lượng sản phẩm
function updateCartQuantity(cartId, newQuantity) {
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
            // Cập nhật số lượng hiển thị
            document.getElementById(`quantity-${cartId}`).textContent = newQuantity;
            
            // Cập nhật tổng tiền của sản phẩm
            const cartItem = document.getElementById(`cart-item-${cartId}`);
            const price = parseInt(cartItem.getAttribute('data-price'));
            const subtotal = price * newQuantity;
            document.getElementById(`subtotal-${cartId}`).textContent = formatPrice(subtotal) + 'đ';
            
            // Tính tổng tiền giỏ hàng
            let total = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const itemId = item.id.replace('cart-item-', '');
                const itemQuantity = parseInt(document.getElementById(`quantity-${itemId}`).textContent);
                const itemPrice = parseInt(item.getAttribute('data-price'));
                total += itemPrice * itemQuantity;
            });
            
            // Cập nhật tổng tiền giỏ hàng
            updateCartTotals({
                total_amount: total,
                cart_count: data.cart_count
            });
            
            // Cập nhật cart modal nếu có
            if (window.updateCartModal) {
                window.updateCartModal('update', { cartId, quantity: newQuantity });
            }
        } else {
            alert(data.message || 'Có lỗi xảy ra khi cập nhật giỏ hàng.');
        }
    })
    .catch(error => {
        console.error('Error updating cart:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
    });
}

// Hàm xóa sản phẩm khỏi giỏ hàng
function removeCartItem(cartId) {
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
            // Xóa phần tử khỏi UI
            const cartItem = document.getElementById(`cart-item-${cartId}`);
            if (cartItem) {
                cartItem.remove();
            }
            
            // Tính tổng tiền giỏ hàng
            let total = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const itemId = item.id.replace('cart-item-', '');
                const itemQuantity = parseInt(document.getElementById(`quantity-${itemId}`).textContent);
                const itemPrice = parseInt(item.getAttribute('data-price'));
                total += itemPrice * itemQuantity;
            });
            
            // Cập nhật tổng tiền giỏ hàng
            updateCartTotals({
                total_amount: total,
                cart_count: data.cart_count
            });
            
            // Cập nhật cart modal nếu có
            if (window.updateCartModal) {
                window.updateCartModal('remove', { cartId });
            }
            
            // Kiểm tra nếu không còn sản phẩm nào trong giỏ hàng
            if (data.cart_count === 0) {
                window.location.reload();
            }
        } else {
            alert(data.message || 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng.');
        }
    })
    .catch(error => {
        console.error('Error removing from cart:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
    });
}

// Hàm xóa tất cả sản phẩm khỏi giỏ hàng
function clearCart() {
    fetch('index.php?page=clear_cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật cart modal nếu có
            if (window.updateCartModal) {
                window.updateCartModal('clear');
            }
            
            window.location.reload();
        } else {
            alert(data.message || 'Có lỗi xảy ra khi xóa tất cả sản phẩm.');
        }
    })
    .catch(error => {
        console.error('Error clearing cart:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
    });
}
</script>