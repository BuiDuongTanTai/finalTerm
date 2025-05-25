<main>
    <!-- Page Header -->
    <section class="page-header py-5 mb-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white fw-bold mb-3">Tài Khoản Của Tôi</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="index.php" class="text-white-50">Trang chủ</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Tài khoản</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Profile Section -->
    <section class="profile-section pb-5">
        <div class="container">
            <!-- Alert Messages -->
            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
        
            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body text-center py-4">
                            <div class="position-relative d-inline-block mb-3">
                                <?php 
                                $avatarPath = !empty($user->avatar) ? $user->avatar : 'View/assets/images/uploads/users/default-avatar.png';
                                ?>
                                <img src="<?php echo $avatarPath; ?>" 
                                     alt="Avatar" 
                                     class="rounded-circle border border-3 border-primary" 
                                     width="120" 
                                     height="120"
                                     style="object-fit: cover;">
                                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 border border-3 border-white">
                                    <i class="bi bi-check text-white"></i>
                                </span>
                            </div>
                            <h5 class="mb-1"><?php echo htmlspecialchars($user->name); ?></h5>
                            <p class="text-muted small mb-0"><?php echo htmlspecialchars($user->email); ?></p>
                            <?php if($user->phone): ?>
                            <p class="text-muted small mb-0"><i class="bi bi-phone me-1"></i><?php echo htmlspecialchars($user->phone); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action active" data-bs-toggle="list" data-bs-target="#profile-info">
                                <i class="bi bi-person-circle me-2"></i>Thông tin cá nhân
                            </a>
                            <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="list" data-bs-target="#orders">
                                <i class="bi bi-bag-check me-2"></i>Đơn hàng
                                <?php if(isset($orderCount) && $orderCount > 0): ?>
                                <span class="badge bg-primary rounded-pill float-end"><?php echo $orderCount; ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="list" data-bs-target="#addresses">
                                <i class="bi bi-geo-alt me-2"></i>Địa chỉ giao hàng
                            </a>
                            <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="list" data-bs-target="#change-password">
                                <i class="bi bi-shield-lock me-2"></i>Đổi mật khẩu
                            </a>
                            <a href="index.php?page=wishlist" class="list-group-item list-group-item-action">
                                <i class="bi bi-heart me-2"></i>Yêu thích
                                <?php if(isset($wishlistCount) && $wishlistCount > 0): ?>
                                <span class="badge bg-danger rounded-pill float-end"><?php echo $wishlistCount; ?></span>
                                <?php endif; ?>
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
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white py-3 px-4">
                                    <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Thông tin cá nhân</h5>
                                </div>
                                <div class="card-body p-4">
                                    <form action="index.php?page=update_profile" method="post" enctype="multipart/form-data" id="profileForm">
                                        <!-- Avatar Upload -->
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Ảnh đại diện</label>
                                                <div class="d-flex align-items-center gap-4">
                                                    <img src="<?php echo $avatarPath; ?>" 
                                                         alt="Avatar" 
                                                         class="rounded-circle border" 
                                                         width="100" 
                                                         height="100"
                                                         id="avatarPreview"
                                                         style="object-fit: cover;">
                                                    <div>
                                                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*" style="display: none;">
                                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('avatar').click();">
                                                            <i class="bi bi-upload me-1"></i>Tải ảnh lên
                                                        </button>
                                                        <p class="text-muted small mb-0 mt-2">JPG, PNG hoặc GIF. Tối đa 2MB</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Personal Information -->
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user->name); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" value="<?php echo htmlspecialchars($user->email); ?>" readonly style="background-color: #f8f9fa;">
                                                <small class="text-muted">Email không thể thay đổi</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Số điện thoại</label>
                                                <input type="tel" class="form-control" name="phone" value="<?php echo htmlspecialchars($user->phone ?? ''); ?>" pattern="[0-9]{10}" placeholder="0123456789">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Ngày sinh</label>
                                                <input type="date" class="form-control" name="birthday" value="<?php echo $user->birthday ?? ''; ?>">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Giới tính</label>
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?php echo ($user->gender ?? '') == 'male' ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="male">Nam</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?php echo ($user->gender ?? '') == 'female' ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="female">Nữ</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gender" id="other" value="other" <?php echo ($user->gender ?? '') == 'other' ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="other">Khác</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <hr class="my-4">
                                        
                                        <!-- Address Information -->
                                        <h6 class="mb-3">Địa chỉ mặc định</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">Địa chỉ</label>
                                                <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($user->address ?? ''); ?>" placeholder="Số nhà, tên đường...">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Tỉnh/Thành phố</label>
                                                <select class="form-select" id="province" name="city">
                                                    <option value="">Chọn tỉnh/thành phố</option>
                                                    <?php
                                                    // Lấy danh sách tỉnh/thành phố từ database
                                                    $provinces = $db->query("SELECT * FROM provinces ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($provinces as $province):
                                                    ?>
                                                    <option value="<?php echo $province['name']; ?>" data-id="<?php echo $province['id']; ?>" 
                                                            <?php echo ($user->city ?? '') == $province['name'] ? 'selected' : ''; ?>>
                                                        <?php echo $province['name']; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Quận/Huyện</label>
                                                <select class="form-select" id="district" name="district" disabled>
                                                    <option value="">Chọn quận/huyện</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Phường/Xã</label>
                                                <select class="form-select" id="ward" name="ward" disabled>
                                                    <option value="">Chọn phường/xã</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-circle me-2"></i>Lưu thay đổi
                                            </button>
                                            <button type="reset" class="btn btn-light ms-2">
                                                <i class="bi bi-arrow-clockwise me-2"></i>Đặt lại
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>