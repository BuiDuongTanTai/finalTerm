<div class="container mt-4">
    <h2 class="mb-4">Quản lý người dùng</h2>
    
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Danh sách người dùng</h4>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus"></i> Thêm người dùng mới
            </button>
        </div>
    </div>

    <?php
    // Hiển thị thông báo
    if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
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
                        $stmt = $DBH->query("SELECT * FROM users ORDER BY id DESC");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $statusBadge = $row['status'] == 1 ? 
                                '<span class="badge bg-success">Hoạt động</span>' : 
                                '<span class="badge bg-danger">Khóa</span>';
                            
                            $roleBadge = '';
                            switch($row['role']) {
                                case 'admin':
                                    $roleBadge = '<span class="badge bg-danger">Admin</span>';
                                    break;
                                case 'staff':
                                    $roleBadge = '<span class="badge bg-info">Nhân viên</span>';
                                    break;
                                case 'customer':
                                    $roleBadge = '<span class="badge bg-secondary">Khách hàng</span>';
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
                            echo "<td>
                                    <button class='btn btn-sm btn-warning edit-user' data-id='{$row['id']}' data-bs-toggle='modal' data-bs-target='#editUserModal'>
                                        <i class='fas fa-edit'></i>
                                    </button>
                                    <button class='btn btn-sm btn-danger delete-user' data-id='{$row['id']}'>
                                        <i class='fas fa-trash'></i>
                                    </button>
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

<!-- Modal thêm người dùng -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="index.php?act=add_user" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm người dùng mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
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
                        <input type="tel" class="form-control" id="phone" name="phone">
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
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="1">Hoạt động</option>
                            <option value="0">Khóa</option>
                        </select>
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

<script>
// Xử lý xóa người dùng
document.querySelectorAll('.delete-user').forEach(button => {
    button.addEventListener('click', function() {
        const userId = this.getAttribute('data-id');
        if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
            window.location.href = `index.php?act=delete_user&id=${userId}`;
        }
    });
});
</script>