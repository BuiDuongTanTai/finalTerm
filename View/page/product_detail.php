<?php
// Kiểm tra xem có sản phẩm được chọn không
if (!isset($product) || empty($product)) {
    echo '<div class="alert alert-warning">Không tìm thấy sản phẩm!</div>';
    exit;
}
?>

<div class="container py-5">
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6 mb-4">
            <div class="product-gallery">
                <!-- Main Image -->
                <div class="main-image mb-3">
                    <img src="<?php echo $product->image_url; ?>" class="img-fluid rounded" alt="<?php echo $product->name; ?>" id="main-product-image">
                </div>
                
                <!-- Thumbnail Images -->
                <?php if (!empty($product->gallery)): ?>
                <div class="thumbnail-images d-flex gap-2">
                    <img src="<?php echo $product->image; ?>" class="img-thumbnail" style="width: 80px; cursor: pointer;" onclick="changeMainImage(this.src)">
                    <?php foreach ($product->gallery as $image): ?>
                    <img src="<?php echo $image; ?>" class="img-thumbnail" style="width: 80px; cursor: pointer;" onclick="changeMainImage(this.src)">
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <h1 class="product-title mb-3"><?php echo $product->name; ?></h1>
            
            <!-- Price -->
            <div class="product-price mb-3">
                <?php if ($product->discount_price): ?>
                <span class="text-decoration-line-through text-muted me-2"><?php echo number_format($product->price); ?>đ</span>
                <span class="text-danger fw-bold fs-4"><?php echo number_format($product->discount_price); ?>đ</span>
                <?php else: ?>
                <span class="fw-bold fs-4"><?php echo number_format($product->price); ?>đ</span>
                <?php endif; ?>
            </div>

            <!-- Rating -->
            <div class="product-rating mb-3">
                <div class="stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="bi bi-star<?php echo $i <= $product->rating ? '-fill' : ''; ?> text-warning"></i>
                    <?php endfor; ?>
                    <span class="ms-2">(<?php echo $product->review_count; ?> đánh giá)</span>
                </div>
            </div>

            <!-- Description -->
            <div class="product-description mb-4">
                <p><?php echo $product->description; ?></p>
            </div>

            <!-- Color Selection -->
            <?php if (!empty($product->colors)): ?>
            <div class="color-selection mb-4">
                <h6 class="mb-2">Màu sắc:</h6>
                <div class="d-flex gap-2">
                    <?php foreach ($product->colors as $color): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="color" id="color-<?php echo $color->id; ?>" value="<?php echo $color->id; ?>">
                        <label class="form-check-label" for="color-<?php echo $color->id; ?>">
                            <?php echo $color->name; ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Size Selection -->
            <?php if (!empty($product->sizes)): ?>
            <div class="size-selection mb-4">
                <h6 class="mb-2">Kích thước:</h6>
                <div class="d-flex gap-2">
                    <?php foreach ($product->sizes as $size): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="size" id="size-<?php echo $size->id; ?>" value="<?php echo $size->id; ?>">
                        <label class="form-check-label" for="size-<?php echo $size->id; ?>">
                            <?php echo $size->name; ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Quantity -->
            <div class="quantity-selection mb-4">
                <h6 class="mb-2">Số lượng:</h6>
                <div class="input-group" style="width: 150px;">
                    <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                    <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="<?php echo $product->stock; ?>">
                    <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                </div>
            </div>

            <!-- Stock Status -->
            <div class="stock-status mb-4">
                <?php if ($product->stock > 0): ?>
                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Còn hàng</span>
                <?php else: ?>
                <span class="text-danger"><i class="bi bi-x-circle-fill"></i> Hết hàng</span>
                <?php endif; ?>
            </div>

            <!-- Product Actions -->
            <div class="product-actions mt-4">
                <?php if($product->stock > 0): ?>
                <div class="d-flex flex-wrap gap-3">
                    <form action="index.php?page=add_to_cart" method="post" class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                        <input type="hidden" name="quantity" id="form-quantity" value="1">
                        
                        <?php if(isset($selected_color)): ?>
                        <input type="hidden" name="color" value="<?php echo $selected_color; ?>">
                        <?php endif; ?>
                        
                        <?php if(isset($selected_variation)): ?>
                        <input type="hidden" name="variation" value="<?php echo $selected_variation; ?>">
                        <?php endif; ?>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng
                        </button>
                    </form>
                    
                    <button type="button" class="btn btn-success buy-now-btn" data-product-id="<?php echo $product->id; ?>">
                        <i class="bi bi-lightning-fill me-2"></i>Mua ngay
                    </button>
                </div>
                <?php else: ?>
                <button type="button" class="btn btn-secondary" disabled>
                    <i class="bi bi-x-circle me-2"></i>Hết hàng
                </button>
                <button type="button" class="btn btn-outline-primary notify-stock-btn">
                    <i class="bi bi-bell me-2"></i>Thông báo khi có hàng
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Mô tả</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">Thông số kỹ thuật</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Đánh giá</button>
                </li>
            </ul>
            <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <?php echo $product->full_description; ?>
                </div>
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    <table class="table">
                        <tbody>
                            <?php foreach ($product->specifications as $spec): ?>
                            <tr>
                                <th style="width: 200px;"><?php echo $spec->name; ?></th>
                                <td><?php echo $spec->value; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <!-- Reviews Section -->
                    <div class="reviews-section">
                        <?php if (!empty($product->reviews)): ?>
                            <?php foreach ($product->reviews as $review): ?>
                            <div class="review-item mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="<?php echo $review->user_avatar; ?>" class="rounded-circle me-2" width="40" height="40" alt="User Avatar">
                                    <div>
                                        <h6 class="mb-0"><?php echo $review->user_name; ?></h6>
                                        <div class="stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?php echo $i <= $review->rating ? '-fill' : ''; ?> text-warning"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <small class="text-muted ms-auto"><?php echo date('d/m/Y', strtotime($review->created_at)); ?></small>
                                </div>
                                <p class="mb-0"><?php echo $review->comment; ?></p>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Cập nhật số lượng trong form khi thay đổi input
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const formQuantityInput = document.getElementById('form-quantity');
    
    if (quantityInput && formQuantityInput) {
        quantityInput.addEventListener('change', function() {
            formQuantityInput.value = this.value;
        });
        
        // Cập nhật số lượng ban đầu
        formQuantityInput.value = quantityInput.value;
    }
    
    // Xử lý nút Mua ngay
    const buyNowBtn = document.querySelector('.buy-now-btn');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            // Kiểm tra đăng nhập
            if (!document.body.classList.contains('logged-in')) {
                // Hiển thị modal đăng nhập
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
                return;
            }
            
            const productId = this.getAttribute('data-product-id');
            const quantity = document.getElementById('quantity') ? document.getElementById('quantity').value : 1;
            
            // Tạo form động và submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?page=add_to_cart';
            
            const productIdInput = document.createElement('input');
            productIdInput.type = 'hidden';
            productIdInput.name = 'product_id';
            productIdInput.value = productId;
            form.appendChild(productIdInput);
            
            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity';
            quantityInput.value = quantity;
            form.appendChild(quantityInput);
            
            const buyNowInput = document.createElement('input');
            buyNowInput.type = 'hidden';
            buyNowInput.name = 'buy_now';
            buyNowInput.value = '1';
            form.appendChild(buyNowInput);
            
            // Nếu có tùy chọn màu sắc
            const selectedColor = document.querySelector('input[name="color"]:checked');
            if (selectedColor) {
                const colorInput = document.createElement('input');
                colorInput.type = 'hidden';
                colorInput.name = 'color';
                colorInput.value = selectedColor.value;
                form.appendChild(colorInput);
            }
            
            // Nếu có tùy chọn biến thể
            const selectedVariation = document.querySelector('input[name="variation"]:checked');
            if (selectedVariation) {
                const variationInput = document.createElement('input');
                variationInput.type = 'hidden';
                variationInput.name = 'variation';
                variationInput.value = selectedVariation.value;
                form.appendChild(variationInput);
            }
            
            document.body.appendChild(form);
            form.submit();
        });
    }
    
    // Kiểm tra đăng nhập và xử lý form add to cart
    const addToCartForm = document.querySelector('.add-to-cart-form');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            // Kiểm tra đăng nhập
            if (!document.body.classList.contains('logged-in')) {
                e.preventDefault();
                // Hiển thị modal đăng nhập
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
                return;
            }
            
            // Nếu đã đăng nhập, xử lý AJAX
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('index.php?page=add_to_cart', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hiển thị thông báo thành công
                    const button = this.querySelector('button[type="submit"]');
                    const originalText = button.innerHTML;
                    
                    button.innerHTML = '<i class="bi bi-check-circle me-2"></i> Đã thêm vào giỏ';
                    button.classList.add('btn-success');
                    
                    // Cập nhật số lượng giỏ hàng
                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.textContent = data.cart_count || '0';
                    });
                    
                    // Sau 2 giây, khôi phục nút ban đầu
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.classList.remove('btn-success');
                    }, 2000);
                } else {
                    if (data.message.includes('đăng nhập')) {
                        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                        loginModal.show();
                    } else {
                        alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại sau.');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
            });
        });
    }
});

// Hàm thay đổi ảnh chính
function changeMainImage(src) {
    document.getElementById('main-product-image').src = src;
}

// Hàm tăng số lượng
function increaseQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const currentValue = parseInt(input.value);
    if (currentValue < max) {
        input.value = currentValue + 1;
        document.getElementById('form-quantity').value = input.value;
    }
}

// Hàm giảm số lượng
function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
        document.getElementById('form-quantity').value = input.value;
    }
}
</script>