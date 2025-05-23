<main>
    <!-- Page Header -->
    <section class="page-header py-5 mb-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fw-bold mb-3">Chi tiết đơn hàng #<?php echo str_pad($order->id, 6, '0', STR_PAD_LEFT); ?></h1>
                    <p class="text-muted">Đặt hàng ngày <?php echo date('d/m/Y', strtotime($order->created_at)); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Order Detail Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Order Items -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Sản phẩm đã đặt</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if(!empty($order_items)): ?>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th class="text-end">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($order_items as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if(!empty($item->image_url)): ?>
                                                    <div class="cart-thumbnail me-3" style="background-image: url('<?php echo $item->image_url; ?>');"></div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="mb-1"><?php echo $item->name; ?></h6>
                                                        <?php if(!empty($item->options)): 
                                                            $options = json_decode($item->options, true);
                                                            if(is_array($options)):
                                                                foreach($options as $key => $value):
                                                        ?>
                                                        <small class="text-muted d-block"><?php echo ucfirst($key); ?>: <?php echo $value; ?></small>
                                                        <?php 
                                                                endforeach;
                                                            endif;
                                                        endif; 
                                                        ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo number_format($item->price, 0, ',', '.'); ?>đ</td>
                                            <td><?php echo $item->quantity; ?></td>
                                            <td class="text-end"><?php echo number_format($item->price * $item->quantity, 0, ',', '.'); ?>đ</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <p>Không có sản phẩm nào trong đơn hàng.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Order Timeline -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Trạng thái đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="order-timeline">
                                <div class="order-timeline-item active">
                                    <div class="order-timeline-point"></div>
                                    <div class="order-timeline-content">
                                        <h6>Đặt hàng thành công</h6>
                                        <p class="mb-0">
                                            <i class="bi bi-clock"></i> 
                                            <?php echo date('H:i d/m/Y', strtotime($order->created_at)); ?>
                                        </p>
                                    </div>
                                </div>
                                
                                <?php
                                // Tạo timeline dựa vào trạng thái đơn hàng
                                $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                                $status_texts = [
                                    'pending' => 'Đang chờ xác nhận',
                                    'processing' => 'Đang xử lý',
                                    'shipped' => 'Đang giao hàng',
                                    'delivered' => 'Giao hàng thành công'
                                ];
                                
                                $status_index = array_search($order->status, $statuses);
                                
                                if ($order->status != 'cancelled'):
                                    for ($i = 1; $i < count($statuses); $i++):
                                        $is_active = $i <= $status_index;
                                ?>
                                <div class="order-timeline-item <?php echo $is_active ? 'active' : ''; ?>">
                                    <div class="order-timeline-point"></div>
                                    <div class="order-timeline-content">
                                        <h6><?php echo $status_texts[$statuses[$i]]; ?></h6>
                                        <?php if ($is_active): ?>
                                        <p class="mb-0">
                                            <i class="bi bi-clock"></i> 
                                            <?php 
                                            // Giả định thời gian xử lý giữa các trạng thái
                                            $date = new DateTime($order->created_at);
                                            $date->modify('+' . ($i * 24) . ' hours');
                                            echo $date->format('H:i d/m/Y');
                                            ?>
                                        </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php 
                                    endfor;
                                else:
                                ?>
                                <div class="order-timeline-item cancelled">
                                    <div class="order-timeline-point"></div>
                                    <div class="order-timeline-content">
                                        <h6>Đơn hàng đã hủy</h6>
                                        <p class="mb-0">
                                            <i class="bi bi-clock"></i> 
                                            <?php 
                                            $date = new DateTime($order->updated_at);
                                            echo $date->format('H:i d/m/Y');
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Tóm tắt đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tạm tính</span>
                                    <span><?php echo number_format($order->total_amount - $order->shipping_fee - $order->tax_amount + $order->discount_amount, 0, ',', '.'); ?>đ</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Phí vận chuyển</span>
                                    <span><?php echo number_format($order->shipping_fee, 0, ',', '.'); ?>đ</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Thuế (VAT)</span>
                                    <span><?php echo number_format($order->tax_amount, 0, ',', '.'); ?>đ</span>
                                </div>
                                <?php if($order->discount_amount > 0): ?>
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>Giảm giá</span>
                                    <span>-<?php echo number_format($order->discount_amount, 0, ',', '.'); ?>đ</span>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center h5 mb-0">
                                <span>Tổng cộng</span>
                                <span class="text-primary"><?php echo number_format($order->total_amount, 0, ',', '.'); ?>đ</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Shipping Info -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Thông tin nhận hàng</h5>
                        </div>
                        <div class="card-body">
                            <p class="fw-bold mb-1"><?php echo $order->name; ?></p>
                            <p class="mb-1">SĐT: <?php echo $order->phone; ?></p>
                            <p class="mb-1">Email: <?php echo $order->email; ?></p>
                            <p class="mb-0">Địa chỉ: <?php echo $order->address . ', ' . $order->ward . ', ' . $order->district . ', ' . $order->city; ?></p>
                        </div>
                    </div>
                    
                    <!-- Payment Info -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Thông tin thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <span class="fw-bold">Phương thức thanh toán:</span>
                                <span class="ms-2">
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
                                        default:
                                            echo $order->payment_method;
                                    }
                                    ?>
                                </span>
                            </p>
                            <p class="mb-0">
                                <span class="fw-bold">Trạng thái thanh toán:</span>
                                <span class="ms-2">
                                    <?php if($order->status == 'delivered'): ?>
                                    <span class="badge bg-success">Đã thanh toán</span>
                                    <?php elseif($order->status == 'cancelled'): ?>
                                    <span class="badge bg-danger">Đã hủy</span>
                                    <?php else: ?>
                                    <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                    <?php endif; ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="d-grid gap-2">
                        <a href="index.php?page=profile#orders" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Quay lại đơn hàng của tôi
                        </a>
                        <?php if($order->status == 'pending'): ?>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                            <i class="bi bi-x-circle me-2"></i>Hủy đơn hàng
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Cancel Order Modal -->
<?php if($order->status == 'pending'): ?>
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Xác nhận hủy đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng này không? Hành động này không thể hoàn tác.</p>
                <form id="cancelOrderForm" action="index.php?page=cancel_order" method="post">
                    <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                    <div class="mb-3">
                        <label for="cancel_reason" class="form-label">Lý do hủy đơn</label>
                        <select class="form-select" id="cancel_reason" name="cancel_reason" required>
                            <option value="">Chọn lý do...</option>
                            <option value="changed_mind">Đổi ý không muốn mua nữa</option>
                            <option value="found_better_price">Tìm thấy giá tốt hơn</option>
                            <option value="ordered_wrong">Đặt nhầm sản phẩm</option>
                            <option value="shipping_too_long">Thời gian giao hàng quá lâu</option>
                            <option value="other">Lý do khác</option>
                        </select>
                    </div>
                    <div class="mb-3" id="other_reason_container" style="display: none;">
                        <label for="other_reason" class="form-label">Lý do khác</label>
                        <textarea class="form-control" id="other_reason" name="other_reason" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger" id="confirmCancelOrder">Xác nhận hủy</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
