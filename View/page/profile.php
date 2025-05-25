<main>
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
                                                    <option value="Hải Phòng" <?php echo $user->city == 'Hải Phòng' ? 'selected' : ''; ?>>Hải Phòng</option>
                                                    <option value="Cần Thơ" <?php echo $user->city == 'Cần Thơ' ? 'selected' : ''; ?>>Cần Thơ</option>
                                                    <option value="An Giang" <?php echo $user->city == 'An Giang' ? 'selected' : ''; ?>>An Giang</option>
                                                    <option value="Bà Rịa-Vũng Tàu" <?php echo $user->city == 'Bà Rịa-Vũng Tàu' ? 'selected' : ''; ?>>Bà Rịa-Vũng Tàu</option>
                                                    <option value="Bắc Giang" <?php echo $user->city == 'Bắc Giang' ? 'selected' : ''; ?>>Bắc Giang</option>
                                                    <option value="Bắc Kạn" <?php echo $user->city == 'Bắc Kạn' ? 'selected' : ''; ?>>Bắc Kạn</option>
                                                    <option value="Bạc Liêu" <?php echo $user->city == 'Bạc Liêu' ? 'selected' : ''; ?>>Bạc Liêu</option>
                                                    <option value="Bắc Ninh" <?php echo $user->city == 'Bắc Ninh' ? 'selected' : ''; ?>>Bắc Ninh</option>
                                                    <option value="Bến Tre" <?php echo $user->city == 'Bến Tre' ? 'selected' : ''; ?>>Bến Tre</option>
                                                    <option value="Bình Định" <?php echo $user->city == 'Bình Định' ? 'selected' : ''; ?>>Bình Định</option>
                                                    <option value="Bình Dương" <?php echo $user->city == 'Bình Dương' ? 'selected' : ''; ?>>Bình Dương</option>
                                                    <option value="Bình Phước" <?php echo $user->city == 'Bình Phước' ? 'selected' : ''; ?>>Bình Phước</option>
                                                    <option value="Bình Thuận" <?php echo $user->city == 'Bình Thuận' ? 'selected' : ''; ?>>Bình Thuận</option>
                                                    <option value="Cà Mau" <?php echo $user->city == 'Cà Mau' ? 'selected' : ''; ?>>Cà Mau</option>
                                                    <option value="Cao Bằng" <?php echo $user->city == 'Cao Bằng' ? 'selected' : ''; ?>>Cao Bằng</option>
                                                    <option value="Đắk Lắk" <?php echo $user->city == 'Đắk Lắk' ? 'selected' : ''; ?>>Đắk Lắk</option>
                                                    <option value="Đắk Nông" <?php echo $user->city == 'Đắk Nông' ? 'selected' : ''; ?>>Đắk Nông</option>
                                                    <option value="Điện Biên" <?php echo $user->city == 'Điện Biên' ? 'selected' : ''; ?>>Điện Biên</option>
                                                    <option value="Đồng Nai" <?php echo $user->city == 'Đồng Nai' ? 'selected' : ''; ?>>Đồng Nai</option>
                                                    <option value="Đồng Tháp" <?php echo $user->city == 'Đồng Tháp' ? 'selected' : ''; ?>>Đồng Tháp</option>
                                                    <option value="Gia Lai" <?php echo $user->city == 'Gia Lai' ? 'selected' : ''; ?>>Gia Lai</option>
                                                    <option value="Hà Giang" <?php echo $user->city == 'Hà Giang' ? 'selected' : ''; ?>>Hà Giang</option>
                                                    <option value="Hà Nam" <?php echo $user->city == 'Hà Nam' ? 'selected' : ''; ?>>Hà Nam</option>
                                                    <option value="Hà Tĩnh" <?php echo $user->city == 'Hà Tĩnh' ? 'selected' : ''; ?>>Hà Tĩnh</option>
                                                    <option value="Hải Dương" <?php echo $user->city == 'Hải Dương' ? 'selected' : ''; ?>>Hải Dương</option>
                                                    <option value="Hậu Giang" <?php echo $user->city == 'Hậu Giang' ? 'selected' : ''; ?>>Hậu Giang</option>
                                                    <option value="Hòa Bình" <?php echo $user->city == 'Hòa Bình' ? 'selected' : ''; ?>>Hòa Bình</option>
                                                    <option value="Hưng Yên" <?php echo $user->city == 'Hưng Yên' ? 'selected' : ''; ?>>Hưng Yên</option>
                                                    <option value="Khánh Hòa" <?php echo $user->city == 'Khánh Hòa' ? 'selected' : ''; ?>>Khánh Hòa</option>
                                                    <option value="Kiên Giang" <?php echo $user->city == 'Kiên Giang' ? 'selected' : ''; ?>>Kiên Giang</option>
                                                    <option value="Kon Tum" <?php echo $user->city == 'Kon Tum' ? 'selected' : ''; ?>>Kon Tum</option>
                                                    <option value="Lai Châu" <?php echo $user->city == 'Lai Châu' ? 'selected' : ''; ?>>Lai Châu</option>
                                                    <option value="Lâm Đồng" <?php echo $user->city == 'Lâm Đồng' ? 'selected' : ''; ?>>Lâm Đồng</option>
                                                    <option value="Lạng Sơn" <?php echo $user->city == 'Lạng Sơn' ? 'selected' : ''; ?>>Lạng Sơn</option>
                                                    <option value="Lào Cai" <?php echo $user->city == 'Lào Cai' ? 'selected' : ''; ?>>Lào Cai</option>
                                                    <option value="Long An" <?php echo $user->city == 'Long An' ? 'selected' : ''; ?>>Long An</option>
                                                    <option value="Nam Định" <?php echo $user->city == 'Nam Định' ? 'selected' : ''; ?>>Nam Định</option>
                                                    <option value="Nghệ An" <?php echo $user->city == 'Nghệ An' ? 'selected' : ''; ?>>Nghệ An</option>
                                                    <option value="Ninh Bình" <?php echo $user->city == 'Ninh Bình' ? 'selected' : ''; ?>>Ninh Bình</option>
                                                    <option value="Ninh Thuận" <?php echo $user->city == 'Ninh Thuận' ? 'selected' : ''; ?>>Ninh Thuận</option>
                                                    <option value="Phú Thọ" <?php echo $user->city == 'Phú Thọ' ? 'selected' : ''; ?>>Phú Thọ</option>
                                                    <option value="Phú Yên" <?php echo $user->city == 'Phú Yên' ? 'selected' : ''; ?>>Phú Yên</option>
                                                    <option value="Quảng Bình" <?php echo $user->city == 'Quảng Bình' ? 'selected' : ''; ?>>Quảng Bình</option>
                                                    <option value="Quảng Nam" <?php echo $user->city == 'Quảng Nam' ? 'selected' : ''; ?>>Quảng Nam</option>
                                                    <option value="Quảng Ngãi" <?php echo $user->city == 'Quảng Ngãi' ? 'selected' : ''; ?>>Quảng Ngãi</option>
                                                    <option value="Quảng Ninh" <?php echo $user->city == 'Quảng Ninh' ? 'selected' : ''; ?>>Quảng Ninh</option>
                                                    <option value="Quảng Trị" <?php echo $user->city == 'Quảng Trị' ? 'selected' : ''; ?>>Quảng Trị</option>
                                                    <option value="Sóc Trăng" <?php echo $user->city == 'Sóc Trăng' ? 'selected' : ''; ?>>Sóc Trăng</option>
                                                    <option value="Sơn La" <?php echo $user->city == 'Sơn La' ? 'selected' : ''; ?>>Sơn La</option>
                                                    <option value="Tây Ninh" <?php echo $user->city == 'Tây Ninh' ? 'selected' : ''; ?>>Tây Ninh</option>
                                                    <option value="Thái Bình" <?php echo $user->city == 'Thái Bình' ? 'selected' : ''; ?>>Thái Bình</option>
                                                    <option value="Thái Nguyên" <?php echo $user->city == 'Thái Nguyên' ? 'selected' : ''; ?>>Thái Nguyên</option>
                                                    <option value="Thanh Hóa" <?php echo $user->city == 'Thanh Hóa' ? 'selected' : ''; ?>>Thanh Hóa</option>
                                                    <option value="Thừa Thiên-Huế" <?php echo $user->city == 'Thừa Thiên-Huế' ? 'selected' : ''; ?>>Thừa Thiên-Huế</option>
                                                    <option value="Tiền Giang" <?php echo $user->city == 'Tiền Giang' ? 'selected' : ''; ?>>Tiền Giang</option>
                                                    <option value="Trà Vinh" <?php echo $user->city == 'Trà Vinh' ? 'selected' : ''; ?>>Trà Vinh</option>
                                                    <option value="Tuyên Quang" <?php echo $user->city == 'Tuyên Quang' ? 'selected' : ''; ?>>Tuyên Quang</option>
                                                    <option value="Vĩnh Long" <?php echo $user->city == 'Vĩnh Long' ? 'selected' : ''; ?>>Vĩnh Long</option>
                                                    <option value="Vĩnh Phúc" <?php echo $user->city == 'Vĩnh Phúc' ? 'selected' : ''; ?>>Vĩnh Phúc</option>
                                                    <option value="Yên Bái" <?php echo $user->city == 'Yên Bái' ? 'selected' : ''; ?>>Yên Bái</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="district" class="form-label">Quận/Huyện</label>
                                                <select class="form-select" id="district" name="district">
                                                    <option value="">Chọn quận/huyện</option>
                                                    <?php if ($user->district): ?>
                                                        <option value="<?php echo $user->district; ?>" selected><?php echo $user->district; ?></option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="ward" class="form-label">Phường/Xã</label>
                                                <select class="form-select" id="ward" name="ward">
                                                    <option value="">Chọn phường/xã</option>
                                                <?php if ($user->ward): ?>
                                                    <option value="<?php echo $user->ward; ?>" selected><?php echo $user->ward; ?></option>
                                                <?php endif; ?>
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


