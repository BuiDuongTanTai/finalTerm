<div class="login-wrapper">
    <div class="login-container">
        <div class="login-header">
            <img src="view/images/logo.png" alt="CameraVN Logo" class="login-logo">
            <h1>CameraVN Admin</h1>
        </div>
        
        <div class="login-form-container">
            <h2>Đăng Nhập</h2>
            <p class="login-subtitle">Vui lòng đăng nhập để tiếp tục</p>
            
            <?php if (isset($login_error)): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $login_error; ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="index.php?act=login" class="login-form">
                <div class="form-group">
                    <label for="username">
                        <i class="bi bi-person-fill"></i> Tên đăng nhập
                    </label>
                    <input type="email" class="form-control" id="username" name="username" placeholder="Nhập email của bạn" required>
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="bi bi-lock-fill"></i> Mật khẩu
                    </label>
                    <div class="password-input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>
                
                <div class="form-group remember-me">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                        <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                    </div>
                    <a href="#" class="forgot-password">Quên mật khẩu?</a>
                </div>
                
                <button type="submit" name="btn_submit" class="btn btn-primary btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
                </button>
            </form>
        </div>
        
        <div class="login-footer">
            <p>© 2025 CameraVN - Hệ thống quản trị</p>
            <p><i class="bi bi-shield-lock"></i> Bảo mật bởi SSL</p>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
    }
}
</script>