.order-timeline {
    position: relative;
    margin: 0;
    padding: 0;
}

.order-timeline:before {
    content: '';
    position: absolute;
    top: 0;
    left: 15px;
    width: 2px;
    height: 100%;
    background-color: #dee2e6;
}

.order-timeline-item {
    position: relative;
    padding-left: 45px;
    padding-bottom: 30px;
}

.order-timeline-item:last-child {
    padding-bottom: 0;
}

.order-timeline-point {
    position: absolute;
    top: 0;
    left: 8px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: #dee2e6;
    border: 2px solid #fff;
    z-index: 1;
}

.order-timeline-item.active .order-timeline-point {
    background-color: #0d6efd;
}

.order-timeline-item.cancelled .order-timeline-point {
    background-color: #dc3545;
}

.order-timeline-content {
    position: relative;
}

.order-timeline-content h6 {
    margin-bottom: 0.5rem;
}

.order-timeline-content p {
    color: #6c757d;
    font-size: 0.875rem;
}

.cart-thumbnail {
    width: 70px;
    height: 70px;
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if($order->status == 'pending'): ?>
    // Xử lý hiển thị trường lý do khác
    const cancelReasonSelect = document.getElementById('cancel_reason');
    const otherReasonContainer = document.getElementById('other_reason_container');
    const otherReasonTextarea = document.getElementById('other_reason');
    
    if (cancelReasonSelect && otherReasonContainer && otherReasonTextarea) {
        cancelReasonSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                otherReasonContainer.style.display = 'block';
                otherReasonTextarea.setAttribute('required', 'required');
            } else {
                otherReasonContainer.style.display = 'none';
                otherReasonTextarea.removeAttribute('required');
            }
        });
    }
    
    // Xử lý xác nhận hủy đơn hàng
    const confirmCancelButton = document.getElementById('confirmCancelOrder');
    const cancelOrderForm = document.getElementById('cancelOrderForm');
    
    if (confirmCancelButton && cancelOrderForm) {
        confirmCancelButton.addEventListener('click', function() {
            if (cancelOrderForm.checkValidity()) {
                cancelOrderForm.submit();
            } else {
                cancelOrderForm.reportValidity();
            }
        });
    }
    <?php endif; ?>
});
</script>