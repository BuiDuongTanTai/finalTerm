<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Chỉnh sửa người dùng</h5>
        </div>
        <div class="card-body">
            <form action="index.php?act=update_user" method="post">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                
                <div class="mb-3">
                    <label for="name" class="form-label">Họ tên</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="<?php echo $user['email']; ?>" readonly>
                    <small class="text-muted">Email không thể thay đổi</small>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="text-muted">Để trống nếu không muốn thay đổi mật khẩu</small>
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>">
                </div>
                
                <div class="mb-3">
                    <label for="role" class="form-label">Vai trò</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="customer" <?php echo $user['role'] == 'customer' ? 'selected' : ''; ?>>Khách hàng</option>
                        <option value="staff" <?php echo $user['role'] == 'staff' ? 'selected' : ''; ?>>Nhân viên</option>
                        <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="status1" value="1" <?php echo $user['status'] == 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="status1">Hoạt động</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="status0" value="0" <?php echo $user['status'] == 0 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="status0">Khóa</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <a href="index.php?act=user" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>