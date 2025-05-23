<main>
    <!-- Page Header -->
    <section class="page-header py-5 mb-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fw-bold mb-3">Thanh toán</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Checkout Section -->
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
            
            <form action="index.php?page=place_order" method="post" id="checkout-form">
                <div class="row">
                    <div class="col-lg-7">
                        <!-- Shipping Information -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title mb-0">Thông tin giao hàng</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">Họ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo !empty($user) ? array_shift(explode(' ', $user->name, 2)) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Tên <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo !empty($user) ? end(explode(' ', $user->name, 2)) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo !empty($user) ? $user->email : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo !empty($user) ? $user->phone : ''; ?>" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" name="address" value="<?php echo !empty($user) ? $user->address : ''; ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city" class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                        <select class="form-select" id="city" name="city" required>
                                            <option value="">Chọn tỉnh/thành phố</option>
                                            <option value="Hà Nội" <?php echo !empty($user) && $user->city == 'Hà Nội' ? 'selected' : ''; ?>>Hà Nội</option>
                                            <option value="TP.HCM" <?php echo !empty($user) && $user->city == 'TP.HCM' ? 'selected' : ''; ?>>TP.HCM</option>
                                            <option value="Đà Nẵng" <?php echo !empty($user) && $user->city == 'Đà Nẵng' ? 'selected' : ''; ?>>Đà Nẵng</option>
                                            <option value="Cần Thơ" <?php echo !empty($user) && $user->city == 'Cần Thơ' ? 'selected' : ''; ?>>Cần Thơ</option>
                                            <option value="Hải Phòng" <?php echo !empty($user) && $user->city == 'Hải Phòng' ? 'selected' : ''; ?>>Hải Phòng</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="district" class="form-label">Quận/Huyện <span class="text-danger">*</span></label>
                                        <select class="form-select" id="district" name="district" required>
                                            <option value="">Chọn quận/huyện</option>
                                            <option value="Quận 1" <?php echo !empty($user) && $user->district == 'Quận 1' ? 'selected' : ''; ?>>Quận 1</option>
                                            <option value="Quận 2" <?php echo !empty($user) && $user->district == 'Quận 2' ? 'selected' : ''; ?>>Quận 2</option>
                                            <option value="Quận 3" <?php echo !empty($user) && $user->district == 'Quận 3' ? 'selected' : ''; ?>>Quận 3</option>
                                            <option value="Quận 4" <?php echo !empty($user) && $user->district == 'Quận 4' ? 'selected' : ''; ?>>Quận 4</option>
                                            <option value="Quận 5" <?php echo !empty($user) && $user->district == 'Quận 5' ? 'selected' : ''; ?>>Quận 5</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="ward" class="form-label">Phường/Xã <span class="text-danger">*</span></label>
                                        <select class="form-select" id="ward" name="ward" required>
                                            <option value="">Chọn phường/xã</option>
                                            <option value="Phường 1" <?php echo !empty($user) && $user->ward == 'Phường 1' ? 'selected' : ''; ?>>Phường 1</option>
                                            <option value="Phường 2" <?php echo !empty($user) && $user->ward == 'Phường 2' ? 'selected' : ''; ?>>Phường 2</option>
                                            <option value="Phường 3" <?php echo !empty($user) && $user->ward == 'Phường 3' ? 'selected' : ''; ?>>Phường 3</option>
                                            <option value="Phường 4" <?php echo !empty($user) && $user->ward == 'Phường 4' ? 'selected' : ''; ?>>Phường 4</option>
                                            <option value="Phường 5" <?php echo !empty($user) && $user->ward == 'Phường 5' ? 'selected' : ''; ?>>Phường 5</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="notes" class="form-label">Ghi chú đơn hàng</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."></textarea>
                                    </div>
                                </div>
                                
                                <?php if(empty($_SESSION['user_id'])): ?>
                                <div class="mt-4 pt-3 border-top">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="createAccount" name="create_account" value="1">
                                        <label class="form-check-label" for="createAccount">
                                            Tạo tài khoản mới?
                                        </label>
                                    </div>
                                    
                                    <div id="account-fields" class="mt-3 d-none">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="password" class="form-label">Mật khẩu</label>
                                                <input type="password" class="form-control" id="password" name="password" minlength="6">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="confirmPassword" class="form-label">Xác nhận mật khẩu</label>
                                                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" minlength="6">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Shipping Method -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title mb-0">Phương thức vận chuyển</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="shipping-methods">
                                    <div class="form-check shipping-method mb-3">
                                        <input class="form-check-input" type="radio" name="shipping_method" id="shipping_standard" value="standard" checked>
                                        <label class="form-check-label" for="shipping_standard">
                                            <span class="shipping-method-name">Giao hàng tiêu chuẩn</span>
                                            <span class="shipping-method-price">
                                                <?php echo $total_amount >= 5000000 ? 'Miễn phí' : '50.000đ'; ?>
                                            </span>
                                            <small class="shipping-method-desc d-block text-muted">2-5 ngày làm việc</small>
                                        </label>
                                    </div>
                                    <div class="form-check shipping-method mb-3">
                                        <input class="form-check-input" type="radio" name="shipping_method" id="shipping_express" value="express">
                                        <label class="form-check-label" for="shipping_express">
                                            <span class="shipping-method-name">Giao hàng nhanh</span>
                                            <span class="shipping-method-price">50.000đ</span>
                                            <small class="shipping-method-desc d-block text-muted">1-2 ngày làm việc</small>
                                        </label>
                                    </div>
                                    <div class="form-check shipping-method">
                                        <input class="form-check-input" type="radio" name="shipping_method" id="shipping_same_day" value="same_day">
                                        <label class="form-check-label" for="shipping_same_day">
                                            <span class="shipping-method-name">Giao hàng trong ngày</span>
                                            <span class="shipping-method-price">100.000đ</span>
                                            <small class="shipping-method-desc d-block text-muted">Trong ngày (chỉ áp dụng cho nội thành)</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title mb-0">Phương thức thanh toán</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="payment-methods">
                                    <div class="form-check payment-method mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod" checked>
                                        <label class="form-check-label d-flex align-items-center" for="payment_cod">
                                            <span class="payment-icon me-3">
                                                <i class="bi bi-cash"></i>
                                            </span>
                                            <div>
                                                <span class="payment-method-name">Thanh toán khi nhận hàng (COD)</span>
                                                <small class="payment-method-desc d-block text-muted">Thanh toán bằng tiền mặt khi nhận hàng</small>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="form-check payment-method mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_bank" value="bank_transfer">
                                        <label class="form-check-label d-flex align-items-center" for="payment_bank">
                                            <span class="payment-icon me-3">
                                                <i class="bi bi-bank"></i>
                                            </span>
                                            <div>
                                                <span class="payment-method-name">Chuyển khoản ngân hàng</span>
                                                <small class="payment-method-desc d-block text-muted">Thực hiện thanh toán vào tài khoản ngân hàng của chúng tôi. Vui lòng sử dụng Mã đơn hàng của bạn trong phần Nội dung thanh toán.</small>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="form-check payment-method mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_credit_card" value="credit_card">
                                        <label class="form-check-label d-flex align-items-center" for="payment_credit_card">
                                            <span class="payment-icon me-3">
                                                <i class="bi bi-credit-card"></i>
                                            </span>
                                            <div>
                                                <span class="payment-method-name">Thẻ tín dụng/Ghi nợ</span>
                                                <small class="payment-method-desc d-block text-muted">Thanh toán an toàn bằng thẻ của bạn.</small>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="form-check payment-method mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_momo" value="momo">
                                        <label class="form-check-label d-flex align-items-center" for="payment_momo">
                                            <span class="payment-icon me-3">
                                                <i class="bi bi-wallet2"></i>
                                            </span>
                                            <div>
                                                <span class="payment-method-name">Ví MoMo</span>
                                                <small class="payment-method-desc d-block text-muted">Thanh toán qua ví điện tử MoMo</small>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="form-check payment-method">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_zalopay" value="zalopay">
                                        <label class="form-check-label d-flex align-items-center" for="payment_zalopay">
                                            <span class="payment-icon me-3">
                                                <i class="bi bi-wallet"></i>
                                            </span>
                                            <div>
                                                <span class="payment-method-name">ZaloPay</span>
                                                <small class="payment-method-desc d-block text-muted">Thanh toán qua ví điện tử ZaloPay</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Bank Transfer Details -->
                                <div id="bankTransferFields" class="mt-4 p-3 bg-light rounded d-none">
                                    <h6>Thông tin chuyển khoản:</h6>
                                    <p class="mb-1"><strong>Tên tài khoản:</strong> CAMERA VN</p>
                                    <p class="mb-1"><strong>Số tài khoản:</strong> 123456789</p>
                                    <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank - Chi nhánh TP.HCM</p>
                                    <p class="mb-0"><strong>Nội dung chuyển khoản:</strong> [Họ tên của bạn] thanh toán đơn hàng</p>
                                </div>
                                
                                <!-- Credit Card Fields -->
                                <div id="creditCardFields" class="mt-4 d-none">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="card_number" class="form-label">Số thẻ</label>
                                            <input type="text" class="form-control" id="card_number" placeholder="1234 5678 9012 3456">
                                        </div>
                                        <div class="col-6">
                                            <label for="card_expiry" class="form-label">Ngày hết hạn</label>
                                            <input type="text" class="form-control" id="card_expiry" placeholder="MM/YY">
                                        </div>
                                        <div class="col-6">
                                            <label for="card_cvv" class="form-label">CVV</label>
                                            <input type="text" class="form-control" id="card_cvv" placeholder="123">
                                        </div>
                                        <div class="col-12">
                                            <label for="card_name" class="form-label">Tên chủ thẻ</label>
                                            <input type="text" class="form-control" id="card_name" placeholder="NGUYEN VAN A">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-5">
                        <!-- Order Summary -->
                        <div class="card border-0 shadow-sm mb-4 sticky-lg-top" style="top: 20px;">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title mb-0">Thông tin đơn hàng</h5>
                            </div>
                            <div class="card-body">
                                <!-- Products in cart -->
                                <div class="checkout-product-list">
                                    <?php foreach($cart_items as $item): ?>
                                    <div class="checkout-product-item d-flex py-3 border-bottom">
                                        <div class="checkout-product-quantity">
                                            <?php echo $item->quantity; ?> ×
                                        </div>
                                        <div class="checkout-product-info flex-grow-1 ps-3">
                                            <div class="checkout-product-title">
                                                <?php echo $item->name; ?>
                                            </div>
                                            <?php if(!empty($item->options)): 
                                                $options = json_decode($item->options);
                                                if(is_object($options)):
                                                    foreach($options as $key => $value):
                                            ?>
                                            <div class="checkout-product-variant small text-muted">
                                                <?php echo ucfirst($key); ?>: <?php echo $value; ?>
                                            </div>
                                            <?php 
                                                    endforeach;
                                                endif;
                                            endif; 
                                            ?>
                                        </div>
                                        <div class="checkout-product-price">
                                            <?php echo number_format($item->price * $item->quantity, 0, ',', '.'); ?>đ
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <!-- Price details -->
                                <div class="checkout-price-details mt-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tạm tính</span>
                                        <span><?php echo number_format($total_amount, 0, ',', '.'); ?>đ</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Phí vận chuyển</span>
                                        <span id="shipping-fee">
