<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - CameraVN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="view/css/style.css">
    <link rel="icon" href="view/images/favicon.ico" type="image/x-icon">
</head>
<body>
    <?php if (isset($_SESSION["admin"]) && $action != 'login'): ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="view/images/logo-white.png" alt="CameraVN" width="30" height="30" class="d-inline-block align-top me-2">
                CameraVN Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action == 'home') ? 'active' : ''; ?>" href="index.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action == 'cate') ? 'active' : ''; ?>" href="index.php?act=cate">
                            <i class="bi bi-list-nested"></i> Danh mục
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action == 'product') ? 'active' : ''; ?>" href="index.php?act=product">
                            <i class="bi bi-camera"></i> Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action == 'order') ? 'active' : ''; ?>" href="index.php?act=order">
                            <i class="bi bi-cart3"></i> Đơn hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action == 'user') ? 'active' : ''; ?>" href="index.php?act=user">
                            <i class="bi bi-people"></i> Khách hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action == 'comment') ? 'active' : ''; ?>" href="index.php?act=comment">
                            <i class="bi bi-chat-dots"></i> Bình luận
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> <?php echo $_SESSION["admin"]; ?>
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
    <?php endif; ?>