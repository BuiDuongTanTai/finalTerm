<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Quản lý người dùng</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-plus"></i> Thêm người dùng mới
            </button>
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
                        <input type="hidden" name="act" value="user">
                        <input type="text" name="search" class="form-control me-2" placeholder="Tìm theo tên, email hoặc số điện thoại" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button type="submit" class="btn btn-outline-primary">Tìm</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="" method="get" class="d-flex justify-content-end">
                        <input type="hidden" name="act" value="user">
                        <?php if (isset($_GET['search'])): ?>
                        <input type="hidden" name="search" value="<?php echo $_GET['search']; ?>">
                        <?php endif; ?>
                        <select name="role" class="form-select w-auto me-2" onchange="this.form.submit()">
                            <option value="">Tất cả vai trò</option>
                            <option value="admin" <?php echo (isset($_GET['role']) && $_GET['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="staff" <?php echo (isset($_GET['role']) && $_GET['role'] == 'staff') ? 'selected' : ''; ?>>Nhân viên</option>
                            <option value="customer" <?php echo (isset($_GET['role']) && $_GET['role'] == 'customer') ? 'selected' : ''; ?>>Khách hàng</option>
                        </select>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $DBH = connect();
                        
                        // Xây dựng câu truy vấn
                        $sql = "SELECT * FROM users WHERE 1=1";
                        $params = [];
                        
                        // Tìm kiếm
                        if (isset($_GET['search']) && !empty($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql .= " AND (name LIKE :search OR email LIKE :search OR phone LIKE :search)";
                            $params[':search'] = "%$search%";
                        }
                        
                        // Lọc theo vai trò
                        if (isset($_GET['role']) && !empty($_GET['role'])) {
                            $role = $_GET['role'];
                            $sql .= " AND role = :role";
                            $params[':role'] = $role;
                        }
                        
                        $sql .= " ORDER BY id ASC";
                        
                        // Phân trang
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;
                        
                        // Đếm tổng số người dùng
                        $count_sql = str_replace("*", "COUNT(*)", $sql);
                        $count_stmt = $DBH->prepare($count_sql);
                        foreach ($params as $key => $value) {
                            $count_stmt->bindValue($key, $value);
                        }
                        $count_stmt->execute();
                        $total_users = $count_stmt->fetchColumn();
                        $total_pages = ceil($total_users / $limit);
                        
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
                            $statusBadge = $row['status'] == 1 ? 
                                '<span class="badge bg-success">Hoạt động</span>' : 
                                '<span class="badge bg-secondary">Khóa</span>';
                            
                            $roleBadge = '';
                            switch($row['role']) {
                                case 'admin':
                                    $roleBadge = '<span class="badge bg-danger">Admin</span>';
                                    break;
                                case 'staff':
                                    $roleBadge = '<span class="badge bg-primary">Nhân viên</span>';
                                    break;
                                case 'customer':
                                    $roleBadge = '<span class="badge bg-info">Khách hàng</span>';
                                    break;
                            }
                            
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$row['email']}</td>";
                            echo "<td>{$row['phone']}</td>";
                            echo "<td>{$roleBadge}</td>";
                            echo "<td>{$statusBadge}</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['created_at'])) . "</td>";
                            echo "<td>";
                            echo "<div class='btn-group'>";
                            echo "<a href='index.php?act=edit_user&id={$row['id']}' class='btn btn-sm btn-primary'><i class='bi bi-pencil'></i></a>";
                            
                        // Không cho phép xóa chính mình hoặc người cùng role admin
                        if ($row['id'] != $_SESSION['admin']['id'] && $row['role'] != 'admin') {
                            echo "<a href='javascript:void(0)' onclick='confirmDelete({$row['id']})' class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></a>";
                        }
                            
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        
                        if ($stmt->rowCount() == 0) {
                            echo "<tr><td colspan='8' class='text-center'>Không có người dùng nào</td></tr>";
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
                        <a class="page-link" href="?act=user<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['role']) ? '&role='.$_GET['role'] : ''; ?>&page=<?php echo $page-1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?act=user<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['role']) ? '&role='.$_GET['role'] : ''; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?act=user<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['role']) ? '&role='.$_GET['role'] : ''; ?>&page=<?php echo $page+1; ?>" aria-label="Next">
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

<!-- Modal thêm người dùng -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Thêm người dùng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?act=add_user" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="customer">Khách hàng</option>
                            <option value="staff">Nhân viên</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status1" value="1" checked>
                                <label class="form-check-label" for="status1">Hoạt động</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status0" value="0">
                                <label class="form-check-label" for="status0">Khóa</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Xác nhận xóa người dùng
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
        window.location.href = `index.php?act=delete_user&id=${id}`;
    }
}
</script>