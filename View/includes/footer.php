<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <a href="index.php" class="footer-logo"><i class="bi bi-camera-fill me-2"></i>CameraVN</a>
                <p>Cung cấp các dòng máy ảnh chính hãng từ các thương hiệu hàng đầu thế giới với dịch vụ chuyên nghiệp nhất.</p>
                <div class="footer-social">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5>Thông tin</h5>
                <ul class="footer-links list-unstyled">
                    <li><a href="index.php?page=about">Về chúng tôi</a></li>
                    <li><a href="index.php?page=blog">Blog nhiếp ảnh</a></li>
                    <li><a href="#">Tuyển dụng</a></li>
                    <li><a href="index.php?page=contact">Hệ thống cửa hàng</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5>Dịch vụ khách hàng</h5>
                <ul class="footer-links list-unstyled">
                    <li><a href="#">Câu hỏi thường gặp</a></li>
                    <li><a href="#">Chính sách bảo hành</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Thông tin vận chuyển</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h5>Liên hệ</h5>
                <ul class="footer-contact-info list-unstyled">
                    <li>
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            <p>Đại học Tôn Đức Thắng, Quận 7, TP.HCM</p>
                        </div>
                    </li>
                    <li>
                        <i class="bi bi-telephone"></i>
                        <div>
                            <p>0708624193</p>
                            <p>0868212407</p>
                            <p>0945727010</p>
                        </div>
                    </li>
                    <li>
                        <i class="bi bi-envelope"></i>
                        <div>
                            <p>52300262@student.tdtu.edu.vn</p>
                            <p>52300154@student.tdtu.edu.vn</p>
                            <p>52300274@student.tdtu.edu.vn</p>
                        </div>
                    </li>
                    <li>
                        <i class="bi bi-clock"></i>
                        <div>
                            <p>Thứ 2 - Thứ 7: 8:00 - 20:00</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-6">
                    <p>Copyright © <?php echo date('Y'); ?>. Dự Án môn web CameraVN.</p>
                </div>
                <div class="col-md-6">
                    <div class="footer-bottom-links">
                        <a href="#">Chính sách riêng tư</a>
                        <a href="index.php?page=termsofuse">Điều khoản sử dụng</a>
                        <a href="#">Sơ đồ trang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Include quick actions -->
<?php include_once VIEW_PATH . '/includes/quickactions.php'; ?>

<!-- Include back to top button -->
<?php include_once VIEW_PATH . '/includes/backtotop.php'; ?>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- FancyBox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

<!-- Custom JS -->
<script src="View/assets/js/scripts.js"></script>

<script>
// Xử lý form đăng nhập và đăng ký
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý form đăng nhập
    const loginForm = document.querySelector('#loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('index.php?page=login', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Thêm class cho body để nhận biết đã đăng nhập
                    document.body.classList.add('logged-in');
                    
                    // Hiển thị thông báo
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success alert-dismissible fade show';
                    successAlert.innerHTML = `
                        ${data.message || 'Đăng nhập thành công!'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    const modalBody = loginForm.closest('.modal-body');
                    modalBody.insertBefore(successAlert, modalBody.firstChild);
                    
                    // Đóng modal sau 1 giây
                    setTimeout(() => {
                        const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                        if (loginModal) loginModal.hide();
                        
                        // Reload trang
                        window.location.reload();
                    }, 1000);
                } else {
                    // Hiển thị lỗi
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                    errorAlert.innerHTML = `
                        ${data.message || 'Đăng nhập thất bại. Vui lòng kiểm tra email và mật khẩu.'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    const modalBody = loginForm.closest('.modal-body');
                    modalBody.insertBefore(errorAlert, modalBody.firstChild);
                }
            })
            .catch(error => {
                console.error('Error during login:', error);
            });
        });
    }
    
    // Xử lý form đăng ký
    const registerForm = document.querySelector('#registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Kiểm tra mật khẩu khớp nhau
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('registerConfirmPassword').value;
            
            if (password !== confirmPassword) {
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                errorAlert.innerHTML = `
                    Mật khẩu xác nhận không khớp!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                const modalBody = registerForm.closest('.modal-body');
                modalBody.insertBefore(errorAlert, modalBody.firstChild);
                return;
            }
            
            const formData = new FormData(this);
            
            fetch('index.php?page=register', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hiển thị thông báo thành công
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success alert-dismissible fade show';
                    successAlert.innerHTML = `
                        ${data.message || 'Đăng ký thành công. Vui lòng đăng nhập.'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    const modalBody = registerForm.closest('.modal-body');
                    modalBody.insertBefore(successAlert, modalBody.firstChild);
                    
                    // Reset form
                    registerForm.reset();
                    
                    // Đóng modal đăng ký sau 1 giây
                    setTimeout(() => {
                        const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                        if (registerModal) registerModal.hide();
                        
                        // Mở modal đăng nhập
                        setTimeout(() => {
                            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                            loginModal.show();
                        }, 500);
                    }, 1000);
                } else {
                    // Hiển thị lỗi
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                    errorAlert.innerHTML = `
                        ${data.message || 'Đăng ký thất bại. Vui lòng thử lại.'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    const modalBody = registerForm.closest('.modal-body');
                    modalBody.insertBefore(errorAlert, modalBody.firstChild);
                }
            })
            .catch(error => {
                console.error('Error during registration:', error);
            });
        });
    }
});
</script>

</body>
</html>