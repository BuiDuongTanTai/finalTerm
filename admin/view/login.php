<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - CameraVN Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="View/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0143a3, #0273d4);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="View/assets/images/logo.png" alt="CameraVN Logo" class="login-logo">
            <h1>CameraVN Admin</h1>
        </div>
        <div class="login-form-container">
            <h2>Đăng Nhập</h2>
            <p class="login-subtitle">Vui lòng đăng nhập để tiếp tục</p>
            
            <?php if (isset($login_error)): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><?php echo $login_error; ?></div>
            </div>
            <?php endif; ?>
            
            <form class="login-form" action="index.php?act=login" method="post">
                <div class="form-group">
                    <label for="username">Tên đăng nhập</label>
                    <input type="email" class="form-control" id="username" name="username" placeholder="Email của bạn" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <div class="password-input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>
                
                <div class="remember-me">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                    </div>
                    <a href="#" class="forgot-password">Quên mật khẩu?</a>
                </div>
                
                <button type="submit" class="btn-login" name="btn_submit">
                    <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
                </button>
            </form>
        </div>
        <div class="login-footer">
            <p>© 2025 CameraVN - Hệ thống quản trị</p>
            <p class="d-flex align-items-center justify-content-center">
                <i class="bi bi-shield-lock me-1"></i> Bảo mật bởi SSL
            </p>
        </div>
    </div>

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.querySelector('.password-toggle i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordToggle.classList.remove('bi-eye');
            passwordToggle.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordToggle.classList.remove('bi-eye-slash');
            passwordToggle.classList.add('bi-eye');
        }
    }
    </script>
</body>
</html>