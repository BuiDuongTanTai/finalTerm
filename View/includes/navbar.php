<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand logo" href="index.php"><i class="bi bi-camera-fill me-2"></i>CameraVN</a>
            
            <!-- Mobile Menu Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page == 'home' ? 'active' : ''; ?>" href="index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo in_array($page, ['all_products', 'product_detail']) ? 'active' : ''; ?>" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sản phẩm <span class="mobile-arrow"><i class="bi bi-chevron-down"></i></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                            <li><a class="dropdown-item" href="index.php?page=all_products&category=dslr">Máy ảnh DSLR</a></li>
                            <li><a class="dropdown-item" href="index.php?page=all_products&category=mirrorless">Máy ảnh mirrorless</a></li>
                            <li><a class="dropdown-item" href="index.php?page=all_products&category=compact">Máy ảnh compact</a></li>
                            <li><a class="dropdown-item" href="index.php?page=all_products&category=lens">Ống kính (Lens)</a></li>
                            <li><a class="dropdown-item" href="index.php?page=all_products&category=accessory">Phụ kiện</a></li>
                            <li><a class="dropdown-item" href="index.php?page=all_products">Tất cả</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="brandsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Loại hãng <span class="mobile-arrow"><i class="bi bi-chevron-down"></i></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="brandsDropdown">
                            <li><a class="dropdown-item" href="index.php?page=all_products&brand=canon">Canon</a></li>
                            <li><a class="dropdown-item" href="index.php?page=all_products&brand=sony">Sony</a></li>
                            <li><a class="dropdown-item" href="index.php?page=all_products&brand=nikon">Nikon</a></li>
                            <li><a class="dropdown-item" href="index.php?page=all_products&brand=fujifilm">Fujifilm</a></li>
                            <li><a class="dropdown-item" href="index.php?page=all_products&brand=panasonic">Panasonic</a></li>
                            <li><a class="dropdown-item" href="index.php?page=all_products&brand=leica">Leica</a></li>
                            <li><a class="dropdown-item" href="index.php?page=all_products&brand=other">Khác</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dịch vụ <span class="mobile-arrow"><i class="bi bi-chevron-down"></i></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item" href="index.php?page=blog">Blog nhiếp ảnh</a></li>
                            <li><a class="dropdown-item" href="index.php?page=service-rental">Cho thuê thiết bị</a></li>
                            <li><a class="dropdown-item" href="index.php?page=service-repair">Sửa chữa & Bảo dưỡng</a></li>
                            <li><a class="dropdown-item" href="index.php?page=service-training">Đào tạo nhiếp ảnh</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page == 'about' ? 'active' : ''; ?>" href="index.php?page=about">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page == 'contact' ? 'active' : ''; ?>" href="index.php?page=contact">Liên hệ</a>
                    </li>
                </ul>
                
                <!-- Desktop Search -->
                <div class="d-none d-lg-block">
                    <form class="search-container" method="get" action="index.php">
                        <input type="hidden" name="page" value="all_products">
                        <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                        <button class="btn search-btn" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </div>
                
                <!-- Thêm class logged-in cho body khi đã đăng nhập -->
                <?php if(isset($_SESSION['user_id'])): ?>
                <script>document.body.classList.add('logged-in');</script>
                <?php endif; ?>
                
                <!-- Nav Buttons Desktop -->
                <div class="nav-buttons d-none d-lg-flex">
                    <button class="theme-toggle" id="themeToggle" title="Chuyển chế độ tối/sáng">
                        <i class="bi bi-sun-fill"></i>
                    </button>
                    
                    <a href="#" class="btn position-relative me-2" id="cartButton" data-bs-toggle="modal" data-bs-target="#cart-modal">
                        <i class="bi bi-cart"></i>
                        <span class="cart-count">
                            <?php 
                                if (isset($_SESSION['user_id'])) {
                                    require_once 'Model/CartModel.php';
                                    $cartModel = new CartModel();
                                    echo $cartModel->countCartItems($_SESSION['user_id']);
                                } elseif (isset($_SESSION['cart_id'])) {
                                    require_once 'Model/CartModel.php';
                                    $cartModel = new CartModel();
                                    echo $cartModel->countCartItems(null, $_SESSION['cart_id']);
                                } else {
                                    echo 0;
                                }
                            ?>
                        </span>
                    </a>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <a href="#" class="btn btn-primary dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                                $userName = $_SESSION['user_name'];
                                $nameParts = explode(' ', $userName);
                                $displayName = (count($nameParts) >= 2) ? $nameParts[0] . ' ' . $nameParts[1] : $userName;
                                $initials = '';
                                foreach ($nameParts as $part) {
                                    $initials .= substr($part, 0, 1);
                                }
                                $initials = substr($initials, 0, 2);
                            ?>
                            <span class="d-none d-md-inline me-2">Xin chào, <?php echo $displayName; ?>!</span>
                            <span class="badge bg-white text-primary rounded-circle" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;"><?php echo $initials; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="index.php?page=profile"><i class="bi bi-person-circle me-2"></i>Tài khoản của tôi</a></li>
                            <li><a class="dropdown-item" href="index.php?page=wishlist"><i class="bi bi-heart me-2"></i>Sản phẩm yêu thích</a></li>
                            <li><a class="dropdown-item" href="index.php?page=profile#orders"><i class="bi bi-bag me-2"></i>Đơn hàng của tôi</a></li>
                            <li><hr class="dropdown-divider"></li>
