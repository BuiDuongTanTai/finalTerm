<div class="container mt-4">
    <h2 class="mb-4">Quản lý đơn hàng</h2>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Điện thoại</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $DBH = connect();
                        $stmt = $DBH->query("SELECT * FROM orders ORDER BY created_at DESC");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $statusBadge = '';
                            switch($row['status']) {
                                case 'pending':
                                    $statusBadge = '<span class="badge bg-warning">Chờ xử lý</span>';
                                    break;
                                case 'processing':
                                    $statusBadge = '<span class="badge bg-info">Đang xử lý</span>';
                                    break;
                                case 'shipped':
                                    $statusBadge = '<span class="badge bg-primary">Đang giao</span>';
                                    break;
                                case 'delivered':
                                    $statusBadge = '<span class="badge bg-success">Đã giao</span>';
                                    break;
                                case 'cancelled':
                                    $statusBadge = '<span class="badge bg-danger">Đã hủy</span>';
                                    break;
                            }
                            
                            echo "<tr>";
                            echo "<td>#{$row['id']}</td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$row['phone']}</td>";
                            echo "<td>" . number_format($row['total_amount']) . " VND</td>";
                            echo "<td>{$statusBadge}</td>";
                            echo "<td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
                            echo "<td>
                                    <a href='index.php?act=order_detail&id={$row['id']}' class='btn btn-sm btn-info'>
                                        <i class='fas fa-eye'></i> Chi tiết
                                    </a>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>