<script>
// Dữ liệu các tỉnh thành, quận huyện, phường xã của Việt Nam
const addressData = {
    "TP.HCM": {
        districts: [
            "Quận 1", "Quận 3", "Quận 4", "Quận 5", "Quận 6", "Quận 7", "Quận 8", 
            "Quận 10", "Quận 11", "Quận 12", "Quận Bình Tân", "Quận Bình Thạnh", 
            "Quận Gò Vấp", "Quận Phú Nhuận", "Quận Tân Bình", "Quận Tân Phú", 
            "Thành phố Thủ Đức", "Huyện Bình Chánh", "Huyện Cần Giờ", 
            "Huyện Củ Chi", "Huyện Hóc Môn", "Huyện Nhà Bè"
        ],
        wards: {
            "Quận 1": ["Phường Bến Nghé", "Phường Bến Thành", "Phường Cầu Kho", "Phường Cầu Ông Lãnh", "Phường Cô Giang", "Phường Đa Kao", "Phường Nguyễn Cư Trinh", "Phường Nguyễn Thái Bình", "Phường Phạm Ngũ Lão", "Phường Tân Định"],
            "Quận 3": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14"],
            "Quận 4": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 8", "Phường 9", "Phường 10", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 18"],
            "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
            "Quận 6": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14"],
            "Quận 7": ["Phường Bình Thuận", "Phường Phú Mỹ", "Phường Phú Thuận", "Phường Tân Hưng", "Phường Tân Kiểng", "Phường Tân Phong", "Phường Tân Phú", "Phường Tân Quy", "Phường Tân Thuận Đông", "Phường Tân Thuận Tây"],
            "Quận 8": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16"],
            "Quận 10": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
            "Quận 11": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16"],
            "Quận 12": ["Phường An Phú Đông", "Phường Đông Hưng Thuận", "Phường Hiệp Thành", "Phường Tân Chánh Hiệp", "Phường Tân Hưng Thuận", "Phường Tân Thới Hiệp", "Phường Tân Thới Nhất", "Phường Thạnh Lộc", "Phường Thạnh Xuân", "Phường Thới An", "Phường Trung Mỹ Tây"],
            "Quận Bình Tân": ["Phường An Lạc", "Phường An Lạc A", "Phường Bình Hưng Hòa", "Phường Bình Hưng Hòa A", "Phường Bình Hưng Hòa B", "Phường Bình Trị Đông", "Phường Bình Trị Đông A", "Phường Bình Trị Đông B", "Phường Tân Tạo", "Phường Tân Tạo A"],
            "Quận Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 5", "Phường 6", "Phường 7", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 17", "Phường 19", "Phường 21", "Phường 22", "Phường 24", "Phường 25", "Phường 26", "Phường 27", "Phường 28"],
            "Quận Gò Vấp": ["Phường 1", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 17"],
            "Quận Phú Nhuận": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 17"],
            "Quận Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
            "Quận Tân Phú": ["Phường Hiệp Tân", "Phường Hòa Thạnh", "Phường Phú Thạnh", "Phường Phú Thọ Hòa", "Phường Phú Trung", "Phường Sơn Kỳ", "Phường Tân Qúy", "Phường Tân Sơn Nhì", "Phường Tân Thành", "Phường Tân Thới Hòa", "Phường Tây Thạnh"],
            "Thành phố Thủ Đức": ["Phường An Khánh", "Phường An Lợi Đông", "Phường An Phú", "Phường Bình Chiểu", "Phường Bình Thọ", "Phường Bình Trưng Đông", "Phường Bình Trưng Tây", "Phường Cát Lái", "Phường Hiệp Bình Chánh", "Phường Hiệp Bình Phước", "Phường Hiệp Phú", "Phường Linh Chiểu", "Phường Linh Đông", "Phường Linh Tây", "Phường Linh Trung", "Phường Linh Xuân", "Phường Long Bình", "Phường Long Phước", "Phường Long Thạnh Mỹ", "Phường Long Trường", "Phường Phú Hữu", "Phường Phước Bình", "Phường Phước Long A", "Phường Phước Long B", "Phường Tam Bình", "Phường Tam Phú", "Phường Tăng Nhơn Phú A", "Phường Tăng Nhơn Phú B", "Phường Tân Phú", "Phường Thảo Điền", "Phường Thủ Thiêm", "Phường Trường Thạnh", "Phường Trường Thọ"],
            "Huyện Bình Chánh": ["Thị trấn Tân Túc", "Xã An Phú Tây", "Xã Bình Chánh", "Xã Bình Hưng", "Xã Bình Lợi", "Xã Đa Phước", "Xã Hưng Long", "Xã Lê Minh Xuân", "Xã Phạm Văn Hai", "Xã Phong Phú", "Xã Quy Đức", "Xã Tân Kiên", "Xã Tân Nhựt", "Xã Tân Quý Tây", "Xã Vĩnh Lộc A", "Xã Vĩnh Lộc B"],
            "Huyện Cần Giờ": ["Thị trấn Cần Thạnh", "Xã An Thới Đông", "Xã Bình Khánh", "Xã Long Hòa", "Xã Lý Nhơn", "Xã Tam Thôn Hiệp", "Xã Thạnh An"],
            "Huyện Củ Chi": ["Thị trấn Củ Chi", "Xã An Nhơn Tây", "Xã An Phú", "Xã Bình Mỹ", "Xã Hòa Phú", "Xã Nhuận Đức", "Xã Phạm Văn Cội", "Xã Phú Hòa Đông", "Xã Phú Mỹ Hưng", "Xã Phước Hiệp", "Xã Phước Thạnh", "Xã Phước Vĩnh An", "Xã Tân An Hội", "Xã Tân Phú Trung", "Xã Tân Thạnh Đông", "Xã Tân Thạnh Tây", "Xã Tân Thông Hội", "Xã Thái Mỹ", "Xã Trung An", "Xã Trung Lập Hạ", "Xã Trung Lập Thượng"],
            "Huyện Hóc Môn": ["Thị trấn Hóc Môn", "Xã Bà Điểm", "Xã Đông Thạnh", "Xã Nhị Bình", "Xã Tân Hiệp", "Xã Tân Thới Nhì", "Xã Tân Xuân", "Xã Thới Tam Thôn", "Xã Trung Chánh", "Xã Xuân Thới Đông", "Xã Xuân Thới Sơn", "Xã Xuân Thới Thượng"],
            "Huyện Nhà Bè": ["Thị trấn Nhà Bè", "Xã Hiệp Phước", "Xã Long Thới", "Xã Nhơn Đức", "Xã Phú Xuân", "Xã Phước Kiển", "Xã Phước Lộc"]
        }
    },
    "Hà Nội": {
        districts: [
            "Quận Ba Đình", "Quận Bắc Từ Liêm", "Quận Cầu Giấy", "Quận Đống Đa", 
            "Quận Hà Đông", "Quận Hai Bà Trưng", "Quận Hoàn Kiếm", "Quận Hoàng Mai", 
            "Quận Long Biên", "Quận Nam Từ Liêm", "Quận Tây Hồ", "Quận Thanh Xuân", 
            "Huyện Ba Vì", "Huyện Chương Mỹ", "Huyện Đan Phượng", "Huyện Đông Anh", 
            "Huyện Gia Lâm", "Huyện Hoài Đức", "Huyện Mê Linh", "Huyện Mỹ Đức", 
            "Huyện Phú Xuyên", "Huyện Phúc Thọ", "Huyện Quốc Oai", "Huyện Sóc Sơn", 
            "Huyện Thạch Thất", "Huyện Thanh Oai", "Huyện Thanh Trì", "Huyện Thường Tín", 
            "Huyện Ứng Hòa", "Thị xã Sơn Tây"
        ],
        wards: {
            "Quận Ba Đình": ["Phường Cống Vị", "Phường Điện Biên", "Phường Đội Cấn", "Phường Giảng Võ", "Phường Kim Mã", "Phường Liễu Giai", "Phường Ngọc Hà", "Phường Ngọc Khánh", "Phường Nguyễn Trung Trực", "Phường Phúc Xá", "Phường Quán Thánh", "Phường Thành Công", "Phường Trúc Bạch", "Phường Vĩnh Phúc"],
            "Quận Bắc Từ Liêm": ["Phường Cổ Nhuế 1", "Phường Cổ Nhuế 2", "Phường Đông Ngạc", "Phường Đức Thắng", "Phường Liên Mạc", "Phường Minh Khai", "Phường Phú Diễn", "Phường Phúc Diễn", "Phường Tây Tựu", "Phường Thượng Cát", "Phường Thụy Phương", "Phường Xuân Đỉnh", "Phường Xuân Tảo"],
            "Quận Cầu Giấy": ["Phường Dịch Vọng", "Phường Dịch Vọng Hậu", "Phường Mai Dịch", "Phường Nghĩa Đô", "Phường Nghĩa Tân", "Phường Quan Hoa", "Phường Trung Hòa", "Phường Yên Hòa"],
            "Quận Đống Đa": ["Phường Cát Linh", "Phường Hàng Bột", "Phường Khâm Thiên", "Phường Khương Thượng", "Phường Kim Liên", "Phường Láng Hạ", "Phường Láng Thượng", "Phường Nam Đồng", "Phường Ngã Tư Sở", "Phường Ô Chợ Dừa", "Phường Phương Liên", "Phường Phương Mai", "Phường Quang Trung", "Phường Quốc Tử Giám", "Phường Thịnh Quang", "Phường Thổ Quan", "Phường Trung Liệt", "Phường Trung Phụng", "Phường Trung Tự", "Phường Văn Chương", "Phường Văn Miếu"],
            "Quận Hà Đông": ["Phường Biên Giang", "Phường Đồng Mai", "Phường Dương Nội", "Phường Hà Cầu", "Phường Kiến Hưng", "Phường La Khê", "Phường Mộ Lao", "Phường Nguyễn Trãi", "Phường Phú La", "Phường Phú Lãm", "Phường Phú Lương", "Phường Phúc La", "Phường Quang Trung", "Phường Vạn Phúc", "Phường Văn Quán", "Phường Yên Nghĩa", "Phường Yết Kiêu"],
            "Quận Hai Bà Trưng": ["Phường Bạch Đằng", "Phường Bách Khoa", "Phường Bạch Mai", "Phường Cầu Dền", "Phường Đống Mác", "Phường Đồng Nhân", "Phường Đồng Tâm", "Phường Lê Đại Hành", "Phường Minh Khai", "Phường Ngô Thì Nhậm", "Phường Nguyễn Du", "Phường Phạm Đình Hổ", "Phường Phố Huế", "Phường Quỳnh Lôi", "Phường Quỳnh Mai", "Phường Thanh Lương", "Phường Thanh Nhàn", "Phường Trương Định", "Phường Vĩnh Tuy"],
            "Quận Hoàn Kiếm": ["Phường Chương Dương", "Phường Cửa Đông", "Phường Cửa Nam", "Phường Đồng Xuân", "Phường Hàng Bạc", "Phường Hàng Bài", "Phường Hàng Bồ", "Phường Hàng Bông", "Phường Hàng Buồm", "Phường Hàng Đào", "Phường Hàng Gai", "Phường Hàng Mã", "Phường Hàng Trống", "Phường Lý Thái Tổ", "Phường Phan Chu Trinh", "Phường Phúc Tân", "Phường Trần Hưng Đạo", "Phường Tràng Tiền"],
            // Các phường khác của Hà Nội
        }
    },
    "Đà Nẵng": {
        districts: [
            "Quận Cẩm Lệ", "Quận Hải Châu", "Quận Liên Chiểu", "Quận Ngũ Hành Sơn", 
            "Quận Sơn Trà", "Quận Thanh Khê", "Huyện Hòa Vang", "Huyện Hoàng Sa"
        ],
        wards: {
            "Quận Cẩm Lệ": ["Phường Hòa An", "Phường Hòa Phát", "Phường Hòa Thọ Đông", "Phường Hòa Thọ Tây", "Phường Hòa Xuân", "Phường Khuê Trung"],
            "Quận Hải Châu": ["Phường Bình Hiên", "Phường Bình Thuận", "Phường Hải Châu I", "Phường Hải Châu II", "Phường Hòa Cường Bắc", "Phường Hòa Cường Nam", "Phường Hòa Thuận Đông", "Phường Hòa Thuận Tây", "Phường Nam Dương", "Phường Phước Ninh", "Phường Thạch Thang", "Phường Thanh Bình", "Phường Thuận Phước"],
            "Quận Liên Chiểu": ["Phường Hòa Hiệp Bắc", "Phường Hòa Hiệp Nam", "Phường Hòa Khánh Bắc", "Phường Hòa Khánh Nam", "Phường Hòa Minh"],
            "Quận Ngũ Hành Sơn": ["Phường Hòa Hải", "Phường Hòa Quý", "Phường Khuê Mỹ", "Phường Mỹ An"],
            "Quận Sơn Trà": ["Phường An Hải Bắc", "Phường An Hải Đông", "Phường An Hải Tây", "Phường Mân Thái", "Phường Nại Hiên Đông", "Phường Phước Mỹ", "Phường Thọ Quang"],
            "Quận Thanh Khê": ["Phường An Khê", "Phường Chính Gián", "Phường Hòa Khê", "Phường Tam Thuận", "Phường Tân Chính", "Phường Thạc Gián", "Phường Thanh Khê Đông", "Phường Thanh Khê Tây", "Phường Vĩnh Trung", "Phường Xuân Hà"],
            "Huyện Hòa Vang": ["Xã Hòa Bắc", "Xã Hòa Châu", "Xã Hòa Khương", "Xã Hòa Liên", "Xã Hòa Nhơn", "Xã Hòa Ninh", "Xã Hòa Phong", "Xã Hòa Phú", "Xã Hòa Phước", "Xã Hòa Sơn", "Xã Hòa Tiến"],
            "Huyện Hoàng Sa": []
        }
    },
    // Các tỉnh/thành phố còn lại
    "Hải Phòng": {
        districts: [
            "Quận Đồ Sơn", "Quận Dương Kinh", "Quận Hải An", "Quận Hồng Bàng", 
            "Quận Kiến An", "Quận Lê Chân", "Quận Ngô Quyền", "Huyện An Dương", 
            "Huyện An Lão", "Huyện Bạch Long Vĩ", "Huyện Cát Hải", "Huyện Kiến Thụy", 
            "Huyện Thủy Nguyên", "Huyện Tiên Lãng", "Huyện Vĩnh Bảo"
        ],
        wards: {
            "Quận Đồ Sơn": ["Phường Bàng La", "Phường Hải Sơn", "Phường Minh Đức", "Phường Ngọc Hải", "Phường Ngọc Xuyên", "Phường Vạn Hương", "Phường Vạn Sơn"],
            // Các phường khác của Hải Phòng
        }
    },
    "Cần Thơ": {
        districts: [
            "Quận Bình Thủy", "Quận Cái Răng", "Quận Ninh Kiều", "Quận Ô Môn", 
            "Quận Thốt Nốt", "Huyện Cờ Đỏ", "Huyện Phong Điền", "Huyện Thới Lai", 
            "Huyện Vĩnh Thạnh"
        ],
        wards: {
            "Quận Bình Thủy": ["Phường An Thới", "Phường Bình Thủy", "Phường Bùi Hữu Nghĩa", "Phường Long Hòa", "Phường Long Tuyền", "Phường Thới An Đông", "Phường Trà An", "Phường Trà Nóc"],
            // Các phường khác của Cần Thơ
        }
    },
    // Thêm dữ liệu cho các tỉnh/thành phố khác tương tự
};