<?php
                                            $shipping_fee = $total_amount >= 5000000 ? 0 : 50000;
                                            echo $shipping_fee > 0 ? number_format($shipping_fee, 0, ',', '.') . 'đ' : 'Miễn phí';
                                            ?>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Thuế (VAT 10%)</span>
                                        <span><?php echo number_format($tax_amount, 0, ',', '.'); ?>đ</span>
                                    </div>
                                    <?php if ($discount_amount > 0): ?>
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span>Giảm giá</span>
                                        <span>-<?php echo number_format($discount_amount, 0, ',', '.'); ?>đ</span>
                                    </div>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                                        <span class="fw-bold h5 mb-0">Tổng thanh toán</span>
                                        <span class="fw-bold h5 mb-0 text-primary" id="total-amount" data-base-total="<?php echo $total_amount; ?>">
                                            <?php echo number_format($final_amount, 0, ',', '.'); ?>đ
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="checkout-terms mt-4 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                        <label class="form-check-label" for="agreeTerms">
                                            Tôi đã đọc và đồng ý với <a href="index.php?page=termsofuse" target="_blank">điều khoản & điều kiện</a> của website
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        Đặt hàng
                                    </button>
                                    <a href="index.php?page=cart" class="btn btn-outline-primary">
                                        <i class="bi bi-arrow-left me-2"></i>Quay lại giỏ hàng
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<style>
.shipping-method,
.payment-method {
    padding: 15px;
    border: 1px solid #dee2e6;
    border-radius: var(--border-radius);
    margin-bottom: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.shipping-method:last-child,
.payment-method:last-child {
    margin-bottom: 0;
}

.shipping-method:hover,
.payment-method:hover {
    background-color: rgba(13, 110, 253, 0.05);
}

.shipping-method .form-check-input,
.payment-method .form-check-input {
    float: none;
    margin-right: 10px;
}

.shipping-method .form-check-label,
.payment-method .form-check-label {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    width: 100%;
    cursor: pointer;
}

.shipping-method-price {
    font-weight: bold;
    color: var(--primary-color);
}

.payment-icon {
    width: 40px;
    height: 40px;
    background-color: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: var(--primary-color);
}

.checkout-product-item {
    align-items: center;
}

.checkout-product-quantity {
    color: var(--primary-color);
    font-weight: bold;
    min-width: 40px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide additional fields based on payment method selection
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const bankTransferFields = document.getElementById('bankTransferFields');
    const creditCardFields = document.getElementById('creditCardFields');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'bank_transfer') {
                bankTransferFields.classList.remove('d-none');
                creditCardFields.classList.add('d-none');
            } else if (this.value === 'credit_card') {
                creditCardFields.classList.remove('d-none');
                bankTransferFields.classList.add('d-none');
            } else {
                bankTransferFields.classList.add('d-none');
                creditCardFields.classList.add('d-none');
            }
        });
    });
    
    // Show/hide account fields if creating an account
    const createAccountCheckbox = document.getElementById('createAccount');
    const accountFields = document.getElementById('account-fields');
    
    if (createAccountCheckbox && accountFields) {
        createAccountCheckbox.addEventListener('change', function() {
            if (this.checked) {
                accountFields.classList.remove('d-none');
                document.getElementById('password').setAttribute('required', 'required');
                document.getElementById('confirmPassword').setAttribute('required', 'required');
            } else {
                accountFields.classList.add('d-none');
                document.getElementById('password').removeAttribute('required');
                document.getElementById('confirmPassword').removeAttribute('required');
            }
        });
    }
    
    // Update shipping fee and total amount based on shipping method
    const shippingMethods = document.querySelectorAll('input[name="shipping_method"]');
    const shippingFeeElement = document.getElementById('shipping-fee');
    const totalAmountElement = document.getElementById('total-amount');
    
    if (shippingMethods.length > 0 && shippingFeeElement && totalAmountElement) {
        const baseTotal = parseInt(totalAmountElement.getAttribute('data-base-total') || 0);
        const taxAmount = <?php echo $tax_amount; ?>;
        const discountAmount = <?php echo $discount_amount; ?>;
        
        shippingMethods.forEach(method => {
            method.addEventListener('change', function() {
                let shippingFee = 0;
                
                if (this.value === 'express') {
                    shippingFee = 50000;
                    shippingFeeElement.textContent = '50.000đ';
                } else if (this.value === 'same_day') {
                    shippingFee = 100000;
                    shippingFeeElement.textContent = '100.000đ';
                } else { // standard
                    shippingFee = baseTotal >= 5000000 ? 0 : 50000;
                    shippingFeeElement.textContent = shippingFee === 0 ? 'Miễn phí' : '50.000đ';
                }
                
                const newTotal = baseTotal + shippingFee + taxAmount - discountAmount;
                totalAmountElement.textContent = new Intl.NumberFormat('vi-VN').format(newTotal) + 'đ';
                totalAmountElement.setAttribute('data-total', newTotal);
            });
        });
    }
    
    // Form validation
    const checkoutForm = document.getElementById('checkout-form');
    
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            // Check if terms are agreed
            const agreeTerms = document.getElementById('agreeTerms');
            if (agreeTerms && !agreeTerms.checked) {
                e.preventDefault();
                alert('Vui lòng đồng ý với điều khoản và điều kiện để tiếp tục.');
                return;
            }
            
            // Check if create account is checked but passwords don't match
            const createAccount = document.getElementById('createAccount');
            if (createAccount && createAccount.checked) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Mật khẩu và xác nhận mật khẩu không khớp.');
                    return;
                }
            }
            
            // Additional validation for credit card if selected
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            if (paymentMethod === 'credit_card') {
                const cardNumber = document.getElementById('card_number').value;
                const cardExpiry = document.getElementById('card_expiry').value;
                const cardCvv = document.getElementById('card_cvv').value;
                const cardName = document.getElementById('card_name').value;
                
                if (!cardNumber || !cardExpiry || !cardCvv || !cardName) {
                    e.preventDefault();
                    alert('Vui lòng điền đầy đủ thông tin thẻ tín dụng.');
                    return;
                }
            }
        });
    }
});
</script>