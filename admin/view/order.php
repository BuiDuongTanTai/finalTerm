<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Quản lý đơn hàng</h5>
        </div>
        <div class="card-body">
            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_GET['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_GET['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="" method="get" class="d-flex">
                        <input type="hidden" name="act" value="order">
                        <input type="text" name="search" class="form-control me-2" placeholder="Tìm theo mã đơn hoặc tên khách hàng" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button type="submit" class="btn btn-outline-primary">Tìm</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="" method="get" class="d-flex justify-content-end">
                        <input type="hidden" name="act" value="order">
                        <?php if (isset($_GET['search'])): ?>
                        <input type="hidden" name="search" value="<?php echo $_GET['search']; ?>">
                        <?php endif; ?>
                        <select name="status" class="form-select w-auto me-2" onchange="this.form.submit()">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" <?php echo (isset($_GET['status']) && $_GET['status'] == 'pending') ? 'selected' : ''; ?>>Chờ xử lý</option>
                            <option value="processing" <?php echo (isset($_GET['status']) && $_GET['status'] == 'processing') ? 'selected' : ''; ?>>Đang xử lý</option>
                            <option value="shipped" <?php echo (isset($_GET['status']) && $_GET['status'] == 'shipped') ? 'selected' : ''; ?>>Đang giao</option>
                            <option value="delivered" <?php echo (isset($_GET['status']) && $_GET['status'] == 'delivered') ? 'selected' : ''; ?>>Đã giao</option>
                            <option value="cancelled" <?php echo (isset($_GET['status']) && $_GET['status'] == 'cancelled') ? 'selected' : ''; ?>>Đã hủy</option>
                        </select>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
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
                        
                        // Xây dựng câu truy vấn
                        $sql = "SELECT * FROM orders WHERE 1=1";
                        $params = [];
                        
                        // Tìm kiếm
                        if (isset($_GET['search']) && !empty($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql .= " AND (id LIKE :search OR name LIKE :search OR phone LIKE :search)";
                            $params[':search'] = "%$search%";
                        }
                        
                        // Lọc theo trạng thái
                        if (isset($_GET['status']) && !empty($_GET['status'])) {
                            $status = $_GET['status'];
                            $sql .= " AND status = :status";
                            $params[':status'] = $status;
                        }
                        
                        $sql .= " ORDER BY created_at ASC";
                        
                        // Phân trang
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;
                        
                        // Đếm tổng số đơn hàng
                        $count_sql = str_replace("*", "COUNT(*)", $sql);
                        $count_stmt = $DBH->prepare($count_sql);
                        foreach ($params as $key => $value) {
                            $count_stmt->bindValue($key, $value);
                        }
                        $count_stmt->execute();
                        $total_orders = $count_stmt->fetchColumn();
                        $total_pages = ceil($total_orders / $limit);
                        
                        $sql .= " LIMIT :offset, :limit";
                        $params[':offset'] = $offset;
                        $params[':limit'] = $limit;
                        
                        $stmt = $DBH->prepare($sql);
                        foreach ($params as $key => $value) {
                            if ($key == ':offset' || $key == ':limit') {
                                $stmt->bindValue($key, $value, PDO::PARAM_INT);
                            } else {
                                $stmt->bindValue($key, $value);
                            }
                        }
                        $stmt->execute();
                        
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
                            echo "<td>#{$row['id']}</td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$row['phone']}</td>";
                            echo "<td>" . number_format($row['total_amount']) . " VND</td>";
                            echo "<td>{$statusBadge}</td>";
                            echo "<td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
                            echo "<td><a href='index.php?act=order_detail&id={$row['id']}' class='btn btn-sm btn-primary'>Chi tiết</a></td>";
                            echo "</tr>";
                        }
                        
                        if ($stmt->rowCount() == 0) {
                            echo "<tr><td colspan='7' class='text-center'>Không có đơn hàng nào</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?act=order<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['status']) ? '&status='.$_GET['status'] : ''; ?>&page=<?php echo $page-1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?act=order<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['status']) ? '&status='.$_GET['status'] : ''; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?act=order<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['status']) ? '&status='.$_GET['status'] : ''; ?>&page=<?php echo $page+1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>