<li><a class="dropdown-item" href="index.php?page=logout"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                    <?php else: ?>
                    <button class="btn btn-primary" id="loginButton" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="bi bi-person me-1"></i> Đăng nhập
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Mobile Search & Buttons -->
            <div class="d-lg-none mt-3 w-100">
                <form class="search-container mb-2" method="get" action="index.php">
                    <input type="hidden" name="page" value="all_products">
                    <input class="form-control" type="search" name="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                    <button class="btn search-btn" type="submit"><i class="bi bi-search"></i></button>
                </form>
                
                <div class="nav-buttons d-flex justify-content-between">
                    <button class="btn btn-outline-secondary" id="mobileThemeToggle">
                        <i class="bi bi-moon-fill"></i> Chế độ tối
                    </button>
                    
                    <a href="#" class="btn btn-outline-primary position-relative" id="mobileCartButton" data-bs-toggle="modal" data-bs-target="#cart-modal">
                        <i class="bi bi-cart me-1"></i> Giỏ hàng
                        <span class="cart-count">
                            <?php 
                                if (isset($_SESSION['user_id'])) {
                                    require_once 'Model/CartModel.php';
                                    $cartModel = new CartModel();
                                    echo $cartModel->countCartItems($_SESSION['user_id']);
                                } elseif (isset($_SESSION['cart_id'])) {
                                    require_once 'Model/CartModel.php';
                                    $cartModel = new CartModel();
                                    echo $cartModel->countCartItems(null, $_SESSION['cart_id']);
                                } else {
                                    echo 0;
                                }
                            ?>
                        </span>
                    </a>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="index.php?page=profile" class="btn btn-primary" id="mobileLoginButton">
                        <?php
                            $userName = $_SESSION['user_name'];
                            $nameParts = explode(' ', $userName);
                            $initials = '';
                            foreach ($nameParts as $part) {
                                $initials .= substr($part, 0, 1);
                            }
                            $initials = substr($initials, 0, 2);
                        ?>
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="me-2">Xin chào!</span>
                            <span class="badge bg-white text-primary rounded-circle" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem;"><?php echo $initials; ?></span>
                        </div>
                    </a>
                    <?php else: ?>
                    <button class="btn btn-primary" id="mobileLoginButton" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="bi bi-person me-1"></i> Đăng nhập
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Include Modal Components -->
<?php include 'View/includes/navbarcart.php'; ?>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                
                <form action="index.php?page=login" method="post" class="auth-form" id="loginForm">
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Địa chỉ email</label>
                        <input type="email" class="form-control" id="loginEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="loginRemember" name="remember">
                        <label class="form-check-label" for="loginRemember">Ghi nhớ đăng nhập</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </div>
                    <div class="text-center my-3">
                        <a href="#" class="text-decoration-none small">Quên mật khẩu?</a>
                    </div>
                </form>
                
                <div class="social-login">
                    <p class="text-center mb-3">Hoặc đăng nhập với</p>
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-outline-primary"><i class="bi bi-facebook me-2"></i>Facebook</button>
                        <button class="btn btn-outline-danger"><i class="bi bi-google me-2"></i>Google</button>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p class="mb-0">Chưa có tài khoản? <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Đăng ký ngay</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Đăng ký tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?page=register" method="post" class="auth-form" id="registerForm">
                    <div class="mb-3">
                        <label for="registerName" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="registerName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="registerEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerPhone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="registerPhone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="registerPassword" name="password" required minlength="6">
                    </div>
                    <div class="mb-3">
                        <label for="registerConfirmPassword" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="registerConfirmPassword" name="confirm_password" required minlength="6">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="registerTerms" required>
                        <label class="form-check-label" for="registerTerms">
                            Tôi đồng ý với <a href="index.php?page=termsofuse" target="_blank" class="text-decoration-none">điều khoản sử dụng</a>
                        </label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <p class="mb-0">Đã có tài khoản? <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Đăng nhập</a></p>
                </div>
            </div>
        </div>
    </div>
</div>