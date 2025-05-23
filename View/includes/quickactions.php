<!-- Quick Actions -->
<div class="quick-actions">
    <div class="quick-action-btn" data-bs-toggle="tooltip" data-bs-placement="left" title="Giỏ hàng" data-bs-toggle="modal" data-bs-target="#cart-modal">
        <i class="bi bi-cart3"></i>
        <span class="quick-action-badge cart-count">
            <?php 
                if (isset($_SESSION['user_id'])) {
                    require_once 'Model/CartModel.php';
                    $cartModel = new CartModel();
                    echo $cartModel->countCartItems($_SESSION['user_id']);
                } elseif (isset($_SESSION['cart_id'])) {
                    require_once 'Model/CartModel.php';
                    $cartModel = new CartModel();
                    echo $cartModel->countCartItems(null, $_SESSION['cart_id']);
                } else {
                    echo 0;
                }
            ?>
        </span>
    </div>
    <div class="quick-action-btn" data-bs-toggle="tooltip" data-bs-placement="left" title="Liên hệ tư vấn">
        <a href="tel:0708624193"><i class="bi bi-telephone"></i></a>
    </div>
    <div class="quick-action-btn" data-bs-toggle="tooltip" data-bs-placement="left" title="Zalo">
        <a href="https://zalo.me" target="_blank"><i class="bi bi-chat-dots"></i></a>
    </div>
    <div class="quick-action-btn" data-bs-toggle="tooltip" data-bs-placement="left" title="Facebook Messenger">
        <a href="https://m.me" target="_blank"><i class="bi bi-messenger"></i></a>
    </div>
</div>

<style>
.quick-actions {
    position: fixed;
    right: 20px;
    bottom: 100px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.quick-action-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.quick-action-btn i {
    font-size: 1.5rem;
}

.quick-action-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.3);
}

.quick-action-btn a {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.quick-action-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: var(--danger-color);
    color: white;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}

.quick-action-btn:nth-child(2) {
    background-color: #198754;
}

.quick-action-btn:nth-child(3) {
    background-color: #0068ff;
}

.quick-action-btn:nth-child(4) {
    background-color: #0A7CFF;
}
</style>