document.addEventListener('DOMContentLoaded', function() {
    const citySelect = document.getElementById('city');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');
    
    // Khởi tạo quận/huyện ban đầu dựa trên thành phố đã chọn
    if (citySelect.value && addressData[citySelect.value]) {
        populateDistricts(citySelect.value);
    }
    
    // Khởi tạo phường/xã ban đầu dựa trên quận/huyện đã chọn
    if (districtSelect.value && citySelect.value && addressData[citySelect.value] && 
        addressData[citySelect.value].wards && addressData[citySelect.value].wards[districtSelect.value]) {
        populateWards(citySelect.value, districtSelect.value);
    }
    
    // Sự kiện khi thay đổi tỉnh/thành phố
    citySelect.addEventListener('change', function() {
        populateDistricts(this.value);
        // Reset phường/xã
        wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
    });
    
    // Sự kiện khi thay đổi quận/huyện
    districtSelect.addEventListener('change', function() {
        if (citySelect.value && this.value && 
            addressData[citySelect.value] && 
            addressData[citySelect.value].wards && 
            addressData[citySelect.value].wards[this.value]) {
            populateWards(citySelect.value, this.value);
        } else {
            // Reset phường/xã
            wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
        }
    });
    
    // Hàm cập nhật danh sách quận/huyện
    function populateDistricts(cityValue) {
        // Reset quận/huyện
        districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
        
        if (cityValue && addressData[cityValue]) {
            const districts = addressData[cityValue].districts;
            districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district;
                option.textContent = district;
                
                // Kiểm tra nếu là quận/huyện được chọn trước đó
                if (district === '<?php echo $user->district; ?>') {
                    option.selected = true;
                }
                
                districtSelect.appendChild(option);
            });
        }
    }
    
    // Hàm cập nhật danh sách phường/xã
    function populateWards(cityValue, districtValue) {
        // Reset phường/xã
        wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
        
        if (cityValue && districtValue && 
            addressData[cityValue] && 
            addressData[cityValue].wards && 
            addressData[cityValue].wards[districtValue]) {
            
            const wards = addressData[cityValue].wards[districtValue];
            wards.forEach(ward => {
                const option = document.createElement('option');
                option.value = ward;
                option.textContent = ward;
                
                // Kiểm tra nếu là phường/xã được chọn trước đó
                if (ward === '<?php echo $user->ward; ?>') {
                    option.selected = true;
                }
                
                wardSelect.appendChild(option);
            });
        }
    }
});
</script>