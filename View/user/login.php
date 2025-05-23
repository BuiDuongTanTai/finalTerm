<!-- Login Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?page=login" method="post" id="login-form" class="auth-form">
                    <div class="mb-3">
                        <label for="login-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="login-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="login-password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="login-password" name="password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember-me" name="remember">
                        <label class="form-check-label" for="remember-me">Ghi nhớ đăng nhập</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </div>
                    <div class="text-center my-3">
                        <span>Hoặc đăng nhập với</span>
                    </div>
                    <div class="social-login">
                        <a href="#" class="social-login-btn facebook-btn">
                            <i class="bi bi-facebook"></i> Facebook
                        </a>
                        <a href="#" class="social-login-btn google-btn">
                            <i class="bi bi-google"></i> Google
                        </a>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <p class="mb-0">Chưa có tài khoản? <a href="#register-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>
</div>