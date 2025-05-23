<!-- Product Actions Section -->
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
</script>