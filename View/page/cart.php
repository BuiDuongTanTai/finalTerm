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
                            <div class="cart-item p-3 border-bottom" id="cart-item-<?php echo $item->id; ?>">
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
                                            <input type="number" class="form-control form-control-sm mx-2 cart-quantity-input" value="<?php echo $item->quantity; ?>" min="1" max="<?php echo $item->stock; ?>" data-cart-id="<?php echo $item->id; ?>">
                                            <button type="button" class="btn btn-outline-secondary btn-sm cart-quantity-increase" data-cart-id="<?php echo $item->id; ?>">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-4 text-end">
                                        <div class="fw-bold text-primary mb-2">
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
                        <button type="button" class="btn btn-outline-success cart-update-all">
                            <i class="bi bi-arrow-repeat me-2"></i>Cập nhật giỏ hàng
                        </button>
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
                                    <span><?php echo number_format($total_amount, 0, ',', '.'); ?>đ</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Phí vận chuyển:</span>
                                    <span>
                                        <?php
                                        $shipping_fee = $total_amount >= 5000000 ? 0 : 50000;
                                        echo $shipping_fee > 0 ? number_format($shipping_fee, 0, ',', '.') . 'đ' : 'Miễn phí';
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center h5 mb-0">
                                <span>Tổng cộng:</span>
                                <span class="text-primary"><?php echo number_format($total_amount + $shipping_fee, 0, ',', '.'); ?>đ</span>
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
                    
                    <!-- Recommended Products -->
                    <?php if (!empty($recommended_products)): ?>
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Có thể bạn cũng thích</h5>
                        </div>
                        <div class="card-body pt-2">
                            <?php foreach($recommended_products as $product): ?>
                            <div class="recommended-product-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="recommended-product-image" style="width: 60px; height: 60px; background-image: url('<?php echo $product->image_url; ?>'); background-size: contain; background-position: center; background-repeat: no-repeat;"></div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">
                                            <a href="index.php?page=product_detail&id=<?php echo $product->id; ?>" class="text-decoration-none"><?php echo $product->name; ?></a>
                                        </h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-primary fw-bold"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span>
                                            <button type="button" class="btn btn-sm btn-outline-primary product-add-to-cart-btn" data-product-id="<?php echo $product->id; ?>">
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý tăng số lượng
    const increaseButtons = document.querySelectorAll('.cart-quantity-increase');
    increaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            const inputElement = document.querySelector(`.cart-quantity-input[data-cart-id="${cartId}"]`);
            const totalValue = document.querySelector('.cart-total-value');
            let currentValue = parseInt(inputElement.value);
            const maxValue = parseInt(inputElement.getAttribute('max') || 99);
            
            if (currentValue < maxValue) {
                currentValue++;
                inputElement.value = currentValue;
                updateCartItemDirect(cartId, currentValue);
            } else {
                alert('Số lượng sản phẩm trong kho không đủ.');
            }
        });
    });
    
    // Xử lý giảm số lượng
    const decreaseButtons = document.querySelectorAll('.cart-quantity-decrease');
    decreaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            const inputElement = document.querySelector(`.cart-quantity-input[data-cart-id="${cartId}"]`);
            let currentValue = parseInt(inputElement.value);
            
            if (currentValue > 1) {
                currentValue--;
                inputElement.value = currentValue;
                updateCartItemDirect(cartId, currentValue);
            } else {
                if (confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                    removeCartItem(cartId);
                }
            }
        });
    });
    
    // Xử lý thay đổi số lượng trực tiếp từ input
    const quantityInputs = document.querySelectorAll('.cart-quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const cartId = this.getAttribute('data-cart-id');
            const currentValue = parseInt(this.value);
            const maxValue = parseInt(this.getAttribute('max') || 99);
            
            if (isNaN(currentValue) || currentValue < 1) {
                this.value = 1;
                updateCartItemDirect(cartId, 1);
            } else if (currentValue > maxValue) {
                this.value = maxValue;
                alert('Số lượng sản phẩm trong kho không đủ.');
                updateCartItemDirect(cartId, maxValue);
            } else {
                updateCartItemDirect(cartId, currentValue);
            }
        });
    });
    
    // Xử lý nút xóa sản phẩm
    const removeButtons = document.querySelectorAll('.cart-remove-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                removeCartItem(cartId);
            }
        });
    });
    
    // Xử lý nút cập nhật tất cả
    const updateAllButton = document.querySelector('.cart-update-all');
    if (updateAllButton) {
        updateAllButton.addEventListener('click', function() {
            const quantityInputs = document.querySelectorAll('.cart-quantity-input');
            const updates = [];
            
            quantityInputs.forEach(input => {
                const cartId = input.getAttribute('data-cart-id');
                const quantity = parseInt(input.value);
                updates.push({ cartId, quantity });
            });
            
            // Cập nhật tất cả sản phẩm
            if (updates.length > 0) {
                const loadingButton = this.innerHTML;
                this.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Đang cập nhật...';
                this.disabled = true;
                
                let completedUpdates = 0;
                
                updates.forEach(update => {
                    updateCartItemDirect(update.cartId, update.quantity, function() {
                        completedUpdates++;
                        if (completedUpdates === updates.length) {
                            updateAllButton.innerHTML = loadingButton;
                            updateAllButton.disabled = false;
                            alert('Đã cập nhật tất cả sản phẩm trong giỏ hàng!');
                        }
                    });
                });
            }
        });
    }
    
    // Xử lý nút xóa tất cả
    const clearCartButton = document.getElementById('clearCart');
    if (clearCartButton) {
        clearCartButton.addEventListener('click', function() {
            if (confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm khỏi giỏ hàng?')) {
                // Gửi request
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
        });
    }
    
    // Xử lý thêm vào giỏ hàng từ sản phẩm gợi ý
    const addToCartButtons = document.querySelectorAll('.product-add-to-cart-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            
            // If not logged in, show login modal
            if (!document.body.classList.contains('logged-in')) {
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
                return;
            }
            
            // Gửi request thêm vào giỏ hàng
            fetch('index.php?page=add_to_cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `product_id=${productId}&quantity=1`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật UI
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-check"></i>';
                    this.classList.add('btn-success');
                    
                    // Cập nhật số lượng giỏ hàng
                    document.querySelectorAll('.cart-count').forEach(element => {
                        element.textContent = data.cart_count || '0';
                    });
                    
                    // Khôi phục nút sau 1.5 giây
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('btn-success');
                        
                        // Reload trang để hiển thị sản phẩm mới được thêm vào
                        window.location.reload();
                    }, 1500);
                } else {
                    alert(data.message || 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
            });
        });
    });
    
    // Hàm cập nhật số lượng sản phẩm
    function updateCartItem(cartId, quantityChange) {
        fetch('index.php?page=update_cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `cart_id=${cartId}&quantity=${quantityChange}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật tổng tiền
                document.querySelector('.text-primary').textContent = data.total_amount;
                
                // Cập nhật số lượng giỏ hàng
                document.querySelectorAll('.cart-count').forEach(element => {
                    element.textContent = data.cart_count || '0';
                });
            } else {
                alert(data.message || 'Có lỗi xảy ra khi cập nhật giỏ hàng.');
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
        });
    }
    
    // Hàm cập nhật trực tiếp số lượng sản phẩm
    function updateCartItemDirect(cartId, quantity, callback) {
        fetch('index.php?page=update_cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `cart_id=${cartId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật tổng tiền
                document.querySelector('.text-primary').textContent = data.total_amount;
                
                // Cập nhật số lượng giỏ hàng
                document.querySelectorAll('.cart-count').forEach(element => {
                    element.textContent = data.cart_count || '0';
                });
                
                if (typeof callback === 'function') {
                    callback();
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
                
                // Cập nhật tổng tiền
                document.querySelector('.text-primary').textContent = data.total_amount;
                
                // Cập nhật số lượng giỏ hàng
                document.querySelectorAll('.cart-count').forEach(element => {
                    element.textContent = data.cart_count || '0';
                });
                
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
});
</script>