<main>
    <!-- Page Header -->
    <section class="page-header py-5 mb-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fw-bold mb-3">Tài khoản của tôi</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Profile Section -->
    <section class="profile-section py-5">
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
        
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="profile-sidebar" style="top: 20px;">
                        <div class="profile-info text-center mb-4">
                            <?php if(!empty($user->avatar)): ?>
                                <img src="<?php echo $user->avatar; ?>" alt="<?php echo $user->name; ?>" class="rounded-circle mb-3" width="100" height="100">
                            <?php else: ?>
                                <div class="profile-avatar-placeholder mb-3">
                                    <?php echo substr($user->name, 0, 1); ?>
                                </div>
                            <?php endif; ?>
                            <h5 class="mb-1"><?php echo $user->name; ?></h5>
                            <p class="text-muted mb-0"><?php echo $user->email; ?></p>
                        </div>
                        
                        <div class="list-group">
                            <a href="#profile-info" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                                <i class="bi bi-person me-2"></i>Thông tin cá nhân
                            </a>
                            <a href="#orders" class="list-group-item list-group-item-action" data-bs-toggle="list">
                                <i class="bi bi-bag me-2"></i>Đơn hàng của tôi
                            </a>
                            <a href="#change-password" class="list-group-item list-group-item-action" data-bs-toggle="list">
                                <i class="bi bi-shield-lock me-2"></i>Đổi mật khẩu
                            </a>
                            <a href="index.php?page=wishlist" class="list-group-item list-group-item-action">
                                <i class="bi bi-heart me-2"></i>Sản phẩm yêu thích
                            </a>
                            <a href="index.php?page=recently_viewed" class="list-group-item list-group-item-action">
                                <i class="bi bi-clock-history"></i>Sản phẩm đã xem gần đây
                            </a>
                            <a href="index.php?page=logout" class="list-group-item list-group-item-action text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="tab-content">
                        <!-- Profile Information -->
                        <div class="tab-pane fade show active" id="profile-info">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white py-3">
                                    <h5 class="card-title mb-0">Thông tin cá nhân</h5>
                                </div>
                                <div class="card-body p-4">
                                    <form action="index.php?page=update_profile" method="post" enctype="multipart/form-data">
                                        <div class="mb-4 text-center">
                                            <?php if(!empty($user->avatar)): ?>
                                                <img src="<?php echo $user->avatar; ?>" alt="<?php echo $user->name; ?>" class="rounded-circle mb-3" width="120" height="120" id="avatarPreview">
                                            <?php else: ?>
                                                <div class="profile-avatar-placeholder mb-3" id="avatarPreview">
                                                    <?php echo substr($user->name, 0, 1); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="mb-3">
                                                <label for="avatar" class="form-label d-none">Avatar</label>
                                                <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*">
                                                <div class="form-text">Tối đa 2MB, định dạng JPG, PNG, GIF</div>
                                            </div>
                                        </div>
                                    
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Họ và tên</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user->name; ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Địa chỉ email</label>
                                                <input type="email" class="form-control" id="email" value="<?php echo $user->email; ?>" readonly>
                                                <div class="form-text">Email không thể thay đổi</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="phone" class="form-label">Số điện thoại</label>
                                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $user->phone; ?>">
                                            </div>
                                            <div class="col-12">
                                                <label for="address" class="form-label">Địa chỉ</label>
                                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $user->address; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="city" class="form-label">Tỉnh/Thành phố</label>
                                                <select class="form-select" id="city" name="city">
                                                    <option value="">Chọn tỉnh/thành phố</option>
                                                    <option value="Hà Nội" <?php echo $user->city == 'Hà Nội' ? 'selected' : ''; ?>>Hà Nội</option>
                                                    <option value="TP.HCM" <?php echo $user->city == 'TP.HCM' ? 'selected' : ''; ?>>TP.HCM</option>
                                                    <option value="Đà Nẵng" <?php echo $user->city == 'Đà Nẵng' ? 'selected' : ''; ?>>Đà Nẵng</option>
                                                    <option value="Cần Thơ" <?php echo $user->city == 'Cần Thơ' ? 'selected' : ''; ?>>Cần Thơ</option>
                                                    <option value="Hải Phòng" <?php echo $user->city == 'Hải Phòng' ? 'selected' : ''; ?>>Hải Phòng</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="district" class="form-label">Quận/Huyện</label>
                                                <select class="form-select" id="district" name="district">
                                                    <option value="">Chọn quận/huyện</option>
                                                    <option value="Quận 1" <?php echo $user->district == 'Quận 1' ? 'selected' : ''; ?>>Quận 1</option>
                                                    <option value="Quận 2" <?php echo $user->district == 'Quận 2' ? 'selected' : ''; ?>>Quận 2</option>
                                                    <option value="Quận 3" <?php echo $user->district == 'Quận 3' ? 'selected' : ''; ?>>Quận 3</option>
                                                    <option value="Quận 4" <?php echo $user->district == 'Quận 4' ? 'selected' : ''; ?>>Quận 4</option>
                                                    <option value="Quận 5" <?php echo $user->district == 'Quận 5' ? 'selected' : ''; ?>>Quận 5</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="ward" class="form-label">Phường/Xã</label>
                                                <select class="form-select" id="ward" name="ward">
                                                    <option value="">Chọn phường/xã</option>
                                                    <option value="Phường 1" <?php echo $user->ward == 'Phường 1' ? 'selected' : ''; ?>>Phường 1</option>
                                                    <option value="Phường 2" <?php echo $user->ward == 'Phường 2' ? 'selected' : ''; ?>>Phường 2</option>
                                                    <option value="Phường 3" <?php echo $user->ward == 'Phường 3' ? 'selected' : ''; ?>>Phường 3</option>
                                                    <option value="Phường 4" <?php echo $user->ward == 'Phường 4' ? 'selected' : ''; ?>>Phường 4</option>
                                                    <option value="Phường 5" <?php echo $user->ward == 'Phường 5' ? 'selected' : ''; ?>>Phường 5</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order History -->
                        <div class="tab-pane fade" id="orders">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white py-3">
                                    <h5 class="card-title mb-0">Đơn hàng của tôi</h5>
                                </div>
                                <div class="card-body p-0">
                                    <?php if(isset($orders) && !empty($orders)): ?>
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Mã đơn hàng</th>
                                                    <th>Ngày đặt</th>
                                                    <th>Tổng tiền</th>
                                                    <th>Trạng thái</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($orders as $order): ?>
                                                <tr>
                                                    <td>#<?php echo str_pad($order->id, 6, '0', STR_PAD_LEFT); ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($order->created_at)); ?></td>
                                                    <td><?php echo number_format($order->total_amount, 0, ',', '.'); ?>đ</td>
                                                    <td>
                                                        <?php
                                                        $status_class = '';
                                                        $status_text = '';
                                                        
                                                        switch($order->status) {
                                                            case 'pending':
                                                                $status_class = 'bg-warning';
                                                                $status_text = 'Chờ xác nhận';
                                                                break;
                                                            case 'processing':
                                                                $status_class = 'bg-info';
                                                                $status_text = 'Đang xử lý';
                                                                break;
                                                            case 'shipped':
                                                                $status_class = 'bg-primary';
                                                                $status_text = 'Đang giao hàng';
                                                                break;
                                                            case 'delivered':
                                                                $status_class = 'bg-success';
                                                                $status_text = 'Đã giao hàng';
                                                                break;
                                                            case 'cancelled':
                                                                $status_class = 'bg-danger';
                                                                $status_text = 'Đã hủy';
                                                                break;
                                                        }
                                                        ?>
                                                        <span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                                    </td>
                                                    <td>
                                                        <a href="index.php?page=order_detail&id=<?php echo $order->id; ?>" class="btn btn-sm btn-outline-primary">
                                                            Chi tiết
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                    <div class="text-center py-5">
                                        <i class="bi bi-bag-x" style="font-size: 3rem; color: #ccc;"></i>
                                        <p class="mt-3 mb-0">Bạn chưa có đơn hàng nào.</p>
                                        <a href="index.php?page=all_products" class="btn btn-primary mt-3">Mua sắm ngay</a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Change Password -->
                        <div class="tab-pane fade" id="change-password">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white py-3">
                                    <h5 class="card-title mb-0">Đổi mật khẩu</h5>
                                </div>
                                <div class="card-body p-4">
                                    <form action="index.php?page=change_password" method="post">
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" minlength="6" required>
                                            <div class="form-text">Mật khẩu phải có ít nhất 6 ký tự</div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview avatar image
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');
    
    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (avatarPreview.tagName.toLowerCase() === 'img') {
                        avatarPreview.src = e.target.result;
                    } else {
                        // Create an image element
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'rounded-circle mb-3';
                        img.width = 120;
                        img.height = 120;
                        img.id = 'avatarPreview';
                        
                        // Replace the placeholder with the image
                        avatarPreview.parentNode.replaceChild(img, avatarPreview);
                    }
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    // Validate password confirmation
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');
    const passwordForm = document.querySelector('#change-password form');
    
    if (passwordForm && newPassword && confirmPassword) {
        passwordForm.addEventListener('submit', function(e) {
            if (newPassword.value !== confirmPassword.value) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                confirmPassword.focus();
            }
        });
    }
    
    // Activate tab based on hash in URL
    const hash = window.location.hash;
    if (hash) {
        const tab = document.querySelector(`.list-group-item[href="${hash}"]`);
        if (tab) {
            // Activate the tab
            document.querySelectorAll('.list-group-item').forEach(item => {
                item.classList.remove('active');
            });
            tab.classList.add('active');
            
            // Show the tab content
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });
            document.querySelector(hash).classList.add('show', 'active');
        }
    }
});
</script>