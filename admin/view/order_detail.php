<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Chi tiết đơn hàng #<?php echo $order['id']; ?></h5>
            <a href="index.php?act=order" class="btn btn-sm btn-secondary">Quay lại</a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="fw-bold">Thông tin khách hàng</h6>
                    <p><strong>Họ tên:</strong> <?php echo $order['name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
                    <p><strong>Điện thoại:</strong> <?php echo $order['phone']; ?></p>
                    <p><strong>Địa chỉ:</strong> <?php echo $order['address']; ?>, <?php echo $order['ward']; ?>, <?php echo $order['district']; ?>, <?php echo $order['city']; ?></p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Thông tin đơn hàng</h6>
                    <p><strong>Mã đơn hàng:</strong> #<?php echo $order['id']; ?></p>
                    <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                    <p><strong>Phương thức thanh toán:</strong> <?php echo $order['payment_method']; ?></p>
                    <p><strong>Trạng thái thanh toán:</strong> 
                        <?php 
                        switch($order['payment_status']) {
                            case 'pending': echo '<span class="badge bg-warning">Chờ thanh toán</span>'; break;
                            case 'completed': echo '<span class="badge bg-success">Đã thanh toán</span>'; break;
                            case 'failed': echo '<span class="badge bg-danger">Thất bại</span>'; break;
                            case 'refunded': echo '<span class="badge bg-info">Đã hoàn tiền</span>'; break;
                        }
                        ?>
                    </p>
                    <p><strong>Trạng thái đơn hàng:</strong>
                        <?php 
                        switch($order['status']) {
                            case 'pending': echo '<span class="badge bg-warning">Chờ xử lý</span>'; break;
                            case 'processing': echo '<span class="badge bg-primary">Đang xử lý</span>'; break;
                            case 'shipped': echo '<span class="badge bg-info">Đang giao</span>'; break;
                            case 'delivered': echo '<span class="badge bg-success">Đã giao</span>'; break;
                            case 'cancelled': echo '<span class="badge bg-danger">Đã hủy</span>'; break;
                        }
                        ?>
                    </p>
                </div>
            </div>
            
            <h6 class="fw-bold">Sản phẩm trong đơn hàng</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 100px">Hình ảnh</th>
                            <th>Sản phẩm</th>
                            <th class="text-end">Giá</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td>
                                <?php if (!empty($item['image_url'])): ?>
                                <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>" class="img-thumbnail" style="max-height: 80px;">
                                <?php else: ?>
                                <span class="text-muted">Không có ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $item['name']; ?></td>
                            <td class="text-end"><?php echo number_format($item['price']); ?> VND</td>
                            <td class="text-center"><?php echo $item['quantity']; ?></td>
                            <td class="text-end"><?php echo number_format($item['price'] * $item['quantity']); ?> VND</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Tổng tiền sản phẩm:</strong></td>
                            <td class="text-end"><?php echo number_format($order['total_amount'] - $order['shipping_fee'] + $order['discount_amount']); ?> VND</td>
                        </tr>
                        <?php if ($order['discount_amount'] > 0): ?>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Giảm giá:</strong></td>
                            <td class="text-end">-<?php echo number_format($order['discount_amount']); ?> VND</td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Phí vận chuyển:</strong></td>
                            <td class="text-end"><?php echo number_format($order['shipping_fee']); ?> VND</td>
                        </tr>
                        <?php if ($order['tax_amount'] > 0): ?>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Thuế:</strong></td>
                            <td class="text-end"><?php echo number_format($order['tax_amount']); ?> VND</td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Tổng thanh toán:</strong></td>
                            <td class="text-end fw-bold fs-5"><?php echo number_format($order['total_amount']); ?> VND</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <?php if ($order['notes']): ?>
            <div class="mt-3">
                <h6 class="fw-bold">Ghi chú đơn hàng</h6>
                <p><?php echo $order['notes']; ?></p>
            </div>
            <?php endif; ?>
            
            <div class="mt-4">
                <h6 class="fw-bold">Cập nhật trạng thái đơn hàng</h6>
                <form action="index.php?act=update_order" method="post" class="row">
                    <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Trạng thái đơn hàng</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Chờ xử lý</option>
                            <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Đang xử lý</option>
                            <option value="shipped" <?php echo $order['status'] == 'shipped' ? 'selected' : ''; ?>>Đang giao</option>
                            <option value="delivered" <?php echo $order['status'] == 'delivered' ? 'selected' : ''; ?>>Đã giao</option>
                            <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tracking_number" class="form-label">Mã vận đơn</label>
                        <input type="text" class="form-control" id="tracking_number" name="tracking_number" value="<?php echo $order['tracking_number']; ?>">
                    </div>
                    <div class="col-md-4 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>