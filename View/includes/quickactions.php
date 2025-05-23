<div class="quick-actions">
    <a href="index.php?page=wishlist" class="quick-action-btn wishlist">
        <i class="bi bi-heart"></i>
        <span class="tooltip">Danh sách yêu thích</span>
        <span class="wishlist-count badge bg-danger position-absolute top-0 end-0">
            <?php 
                if (isset($_SESSION['user_id'])) {
                    require_once 'Model/ProductModel.php';
                    $productModel = new ProductModel();
                    $wishlist = $productModel->getUserWishlist($_SESSION['user_id']);
                    echo count($wishlist);
                } else {
                    echo '0';
                }
            ?>
        </span>
    </a>
    <a href="index.php?page=cart" class="quick-action-btn">
        <i class="bi bi-bag"></i>
        <span class="tooltip">Giỏ hàng</span>
    </a>
    <button type="button" class="quick-action-btn" id="recentlyViewedBtn">
        <i class="bi bi-clock-history"></i>
        <span class="tooltip">Đã xem gần đây</span>
    </button>
</div>