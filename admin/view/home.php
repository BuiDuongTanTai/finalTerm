<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    
    <!-- Thống kê -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="bi bi-box h1 text-primary"></i>
                        </div>
                        <div class="col ml-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sản phẩm</div>
                            <div class="dashboard-number">
                                <?php
                                $DBH = connect();
                                $stmt = $DBH->query("SELECT COUNT(*) FROM products");
                                echo $stmt->fetchColumn();
                                ?>
                            </div>
                            <a href="index.php?act=product" class="btn btn-sm btn-outline-primary mt-2">Quản lý</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="bi bi-cart h1 text-success"></i>
                        </div>
                        <div class="col ml-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Đơn hàng</div>
                            <div class="dashboard-number">
                                <?php
                                $stmt = $DBH->query("SELECT COUNT(*) FROM orders");
                                echo $stmt->fetchColumn();
                                ?>
                            </div>
                            <a href="index.php?act=order" class="btn btn-sm btn-outline-success mt-2">Quản lý</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="bi bi-people h1 text-info"></i>
                        </div>
                        <div class="col ml-3">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Khách hàng</div>
                            <div class="dashboard-number">
                                <?php
                                $stmt = $DBH->query("SELECT COUNT(*) FROM users WHERE role = 'customer'");
                                echo $stmt->fetchColumn();
                                ?>
                            </div>
                            <a href="index.php?act=user" class="btn btn-sm btn-outline-info mt-2">Quản lý</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="bi bi-star h1 text-warning"></i>
                        </div>
                        <div class="col ml-3">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Đánh giá</div>
                            <div class="dashboard-number">
                                <?php
                                $stmt = $DBH->query("SELECT COUNT(*) FROM reviews");
                                echo $stmt->fetchColumn();
                                ?>
                            </div>
                            <a href="index.php?act=comment" class="btn btn-sm btn-outline-warning mt-2">Quản lý</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê đơn hàng gần đây và đơn hàng chờ xử lý -->
    <div class="row">
        <!-- Đơn hàng gần đây -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Đơn hàng gần đây</h6>
                    <a href="index.php?act=order" class="btn btn-sm btn-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $DBH->query("SELECT * FROM orders ORDER BY created_at ASC LIMIT 5");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $statusBadge = '';
                                    switch($row['status']) {
                                        case 'pending':
                                            $statusBadge = '<span class="badge bg-warning">Chờ xử lý</span>';
                                            break;
                                        case 'processing':
                                            $statusBadge = '<span class="badge bg-primary">Đang xử lý</span>';
                                            break;
                                        case 'shipped':
                                            $statusBadge = '<span class="badge bg-info">Đang giao</span>';
                                            break;
                                        case 'delivered':
                                            $statusBadge = '<span class="badge bg-success">Đã giao</span>';
                                            break;
                                        case 'cancelled':
                                            $statusBadge = '<span class="badge bg-danger">Đã hủy</span>';
                                            break;
                                    }
                                    
                                    echo "<tr>";
                                    echo "<td><a href='index.php?act=order_detail&id={$row['id']}'>#{$row['id']}</a></td>";
                                    echo "<td>{$row['name']}</td>";
                                    echo "<td>" . number_format($row['total_amount']) . " VND</td>";
                                    echo "<td>{$statusBadge}</td>";
                                    echo "<td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
                                    echo "</tr>";
                                }
                                
                                if ($stmt->rowCount() == 0) {
                                    echo "<tr><td colspan='5' class='text-center'>Không có đơn hàng nào</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Đơn hàng chờ xử lý -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-warning">Đơn hàng chờ xử lý</h6>
                    <a href="index.php?act=order&status=pending" class="btn btn-sm btn-warning">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Ngày đặt</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $DBH->query("SELECT * FROM orders WHERE status = 'pending' ORDER BY created_at ASC LIMIT 5");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>#{$row['id']}</td>";
                                    echo "<td>{$row['name']}</td>";
                                    echo "<td>" . number_format($row['total_amount']) . " VND</td>";
                                    echo "<td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
                                    echo "<td><a href='index.php?act=order_detail&id={$row['id']}' class='btn btn-sm btn-primary'>Chi tiết</a></td>";
                                    echo "</tr>";
                                }
                                
                                if ($stmt->rowCount() == 0) {
                                    echo "<tr><td colspan='5' class='text-center'>Không có đơn hàng nào đang chờ xử lý</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sản phẩm bán chạy và Đánh giá gần đây -->
    <div class="row">
        <!-- Sản phẩm bán chạy -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Sản phẩm bán chạy</h6>
                    <a href="index.php?act=product" class="btn btn-sm btn-success">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đã bán</th>
                                    <th>Còn lại</th>
                                    <th>Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $DBH->query("SELECT r.*, p.name as product_name FROM reviews r LEFT JOIN products p ON r.product_id = p.id ORDER BY r.created_at DESC LIMIT 5");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>{$row['name']}</td>";
                                    echo "<td>{$row['sold_count']}</td>";
                                    echo "<td>{$row['stock']}</td>";
                                    echo "<td>" . number_format($row['price']) . " VND</td>";
                                    echo "</tr>";
                                }
                                
                                if ($stmt->rowCount() == 0) {
                                    echo "<tr><td colspan='4' class='text-center'>Không có sản phẩm nào</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Đánh giá gần đây -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-info">Đánh giá gần đây</h6>
                    <a href="index.php?act=comment" class="btn btn-sm btn-info">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Người đánh giá</th>
                                    <th>Đánh giá</th>
                                    <th>Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $DBH->query("SELECT r.*, p.name as product_name FROM reviews r LEFT JOIN products p ON r.product_id = p.id ORDER BY r.created_at DESC LIMIT 5");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $stars = str_repeat('⭐', $row['rating']);
                                    
                                    echo "<tr>";
                                    echo "<td>{$row['product_name']}</td>";
                                    echo "<td>{$row['name']}</td>";
                                    echo "<td>{$stars}</td>";
                                    echo "<td>" . date('d/m/Y', strtotime($row['created_at'])) . "</td>";
                                    echo "</tr>";
                                }
                                
                                if ($stmt->rowCount() == 0) {
                                    echo "<tr><td colspan='4' class='text-center'>Không có đánh giá nào</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>