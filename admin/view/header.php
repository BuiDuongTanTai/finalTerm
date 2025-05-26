<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Admin - CameraVN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="view/css/style.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/ztadj9i62e8dgox15pu4w8vv1s1jgr8mcbg7w7pro5o9y0j1/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
    <?php if (isset($_SESSION["admin"]) && $action != 'login'): ?>
    <!-- Main wrapper cho layout -->
    <div class="main-wrapper">
        <!-- Navbar sticky -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <i class="bi bi-camera"></i> CameraVN Admin
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $action == 'home' ? 'active' : ''; ?>" href="index.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $action == 'cate' ? 'active' : ''; ?>" href="index.php?act=cate">
                                <i class="bi bi-folder"></i> Danh mục
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $action == 'product' ? 'active' : ''; ?>" href="index.php?act=product">
                                <i class="bi bi-box"></i> Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $action == 'order' ? 'active' : ''; ?>" href="index.php?act=order">
                                <i class="bi bi-cart"></i> Đơn hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $action == 'user' ? 'active' : ''; ?>" href="index.php?act=user">
                                <i class="bi bi-people"></i> Người dùng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $action == 'comment' ? 'active' : ''; ?>" href="index.php?act=comment">
                                <i class="bi bi-star"></i> Đánh giá
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($_GET['act'] ?? '') == 'blog_manage' ? 'active' : '' ?>" href="?act=blog_manage">
                                <i class="bi bi-newspaper"></i> Blog
                            </a>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> 
                                <?php echo isset($_SESSION['admin']['name']) ? $_SESSION['admin']['name'] : $_SESSION['admin']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="index.php?act=profile"><i class="bi bi-gear"></i> Cài đặt tài khoản</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?act=logout"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Main content area -->
        <div class="main-content">
            <div class="container-fluid">
    <?php endif; ?>