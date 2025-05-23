<!-- Cart Modal -->
<div class="modal fade" id="cart-modal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Giỏ hàng của bạn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                $cart_items = [];
                $total = 0;
                
                if (isset($_SESSION['user_id'])) {
                    require_once 'Model/CartModel.php';
                    $cartModel = new CartModel();
                    $cart_items = $cartModel->getCart($_SESSION['user_id']);
                    $total = $cartModel->calculateCartTotal($_SESSION['user_id']);
                } elseif (isset($_SESSION['cart_id'])) {
                    require_once 'Model/CartModel.php';
                    $cartModel = new CartModel();
                    $cart_items = $cartModel->getCart(null, $_SESSION['cart_id']);
                    $total = $cartModel->calculateCartTotal(null, $_SESSION['cart_id']);
                }
                ?>
                
                <?php if (empty($cart_items)): ?>
                <div class="text-center py-4">
                    <i class="bi bi-cart-x" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="mt-3">Giỏ hàng của bạn đang trống</p>
                    <a href="index.php?page=all_products" class="btn btn-primary mt-2">Tiếp tục mua sắm</a>
                </div>
                <?php else: ?>
                <div class="cart-items">
                    <?php foreach ($cart_items as $item): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-3">
                                    <div class="cart-thumbnail" style="background-image: url('<?php echo $item->image_url; ?>');"></div>
                                </div>
                                <div class="col-9">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title"><?php echo $item->name; ?></h6>
                                        <button type="button" class="cart-remove-btn" data-cart-id="<?php echo $item->id; ?>">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-0 text-primary fw-bold">
                                                <?php echo number_format($item->price, 0, ',', '.'); ?>đ
                                                <?php if ($item->old_price && $item->old_price > $item->price): ?>
                                                <span class="text-muted text-decoration-line-through ms-2 small">
                                                    <?php echo number_format($item->old_price, 0, ',', '.'); ?>đ
                                                </span>
                                                <?php endif; ?>
                                            </p>
                                            <div class="mt-2">
                                                <span>Số lượng:</span>
                                                <span class="ms-2 fw-bold"><?php echo $item->quantity; ?></span>
                                            </div>
                                        </div>
                                        <p class="mb-0 fw-bold text-primary">
                                            <?php echo number_format($item->price * $item->quantity, 0, ',', '.'); ?>đ
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Tạm tính:</span>
                        <span class="fw-bold"><?php echo number_format($total, 0, ',', '.'); ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Phí vận chuyển:</span>
                        <span class="fw-bold">
                            <?php
                            $shipping = $total >= 5000000 ? 0 : 50000;
                            echo $shipping > 0 ? number_format($shipping, 0, ',', '.') . 'đ' : 'Miễn phí';
                            ?>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Tổng cộng:</span>
                        <span class="h5 mb-0 text-primary fw-bold">
                            <?php echo number_format($total + $shipping, 0, ',', '.'); ?>đ
                        </span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <?php if (!empty($cart_items)): ?>
                <a href="index.php?page=cart" class="btn btn-outline-primary">Xem giỏ hàng</a>
                <a href="index.php?page=checkout" class="btn btn-primary">Thanh toán</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý xóa sản phẩm khỏi giỏ hàng
    const removeButtons = document.querySelectorAll('.cart-remove-btn');
    
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
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
                        // Reload giỏ hàng
                        window.location.reload();
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
    });
});
</script>