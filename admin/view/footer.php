<?php if (isset($_SESSION["admin"]) && $action != 'login'): ?>
            </div> <!-- container-fluid main-content -->
        </div> <!-- content-wrapper -->
        
        <footer class="bg-dark text-white py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h5>CameraVN Admin</h5>
                        <p class="small">Hệ thống quản trị của cửa hàng máy ảnh CameraVN.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">© 2025 CameraVN - Trang Quản Trị</p>
                    </div>
                </div>
            </div>
        </footer>
    </div> <!-- page-container -->
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script xử lý các sự kiện
        document.addEventListener('DOMContentLoaded', function() {
            // Đảm bảo footer luôn có khoảng cách phù hợp
            function adjustFooterPosition() {
                const contentWrapper = document.querySelector('.content-wrapper');
                const mainContent = document.querySelector('.main-content');
                const footer = document.querySelector('footer');
                
                if (contentWrapper && mainContent && footer) {
                    const windowHeight = window.innerHeight;
                    const contentHeight = mainContent.offsetHeight;
                    const navbarHeight = document.querySelector('.navbar').offsetHeight;
                    
                    // Đảm bảo content-wrapper có chiều cao tối thiểu để đẩy footer xuống
                    if (contentHeight + navbarHeight + footer.offsetHeight < windowHeight) {
                        contentWrapper.style.minHeight = (windowHeight - navbarHeight - footer.offsetHeight) + 'px';
                    }
                }
            }
            
            // Điều chỉnh vị trí footer khi trang tải xong và khi thay đổi kích thước
            adjustFooterPosition();
            window.addEventListener('resize', adjustFooterPosition);
            
            // Xử lý các nút xóa
            const deleteButtons = document.querySelectorAll('.delete-btn');
            if (deleteButtons) {
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        if (confirm('Bạn có chắc chắn muốn xóa mục này?')) {
                            window.location.href = `index.php?act=delete&id=${id}&type=${this.closest('table').id}`;
                        }
                    });
                });
            }
            
            // Tooltip initialization
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>