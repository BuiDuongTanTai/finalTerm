<?php
if (!isset($order) || empty($order)) {
    header('Location: index.php');
    exit;
}
?>

<main>
    <!-- Page Header -->
    <section class="page-header py-5 mb-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fw-bold mb-3">Đặt hàng thành công</h1>
                    <p class="lead text-muted">Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xác nhận.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Order Success Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Success Message -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4 text-center">
                            <div class="success-icon mb-4">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="mb-3">Đặt hàng thành công!</h3>
                            <p class="text-muted mb-4">Mã đơn hàng của bạn là: <strong class="text-primary">#<?php echo $order->id; ?></strong></p>
                            <p class="mb-4">Chúng tôi đã gửi email xác nhận đến địa chỉ: <strong><?php echo $order->email; ?></strong></p>
                            
                            <?php if ($order->payment_method == 'bank_transfer'): ?>
                            <div class="alert alert-info mb-4">
                                <h6 class="alert-heading mb-2">Thông tin chuyển khoản:</h6>
                                <p class="mb-1"><strong>Tên tài khoản:</strong> CAMERA VN</p>
                                <p class="mb-1"><strong>Số tài khoản:</strong> 123456789</p>
                                <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank</p>
                                <p class="mb-1"><strong>Số tiền:</strong> <?php echo number_format($order->total); ?>đ</p>
                                <p class="mb-0"><strong>Nội dung chuyển khoản:</strong> <?php echo $order->id; ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-center gap-3">
                                <a href="index.php?page=order_detail&id=<?php echo $order->id; ?>" class="btn btn-primary">
                                    <i class="bi bi-eye me-2"></i>Xem chi tiết đơn hàng
                                </a>
                                <a href="index.php" class="btn btn-outline-primary">
                                    <i class="bi bi-house me-2"></i>Tiếp tục mua sắm
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Thông tin đơn hàng</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="mb-3">Thông tin giao hàng</h6>
                                    <p class="mb-1"><strong>Người nhận:</strong> <?php echo $order->name; ?></p>
                                    <p class="mb-1"><strong>Địa chỉ:</strong> <?php echo $order->address; ?></p>
                                    <p class="mb-1"><strong>Quận/Huyện:</strong> <?php echo $order->district; ?></p>
                                    <p class="mb-1"><strong>Phường/Xã:</strong> <?php echo $order->ward; ?></p>
                                    <p class="mb-1"><strong>Tỉnh/Thành phố:</strong> <?php echo $order->city; ?></p>
                                    <p class="mb-1"><strong>Số điện thoại:</strong> <?php echo $order->phone; ?></p>
                                    <?php if ($order->notes): ?>
                                    <p class="mb-0"><strong>Ghi chú:</strong> <?php echo $order->notes; ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-3">Thông tin thanh toán</h6>
                                    <p class="mb-1"><strong>Phương thức thanh toán:</strong> 
                                        <?php
                                        switch($order->payment_method) {
                                            case 'cod':
                                                echo 'Thanh toán khi nhận hàng (COD)';
                                                break;
                                            case 'bank_transfer':
                                                echo 'Chuyển khoản ngân hàng';
                                                break;
                                            case 'credit_card':
                                                echo 'Thẻ tín dụng/Ghi nợ';
                                                break;
                                            case 'momo':
                                                echo 'Ví MoMo';
                                                break;
                                            case 'zalopay':
                                                echo 'ZaloPay';
                                                break;
                                        }
                                        ?>
                                    </p>
                                    <p class="mb-1"><strong>Phương thức vận chuyển:</strong> 
                                        <?php
                                        switch($order->shipping_method) {
                                            case 'standard':
                                                echo 'Giao hàng tiêu chuẩn';
                                                break;
                                            case 'express':
                                                echo 'Giao hàng nhanh';
                                                break;
                                            case 'same_day':
                                                echo 'Giao hàng trong ngày';
                                                break;
                                        }
                                        ?>
                                    </p>
                                    <p class="mb-1"><strong>Ngày đặt hàng:</strong> <?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?></p>
                                    <p class="mb-1"><strong>Trạng thái đơn hàng:</strong> 
                                        <span class="badge bg-primary"><?php echo $order->status; ?></span>
                                    </p>
                                </div>
                            </div>

                            <h6 class="mb-3">Chi tiết đơn hàng</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-end">Đơn giá</th>
                                            <th class="text-end">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($order_items as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo $item->image_url; ?>" alt="<?php echo $item->name; ?>" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-0"><?php echo $item->name; ?></h6>
                                                        <!-- <?php if ($item->color): ?>
                                                        <small class="text-muted">Màu: <?php echo $item->color; ?></small>
                                                        <?php endif; ?>
                                                        <?php if ($item->size): ?>
                                                        <small class="text-muted">Size: <?php echo $item->size; ?></small>
                                                        <?php endif; ?> -->
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center"><?php echo $item->quantity; ?></td>
                                            <td class="text-end"><?php echo number_format($item->price); ?>đ</td>
                                            <td class="text-end"><?php echo number_format($item->price * $item->quantity); ?>đ</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end">VAT 10%:</td>
                                            <td class="text-end"><?php echo number_format($order->tax_amount); ?>đ</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">Phí vận chuyển:</td>
                                            <td class="text-end"><?php echo number_format($order->shipping_fee); ?>đ</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">Giảm giá:</td>
                                            <td class="text-end text-danger">-<?php echo number_format($order->discount_amount); ?>đ</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                            <td class="text-end fw-bold"><?php echo number_format($order->total_amount); ?>đ</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Support Information -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h6 class="mb-3">Bạn cần hỗ trợ?</h6>
                            <p class="mb-2">Nếu bạn có bất kỳ câu hỏi nào về đơn hàng của mình, vui lòng liên hệ với chúng tôi:</p>
                            <ul class="list-unstyled mb-0">
                                <li><i class="bi bi-telephone me-2"></i>Hotline: 1900 1234</li>
                                <li><i class="bi bi-envelope me-2"></i>Email: support@cameravn.com</li>
                                <li><i class="bi bi-clock me-2"></i>Giờ làm việc: 8:00 - 20:00 (Thứ 2 - Chủ nhật)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// Tự động chuyển hướng sau 30 giây nếu không có tương tác
let timeout = setTimeout(function() {
    window.location.href = 'index.php';
}, 30000);

// Reset timeout khi có tương tác
document.addEventListener('mousemove', function() {
    clearTimeout(timeout);
    timeout = setTimeout(function() {
        window.location.href = 'index.php';
    }, 30000);
});
</script> 