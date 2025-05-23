document.addEventListener('DOMContentLoaded', function() {
    // Loader - Hiệu ứng tải trang
    const loader = document.querySelector('.loader-wrapper');
    if (loader) {
        // Đảm bảo trang đã tải xong
        window.addEventListener('load', function() {
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 1000);
        });
    }
    
    // Dark Mode Toggle - Kiểm tra tồn tại trước khi thêm event listener
    const themeToggle = document.getElementById('themeToggle');
    const mobileThemeToggle = document.getElementById('mobileThemeToggle');
    const savedTheme = localStorage.getItem('theme') || 'light';
    
    // Hàm cập nhật trạng thái theme
    function updateThemeState(isDark) {
        if (isDark) {
            document.body.classList.add('dark-theme');
            localStorage.setItem('theme', 'dark');
            
            // Cập nhật nút toggle desktop
            if (themeToggle) {
                themeToggle.innerHTML = '<i class="bi bi-moon-fill"></i>';
                themeToggle.setAttribute('title', 'Chuyển sang chế độ sáng');
            }
            
            // Cập nhật nút toggle mobile
            if (mobileThemeToggle) {
                mobileThemeToggle.innerHTML = '<i class="bi bi-sun-fill me-2"></i>Chế độ sáng';
            }
            
            // Thêm class cho các bảng trong dark mode
            document.querySelectorAll('.table').forEach(table => {
                table.classList.add('table-dark');
            });
        } else {
            document.body.classList.remove('dark-theme');
            localStorage.setItem('theme', 'light');
            
            // Cập nhật nút toggle desktop
            if (themeToggle) {
                themeToggle.innerHTML = '<i class="bi bi-sun-fill"></i>';
                themeToggle.setAttribute('title', 'Chuyển sang chế độ tối');
            }
            
            // Cập nhật nút toggle mobile
            if (mobileThemeToggle) {
                mobileThemeToggle.innerHTML = '<i class="bi bi-moon-fill me-2"></i>Chế độ tối';
            }
            
            // Loại bỏ class cho các bảng
            document.querySelectorAll('.table').forEach(table => {
                table.classList.remove('table-dark');
            });
        }
    }
    
    // Thiết lập trạng thái ban đầu
    updateThemeState(savedTheme === 'dark');
    
    // Xử lý click trên nút toggle desktop
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const isDarkNow = document.body.classList.contains('dark-theme');
            updateThemeState(!isDarkNow);
        });
    }
    
    // Xử lý click trên nút toggle mobile
    if (mobileThemeToggle) {
        mobileThemeToggle.addEventListener('click', function() {
            const isDarkNow = document.body.classList.contains('dark-theme');
            updateThemeState(!isDarkNow);
        });
    }
    
    // FancyBox Initialization - kiểm tra tồn tại trước khi khởi tạo
    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox]', {
            // Your custom options
        });
    }
    
    // Swiper Initialization - kiểm tra từng swiper trước khi khởi tạo
    
    // Hero Swiper
    const heroSwiperElement = document.querySelector('.hero-swiper');
    if (heroSwiperElement && typeof Swiper !== 'undefined') {
        const heroSwiper = new Swiper('.hero-swiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.hero-swiper .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.hero-swiper .swiper-button-next',
                prevEl: '.hero-swiper .swiper-button-prev',
            },
        });
    }
    
    // Testimonial Swiper
    const testimonialSwiperElement = document.querySelector('.testimonial-swiper');
    if (testimonialSwiperElement && typeof Swiper !== 'undefined') {
        const testimonialSwiper = new Swiper('.testimonial-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.testimonial-swiper .swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    }
    
    // Testimonial Service Swiper
    const testimonialServiceSwiperElement = document.querySelector('.testimonial-service-swiper');
    if (testimonialServiceSwiperElement && typeof Swiper !== 'undefined') {
        const testimonialServiceSwiper = new Swiper('.testimonial-service-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.testimonial-service-swiper .swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    }
    
    // Countdown Timer Functionality
    function updateCountdown() {
        // Set end date (example: 15 days from now)
        const endDate = new Date();
        endDate.setDate(endDate.getDate() + 15);
        
        function update() {
            const now = new Date();
            const diff = endDate - now;
            
            if (diff <= 0) {
                document.getElementById('days').textContent = '00';
                document.getElementById('hours').textContent = '00';
                document.getElementById('minutes').textContent = '00';
                document.getElementById('seconds').textContent = '00';
                return;
            }
            
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            if (document.getElementById('days')) {
                document.getElementById('days').textContent = days < 10 ? `0${days}` : days;
            }
            if (document.getElementById('hours')) {
                document.getElementById('hours').textContent = hours < 10 ? `0${hours}` : hours;
            }
            if (document.getElementById('minutes')) {
                document.getElementById('minutes').textContent = minutes < 10 ? `0${minutes}` : minutes;
            }
            if (document.getElementById('seconds')) {
                document.getElementById('seconds').textContent = seconds < 10 ? `0${seconds}` : seconds;
            }
        }
        
        update();
        setInterval(update, 1000);
    }
    
    // Run countdown when page loads if countdown elements exist
    if (document.getElementById('days') || document.getElementById('hours')) {
        updateCountdown();
    }
    
    // Add number animation when hovering countdown boxes
    document.querySelectorAll('.countdown-box').forEach(box => {
        box.addEventListener('mouseenter', function() {
            const number = this.querySelector('.countdown-number');
            if (number) {
                number.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    number.style.transform = 'scale(1)';
                }, 300);
            }
        });
    });
    
    // Product Thumbs Swiper
    const productThumbsSwiperElement = document.querySelector('.product-thumbs-swiper');
    let productThumbsSwiper;
    if (productThumbsSwiperElement && typeof Swiper !== 'undefined') {
        productThumbsSwiper = new Swiper('.product-thumbs-swiper', {
            slidesPerView: 4,
            spaceBetween: 10,
            freeMode: true,
            watchSlidesProgress: true
        });
    }

    // Product Main Swiper
    const productMainSwiperElement = document.querySelector('.product-main-swiper');
    if (productMainSwiperElement && typeof Swiper !== 'undefined') {
        var productMainSwiper = new Swiper('.product-main-swiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            navigation: {
                nextEl: '.product-main-swiper .swiper-button-next',
                prevEl: '.product-main-swiper .swiper-button-prev',
            },
            thumbs: {
                swiper: productThumbsSwiper
            }
        });
    }
    
    // Back to Top Button
    const backToTopButton = document.getElementById('backToTop');
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('active');
            } else {
                backToTopButton.classList.remove('active');
            }
        });
        
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Scroll to Top Function
    window.scrollToTop = function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };
    
    // Xử lý dropdown menu cho desktop và mobile
    function setupNavigationBehavior() {
        const isDesktop = window.innerWidth >= 992;
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        
        // Nếu không có dropdown toggle, không cần thực hiện hàm
        if (dropdownToggles.length === 0) return;
        
        // Xóa tất cả event listeners hiện tại trên dropdown toggles
        dropdownToggles.forEach(toggle => {
            try {
                const newToggle = toggle.cloneNode(true);
                if (toggle.parentNode) {
                    toggle.parentNode.replaceChild(newToggle, toggle);
                }
            } catch (error) {
                console.log('Lỗi khi clone dropdown toggle: ', error);
            }
        });
        
        // Lấy lại danh sách toggles sau khi clone
        const refreshedToggles = document.querySelectorAll('.dropdown-toggle');
        
        if (isDesktop) {
            // DESKTOP BEHAVIOR
            // Ngăn chặn hành vi mặc định của Bootstrap khi click trên desktop
            refreshedToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                });
                
                // Parent là phần tử li chứa dropdown
                const parent = toggle.closest('.dropdown');
                if (!parent) return; // Kiểm tra parent tồn tại
                
                // Sự kiện hover
                parent.addEventListener('mouseenter', function() {
                    const dropdownMenu = this.querySelector('.dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.classList.add('show');
                        toggle.setAttribute('aria-expanded', 'true');
                    }
                });
                
                parent.addEventListener('mouseleave', function() {
                    const dropdownMenu = this.querySelector('.dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.classList.remove('show');
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                });
            });
            
            // Ngăn click bên ngoài đóng dropdown trên desktop
            document.addEventListener('click', function(e) {
                if (e.target.closest('.dropdown-menu')) {
                    e.stopPropagation();
                }
            });
        } else {
            // MOBILE BEHAVIOR
            refreshedToggles.forEach(toggle => {
                // Thêm ID để theo dõi dropdown đang mở
                const dropdownMenu = toggle.nextElementSibling;
                if (!dropdownMenu) return; // Kiểm tra menu tồn tại
                
                const uniqueId = toggle.id || `dropdown-${Math.random().toString(36).substr(2, 9)}`;
                toggle.id = uniqueId;
                dropdownMenu.setAttribute('data-parent', uniqueId);
                
                // Thêm style cho rõ ràng trên mobile
                dropdownMenu.style.transition = 'max-height 0.3s ease-in-out, opacity 0.3s ease-in-out';
                dropdownMenu.style.maxHeight = '0';
                dropdownMenu.style.overflow = 'hidden';
                dropdownMenu.style.display = 'block';
                dropdownMenu.style.opacity = '0';
                
                // Tạo icon mũi tên phụ (nếu chưa có)
                if (!toggle.querySelector('.mobile-arrow')) {
                    const arrow = document.createElement('span');
                    arrow.className = 'mobile-arrow ms-2';
                    arrow.innerHTML = '<i class="bi bi-chevron-down"></i>';
                    arrow.style.transition = 'transform 0.3s ease';
                    toggle.appendChild(arrow);
                }
                
                // Xử lý click trên mobile
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const menu = this.nextElementSibling;
                    if (!menu) return; // Kiểm tra menu tồn tại
                    
                    const isOpen = menu.style.maxHeight !== '0px' && menu.style.maxHeight !== '';
                    const arrow = this.querySelector('.mobile-arrow');
                    
                    // Đóng tất cả các dropdown khác
                    document.querySelectorAll('.dropdown-menu').forEach(otherMenu => {
                        if (otherMenu !== menu && otherMenu.style.maxHeight !== '0px') {
                            otherMenu.style.maxHeight = '0';
                            otherMenu.style.opacity = '0';
                            
                            // Reset mũi tên của dropdown khác
                            const otherToggle = document.getElementById(otherMenu.getAttribute('data-parent'));
                            if (otherToggle) {
                                const otherArrow = otherToggle.querySelector('.mobile-arrow');
                                if (otherArrow) otherArrow.style.transform = 'rotate(0deg)';
                                otherToggle.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });
                    
                    // Toggle dropdown hiện tại
                    if (isOpen) {
                        menu.style.maxHeight = '0';
                        menu.style.opacity = '0';
                        if (arrow) arrow.style.transform = 'rotate(0deg)';
                        this.setAttribute('aria-expanded', 'false');
                    } else {
                        // Tính toán chiều cao thực tế của menu
                        menu.style.maxHeight = 'none'; // Tạm thời bỏ giới hạn để đo
                        const height = menu.scrollHeight;
                        menu.style.maxHeight = '0'; // Reset lại trước khi animate
                        
                        // Trigger reflow để animation hoạt động
                        menu.offsetHeight;
                        
                        // Mở menu với animation
                        menu.style.maxHeight = `${height}px`;
                        menu.style.opacity = '1';
                        if (arrow) arrow.style.transform = 'rotate(180deg)';
                        this.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        }
    }
    
    // Thiết lập hành vi ban đầu và khi thay đổi kích thước
    setupNavigationBehavior();
    window.addEventListener('resize', function() {
        setupNavigationBehavior();
        
        // Reset các dropdown khi chuyển đổi giữa desktop và mobile
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.style = '';
            menu.classList.remove('show');
        });
        
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.setAttribute('aria-expanded', 'false');
        });
    });

    // Khởi tạo AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }
    
    // Cart Logic - với kiểm tra đầy đủ
    let cart = [];
    const cartItemsContainer = document.getElementById('cart-items');
    const totalPriceElement = document.getElementById('total-price');
    const checkoutButton = document.getElementById('checkout');
    const cartCountElements = document.querySelectorAll('.cart-count');
    let isLoggedIn = false; // Biến kiểm tra trạng thái đăng nhập
    
    // Kiểm tra trạng thái đăng nhập từ PHP session
    if (document.body.classList.contains('logged-in')) {
        isLoggedIn = true;
    }
    
    // Cập nhật số lượng hiển thị trên icon giỏ hàng
    function updateCartCount() {
        // Đầu tiên lấy số lượng từ API
        fetch('index.php?page=ajax_cart_count')
        .then(response => response.json())
        .then(data => {
            const totalItems = data.count || 0;
            cartCountElements.forEach(element => {
                element.textContent = totalItems;
            });
        })
        .catch(error => {
            console.error('Error fetching cart count:', error);
            // Fallback: sử dụng logic client side nếu API lỗi
            const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
            cartCountElements.forEach(element => {
                element.textContent = totalItems;
            });
        });
    }
    
    // Cập nhật giỏ hàng từ API khi trang tải
    function loadCart() {
        fetch('index.php?page=ajax_cart')
        .then(response => response.json())
        .then(data => {
            cart = data.items || [];
            updateCart();
        })
        .catch(error => {
            console.error('Error loading cart:', error);
        });
    }
    
    // Cập nhật hiển thị giỏ hàng
    function updateCart() {
        if (!cartItemsContainer) return;
        
        cartItemsContainer.innerHTML = '';
        let totalPrice = 0;
        
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<tr id="empty-cart"><td colspan="5" class="text-center">Giỏ hàng của bạn đang trống.</td></tr>';
            if (checkoutButton) checkoutButton.disabled = true;
        } else {
            cart.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="cart-thumbnail me-3" style="background-image: url('${item.image_url}');"></div>
                            <div>
                                <h6 class="cart-product-title">${item.name}</h6>
                                <small class="text-muted">${item.options ? formatOptions(item.options) : ''}</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end cart-product-price">${formatPrice(item.price)}đ</td>
                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <button type="button" class="quantity-btn" onclick="updateCartItemQuantity(${item.id}, -1)">-</button>
                            <input type="text" class="form-control cart-quantity-input" value="${item.quantity}" readonly>
                            <button type="button" class="quantity-btn" onclick="updateCartItemQuantity(${item.id}, 1)">+</button>
                        </div>
                    </td>
                    <td class="text-end cart-product-price">${formatPrice(item.price * item.quantity)}đ</td>
                    <td class="text-center">
                        <button type="button" class="cart-remove-btn" onclick="removeCartItem(${item.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                cartItemsContainer.appendChild(row);
                totalPrice += item.price * item.quantity;
            });
            if (checkoutButton) checkoutButton.disabled = false;
        }
        
        if (totalPriceElement) totalPriceElement.textContent = formatPrice(totalPrice) + 'đ';
        updateCartCount();
    }
    
    // Format giá tiền
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price);
    }
    
    // Format options
    function formatOptions(options) {
        if (!options) return '';
        
        try {
            const optionsObj = typeof options === 'string' ? JSON.parse(options) : options;
            let optionText = [];
            
            for (const key in optionsObj) {
                if (optionsObj.hasOwnProperty(key)) {
                    optionText.push(`${ucfirst(key)}: ${optionsObj[key]}`);
                }
            }
            
            return optionText.join(', ');
        } catch (e) {
            console.error('Error parsing options:', e);
            return '';
        }
    }
    
    // Hàm viết hoa chữ cái đầu
    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
    
    // Thêm hàm cập nhật số lượng sản phẩm vào window object
    window.updateCartItemQuantity = function(cartId, change) {
        if (!isLoggedIn) {
            showLoginModal();
            return;
        }
        
        fetch('index.php?page=update_cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `cart_id=${cartId}&quantity=${change}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật giỏ hàng
                loadCart();
                
                // Cập nhật tổng tiền
                if (totalPriceElement && data.total_amount) {
                    totalPriceElement.textContent = data.total_amount;
                }
            } else {
                alert(data.message || 'Có lỗi xảy ra khi cập nhật giỏ hàng');
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
        });
    };
    
    // Thêm hàm xóa sản phẩm vào window object
    window.removeCartItem = function(cartId) {
        if (!isLoggedIn) {
            showLoginModal();
            return;
        }
        
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            fetch('index.php?page=remove_from_cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `cart_id=${cartId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật giỏ hàng
                    loadCart();
                    
                    // Cập nhật tổng tiền
                    if (totalPriceElement && data.total_amount) {
                        totalPriceElement.textContent = data.total_amount;
                    }
                } else {
                    alert(data.message || 'Có lỗi xảy ra khi xóa sản phẩm');
                }
            })
            .catch(error => {
                console.error('Error removing cart item:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
            });
        }
    };
    
    // Xử lý nút xóa giỏ hàng
    const clearCartButton = document.getElementById('clear-cart');
    if (clearCartButton) {
        clearCartButton.addEventListener('click', function() {
            if (!isLoggedIn) {
                showLoginModal();
                return;
            }
            
            if (cart.length > 0) {
                if (confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm khỏi giỏ hàng?')) {
                    fetch('index.php?page=clear_cart', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            cart = [];
                            updateCart();
                        } else {
                            alert(data.message || 'Có lỗi xảy ra khi xóa giỏ hàng');
                        }
                    })
                    .catch(error => {
                        console.error('Error clearing cart:', error);
                        alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                    });
                }
            }
        });
    }
    
    // Xử lý nút thanh toán
    if (checkoutButton) {
        checkoutButton.addEventListener('click', function() {
            if (!isLoggedIn) {
                showLoginModal();
                return;
            }
            
            if (cart.length > 0) {
                window.location.href = 'index.php?page=checkout';
            }
        });
    }
    
    // Hiển thị modal đăng nhập
    window.showLoginModal = function() {
        // Đóng cart modal và đảm bảo xóa tất cả các phần tử còn sót lại
        const cartModalElement = document.getElementById('cart-modal');
        if (cartModalElement) {
            // Đóng modal bằng Bootstrap API
            const cartModal = bootstrap.Modal.getInstance(cartModalElement);
            if (cartModal) {
                cartModal.hide();
            }
            
            // Xóa hoàn toàn các phần tử modal và backdrop
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            
            // Đóng modal giỏ hàng bằng cách xóa các class và ẩn nó
            cartModalElement.classList.remove('show');
            cartModalElement.style.display = 'none';
            cartModalElement.setAttribute('aria-hidden', 'true');
            
            // Đợi 300ms để đảm bảo modal đã đóng hoàn toàn
            setTimeout(() => {
                // Mở modal đăng nhập
                const loginModalElement = document.getElementById('loginModal');
                if (loginModalElement) {
                    // Đảm bảo modal login không có class show và style display
                    loginModalElement.classList.remove('show');
                    loginModalElement.style.display = 'none';
                    
                    // Tạo mới instance modal và hiển thị
                    const loginModal = new bootstrap.Modal(loginModalElement);
                    loginModal.show();
                }
            }, 300);
        } else {
            // Xóa backdrop nếu có
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            
            // Mở trực tiếp modal đăng nhập
            const loginModalElement = document.getElementById('loginModal');
            if (loginModalElement) {
                const loginModal = new bootstrap.Modal(loginModalElement);
                loginModal.show();
            }
        }
    };
    
    // Product filtering
    const filterButtons = document.querySelectorAll('.product-filter-btn');
    const productItems = document.querySelectorAll('.product-item');

    if (filterButtons.length > 0 && productItems.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get filter value
                const filterValue = this.getAttribute('data-filter');
                
                // Filter products
                productItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                        // Add fade-in animation
                        item.classList.add('fade-in');
                        setTimeout(() => {
                            item.classList.remove('fade-in');
                        }, 500);
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }
    
    // Xử lý wishlist functionality
    function setupWishlistButtons() {
        document.querySelectorAll('.product-wishlist-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (!isLoggedIn) {
                    showLoginModal();
                    return;
                }
                
                const productId = this.getAttribute('data-product-id');
                const isActive = this.classList.contains('active');
                const isWishlistPage = window.location.href.includes('page=wishlist');
                
                fetch(isActive ? 'index.php?page=remove_from_wishlist' : 'index.php?page=add_to_wishlist', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `product_id=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Toggle active class
                        this.classList.toggle('active');
                        
                        // Update wishlist count
                        const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                        wishlistCountElements.forEach(element => {
                            let count = parseInt(element.textContent || '0');
                            if (isActive) {
                                count = Math.max(0, count - 1);
                            } else {
                                count++;
                            }
                            element.textContent = count;
                        });
                        
                        // Nếu đang ở trang wishlist và xóa sản phẩm khỏi wishlist
                        if (isWishlistPage && isActive) {
                            // Tìm phần tử cha cần xóa (thẻ col chứa sản phẩm)
                            const productCard = this.closest('.col-md-6, .col-lg-4, .col-xl-3');
                            
                            if (productCard) {
                                // Thêm class fade-out để tạo hiệu ứng
                                productCard.style.opacity = '0';
                                productCard.style.transform = 'scale(0.8)';
                                productCard.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                                
                                // Sau khi animation hoàn thành, xóa phần tử
                                setTimeout(() => {
                                    productCard.remove();
                                    
                                    // Kiểm tra nếu không còn sản phẩm nào trong wishlist
                                    const remainingProducts = document.querySelectorAll('.product-card');
                                    if (remainingProducts.length === 0) {
                                        // Hiển thị thông báo danh sách trống
                                        const container = document.querySelector('.container');
                                        if (container) {
                                            const rowElement = container.querySelector('.row');
                                            if (rowElement) {
                                                rowElement.innerHTML = '';
                                            }
                                            
                                            const emptyWishlist = document.createElement('div');
                                            emptyWishlist.className = 'text-center py-5';
                                            emptyWishlist.innerHTML = `
                                                <div class="mb-4">
                                                    <i class="bi bi-heart" style="font-size: 5rem; color: #e0e0e0;"></i>
                                                </div>
                                                <h3>Danh sách yêu thích trống</h3>
                                                <p class="text-muted mb-4">Bạn chưa thêm sản phẩm nào vào danh sách yêu thích</p>
                                                <a href="index.php?page=all_products" class="btn btn-primary">
                                                    <i class="bi bi-shop me-2"></i>Khám phá sản phẩm
                                                </a>
                                            `;
                                            
                                            // Thêm vào container
                                            const contentContainer = container.querySelector('.row').parentNode;
                                            contentContainer.appendChild(emptyWishlist);
                                        }
                                    }
                                }, 500);
                            }
                        }
                    } else {
                        if (data.message && data.message.includes('đăng nhập')) {
                            showLoginModal();
                        } else {
                            alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại sau.');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error updating wishlist:', error);
                    alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                });
            });
        });
    }
    
    // Thêm vào giỏ hàng
    function setupAddToCartButtons() {
        document.querySelectorAll('form[action="index.php?page=add_to_cart"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!isLoggedIn) {
                    showLoginModal();
                    return;
                }
                
                const formData = new FormData(this);
                
                fetch('index.php?page=add_to_cart', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Thành công
                        alert(data.message || 'Đã thêm sản phẩm vào giỏ hàng.');
                        
                        // Cập nhật số lượng giỏ hàng
                        cartCountElements.forEach(element => {
                            element.textContent = data.cart_count || '0';
                        });
                        
                        // Cập nhật giỏ hàng
                        loadCart();
                    } else {
                        alert(data.message || 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
                    }
                })
                .catch(error => {
                    console.error('Error adding to cart:', error);
                    alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                });
            });
        });
    }
    
    // Xử lý xem nhanh sản phẩm (Quick View)
    function setupQuickView() {
        document.querySelectorAll('.product-quick-view-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const productId = this.getAttribute('data-product-id');
                
                fetch(`index.php?page=ajax_product&id=${productId}`)
                .then(response => response.json())
                .then(product => {
                    if (product) {
                        // Cập nhật modal với thông tin sản phẩm
                        const modalTitle = document.getElementById('quickViewModalLabel');
                        const productTitle = document.getElementById('quickViewTitle');
                        const productPrice = document.getElementById('quickViewPrice');
                        const productPriceOld = document.getElementById('quickViewOldPrice');
                        const productDescription = document.getElementById('quickViewDescription');
                        const productImage = document.getElementById('quickViewImage');
                        const addToCartBtn = document.getElementById('quickViewAddToCart');
                        const wishlistBtn = document.getElementById('quickViewWishlist');
                        const productSKU = document.getElementById('quickViewSku');
                        const productBrand = document.getElementById('quickViewBrand');
                        
                        if (modalTitle) modalTitle.textContent = 'Xem nhanh: ' + product.name;
                        if (productTitle) productTitle.textContent = product.name;
                        if (productPrice) productPrice.textContent = formatPrice(product.price) + 'đ';
                        if (productDescription) productDescription.textContent = product.short_description;
                        if (productImage) productImage.style.backgroundImage = `url('${product.image_url}')`;
                        if (productSKU) productSKU.textContent = product.sku;
                        if (productBrand) productBrand.textContent = product.brand_name;
                        if (productPriceOld) {
                            if (product.old_price) {
                                productPriceOld.textContent = formatPrice(product.old_price) + 'đ';
                            } else {
                                productPriceOld.style.display = 'none';
                            }
                        }
                        
                        // Xử lý quantity trong quick view
                        const decreaseQuantityBtn = document.getElementById('decreaseQuantity');
                        const increaseQuantityBtn = document.getElementById('increaseQuantity');
                        const quantityInput = document.getElementById('quantityInput');
                        quantityInput.value = 1;
                        if (decreaseQuantityBtn && quantityInput) {
                            decreaseQuantityBtn.addEventListener('click', function() {
                                let value = parseInt(quantityInput.value);
                                if (value > 1) {
                                    quantityInput.value = value - 1;
                                }
                            });
                        }
                        
                        if (increaseQuantityBtn && quantityInput) {
                            increaseQuantityBtn.addEventListener('click', function() {
                                let value = parseInt(quantityInput.value);
                                quantityInput.value = value + 1;
                            });
                        }

                        // Cập nhật các nút trong modal
                        if (addToCartBtn) addToCartBtn.setAttribute('data-product', product.id);
                        if (wishlistBtn) {
                            wishlistBtn.setAttribute('data-product', product.id);
                            // Kiểm tra sản phẩm có trong wishlist không
                            if (product.in_wishlist) {
                                wishlistBtn.classList.add('active');
                                wishlistBtn.innerHTML = '<i class="bi bi-heart-fill me-1"></i>Đã thêm vào yêu thích';
                            } else {
                                wishlistBtn.classList.remove('active');
                                wishlistBtn.innerHTML = '<i class="bi bi-heart me-1"></i>Thêm vào yêu thích';
                            }
                        }
                        
                        // Hiển thị modal
                        const quickViewModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
                        quickViewModal.show();
                    }
                })
                .catch(error => {
                    console.error('Error loading product details:', error);
                    alert('Không thể tải thông tin sản phẩm. Vui lòng thử lại sau.');
                });
            });
        });
    }
    
    
    // Thêm vào giỏ hàng từ Quick View
    const quickViewAddToCartBtn = document.getElementById('quickViewAddToCart');
    if (quickViewAddToCartBtn) {
        quickViewAddToCartBtn.addEventListener('click', function() {
            if (!isLoggedIn) {
                const quickViewModal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
                if (quickViewModal) quickViewModal.hide();
                
                setTimeout(() => {
                    showLoginModal();
                }, 500);
                return;
            }
            
            const productId = this.getAttribute('data-product');
            const quantity = document.getElementById('quantityInput') ? 
                parseInt(document.getElementById('quantityInput').value) : 1;
            
            fetch('index.php?page=add_to_cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `product_id=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Thành công
                    this.innerHTML = '<i class="bi bi-check me-1"></i>Đã thêm';
                    this.classList.add('btn-success');
                    
                    // Cập nhật số lượng giỏ hàng
                    cartCountElements.forEach(element => {
                        element.textContent = data.cart_count || '0';
                    });
                    
                    // Cập nhật giỏ hàng
                    loadCart();
                    
                    // Đóng modal sau 1.5 giây
                    setTimeout(() => {
                        this.innerHTML = '<i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ hàng';
                        this.classList.remove('btn-success');
                        
                        const quickViewModal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
                        if (quickViewModal) quickViewModal.hide();
                    }, 1500);
                } else {
                    alert(data.message || 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
            });
        });
    }
    
    // Quick View Wishlist Button
    const quickViewWishlistBtn = document.getElementById('quickViewWishlist');
    if (quickViewWishlistBtn) {
        quickViewWishlistBtn.addEventListener('click', function() {
            if (!isLoggedIn) {
                const quickViewModal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
                if (quickViewModal) quickViewModal.hide();
                
                setTimeout(() => {
                    showLoginModal();
                }, 500);
                return;
            }
            
            const productId = this.getAttribute('data-product');
            const isActive = this.classList.contains('active');
            
            fetch(isActive ? 'index.php?page=remove_from_wishlist' : 'index.php?page=add_to_wishlist', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `product_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.classList.toggle('active');
                    
                    if (this.classList.contains('active')) {
                        this.innerHTML = '<i class="bi bi-heart-fill me-1"></i>Đã thêm vào yêu thích';
                    } else {
                        this.innerHTML = '<i class="bi bi-heart me-1"></i>Thêm vào yêu thích';
                    }
                    
                    // Update wishlist count
                    const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                    wishlistCountElements.forEach(element => {
                        let count = parseInt(element.textContent || '0');
                        if (isActive) {
                            count = Math.max(0, count - 1);
                        } else {
                            count++;
                        }
                        element.textContent = count;
                    });
                } else {
                    alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại sau.');
                }
            })
            .catch(error => {
                console.error('Error updating wishlist:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
            });
        });
    }
    
    // Xử lý đăng ký và đăng nhập
    // Login Form Submit Handler
// Xử lý form đăng nhập
const loginForm = document.getElementById('loginForm') || document.querySelector('form[action="index.php?page=login"]');
if (loginForm) {
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
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
                // Đăng nhập thành công
                isLoggedIn = true;
                document.body.classList.add('logged-in');
                
                // Đóng modal
                const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                if (loginModal) loginModal.hide();
                
                // Cập nhật tên người dùng trên navbar
                updateUserInfo(data.user_name);
                
                // Reload trang sau 500ms
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            } else {
                // Hiển thị lỗi và giữ modal mở
                alert(data.message || 'Đăng nhập thất bại. Vui lòng kiểm tra email và mật khẩu.');
                
                // Giữ modal mở
                const loginModal = document.getElementById('loginModal');
                if (loginModal) {
                    const bsModal = bootstrap.Modal.getInstance(loginModal);
                    if (!bsModal) {
                        new bootstrap.Modal(loginModal).show();
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error during login:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
        });
    });
}

// Xử lý form đăng ký
const registerForm = document.getElementById('registerForm') || document.querySelector('form[action="index.php?page=register"]');
if (registerForm) {
    registerForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Kiểm tra mật khẩu khớp nhau
        const passwordField = document.getElementById('registerPassword');
        const confirmPasswordField = document.getElementById('registerConfirmPassword');
        
        if (passwordField && confirmPasswordField && passwordField.value !== confirmPasswordField.value) {
            alert('Mật khẩu xác nhận không khớp!');
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
                // Đăng ký thành công
                alert(data.message || 'Đăng ký thành công. Vui lòng đăng nhập.');
                
                // Reset form
                this.reset();
                
                // Đóng modal đăng ký
                const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                if (registerModal) registerModal.hide();
                
                // Mở modal đăng nhập sau 500ms
                setTimeout(() => {
                    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    loginModal.show();
                }, 500);
            } else {
                alert(data.message || 'Đăng ký thất bại. Vui lòng thử lại.');
            }
        })
        .catch(error => {
            console.error('Error during registration:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
        });
    });
}

// Hàm cập nhật tên người dùng trên navbar
function updateUserInfo(userName) {
    const loginButton = document.getElementById('loginButton');
    const mobileLoginButton = document.getElementById('mobileLoginButton');
    
    if (userName) {
        // Lấy first name (chỉ lấy 2 từ đầu tiên)
        const nameParts = userName.split(' ');
        let displayName = '';
        
        if (nameParts.length >= 2) {
            // Lấy 2 từ đầu tiên
            displayName = nameParts.slice(0, 2).join(' ');
        } else {
            displayName = userName;
        }
        
        // Tạo chữ cái đầu
        const initials = nameParts.map(part => part.charAt(0).toUpperCase()).join('');
        
        // Cập nhật button trên desktop
        if (loginButton) {
            loginButton.innerHTML = `
                <div class="d-flex align-items-center">
                    <span class="d-none d-md-inline me-2">Xin chào, ${displayName}!</span>
                    <span class="badge bg-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">${initials}</span>
                </div>
            `;
            loginButton.setAttribute('data-bs-toggle', 'dropdown');
            loginButton.href = "#";
        }
        
        // Cập nhật button trên mobile
        if (mobileLoginButton) {
            mobileLoginButton.innerHTML = `
                <div class="d-flex align-items-center justify-content-center">
                    <span class="me-2">Xin chào!</span>
                    <span class="badge bg-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">${initials}</span>
                </div>
            `;
            mobileLoginButton.href = "index.php?page=profile";
        }
    }
}
    
    // Switch between login and register modals
    const switchToRegisterBtn = document.getElementById('switchToRegister');
    const switchToLoginBtn = document.getElementById('switchToLogin');
    
    if (switchToRegisterBtn) {
        switchToRegisterBtn.addEventListener('click', function() {
            const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
            if (loginModal) loginModal.hide();
            
            setTimeout(() => {
                const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
                registerModal.show();
            }, 500);
        });
    }
    
    if (switchToLoginBtn) {
        switchToLoginBtn.addEventListener('click', function() {
            const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
            if (registerModal) registerModal.hide();
            
            setTimeout(() => {
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            }, 500);
        });
    }
    
    // Hiệu ứng Navbar khi scroll
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('shadow');
            } else {
                navbar.classList.remove('shadow');
            }
        }
    });
    
    // Xử lý trang profile
    function setupProfilePage() {
        // Xử lý tabs
        const tabLinks = document.querySelectorAll('.list-group-item[data-bs-toggle="list"]');
        
        tabLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Lưu tab hiện tại vào URL hash
                window.location.hash = this.getAttribute('href');
            });
        });
        
        // Kiểm tra URL hash để hiển thị tab tương ứng
        const hash = window.location.hash;
        if (hash) {
            const activeTab = document.querySelector(`.list-group-item[href="${hash}"]`);
            if (activeTab) {
                activeTab.click();
            }
        }
        
        // Xử lý cập nhật thông tin cá nhân
        const profileForm = document.querySelector('form[action="index.php?page=update_profile"]');
        if (profileForm) {
            profileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch('index.php?page=update_profile', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Cập nhật thông tin thành công!');
                        window.location.reload();
                    } else {
                        alert(data.message || 'Có lỗi xảy ra khi cập nhật thông tin.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                });
            });
        }
        
        // Xử lý đổi mật khẩu
        const passwordForm = document.querySelector('form[action="index.php?page=change_password"]');
        if (passwordForm) {
            passwordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('confirm_password').value;
                
                if (newPassword !== confirmPassword) {
                    alert('Mật khẩu xác nhận không khớp!');
                    return;
                }
                
                const formData = new FormData(this);
                
                fetch('index.php?page=change_password', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Đổi mật khẩu thành công!');
                        this.reset();
                    } else {
                        alert(data.message || 'Có lỗi xảy ra khi đổi mật khẩu.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                });
            });
        }
        
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
    }
    
    // Khởi tạo các chức năng
    setupWishlistButtons();
    setupAddToCartButtons();
    setupQuickView();
    setupProfilePage();
    loadCart();
    
    // Smooth Scroll cho các links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            if (this.getAttribute('href') !== '#' && 
                this.getAttribute('href') !== '#!' && 
                !this.getAttribute('href').includes('modal') &&
                document.querySelector(this.getAttribute('href'))) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});

// Xử lý "Mua ngay"
document.querySelectorAll('.buy-now-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Kiểm tra đăng nhập
        if (!isLoggedIn) {
            showLoginModal();
            return;
        }
        
        const productId = this.getAttribute('data-product-id');
        const quantity = document.querySelector('#quantity') ? parseInt(document.querySelector('#quantity').value) : 1;
        
        // Thêm vào giỏ hàng và chuyển hướng đến trang checkout
        fetch('index.php?page=add_to_cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `product_id=${productId}&quantity=${quantity}&buy_now=1`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Chuyển hướng đến trang checkout
                window.location.href = 'index.php?page=checkout';
            } else {
                if (data.message.includes('đăng nhập')) {
                    showLoginModal();
                } else {
                    alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại sau.');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
        });
    });
});

// Xử lý "Thêm vào giỏ hàng"
document.querySelectorAll('form[action="index.php?page=add_to_cart"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Kiểm tra đăng nhập
        if (!isLoggedIn) {
            showLoginModal();
            return;
        }
        
        const formData = new FormData(this);
        
        fetch('index.php?page=add_to_cart', {
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
                const button = this.querySelector('button[type="submit"]');
                const originalText = button.innerHTML;
                
                button.innerHTML = '<i class="bi bi-check-circle"></i> Đã thêm';
                button.classList.add('btn-success');
                
                // Cập nhật số lượng giỏ hàng
                document.querySelectorAll('.cart-count').forEach(el => {
                    el.textContent = data.cart_count || '0';
                });
                
                // Sau 2 giây, khôi phục nút ban đầu
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('btn-success');
                }, 2000);
            } else {
                if (data.message.includes('đăng nhập')) {
                    showLoginModal();
                } else {
                    alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại sau.');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
        });
    });

    //Fix backgr đen modals
    function cleanupModals() {
        // Xóa bất kỳ lớp nền modal nào còn sót lại
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        
        // Đặt lại các lớp và kiểu dáng cho thẻ body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Đảm bảo tất cả các modal được ẩn đúng cách
        document.querySelectorAll('.modal').forEach(modal => {
            modal.classList.remove('show');
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        });
    }

    // Thêm trình nghe sự kiện cho tất cả các nút đóng modal
    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            setTimeout(cleanupModals, 300); // Đợi cho hoạt ảnh modal hoàn tất
        });
    });

    // Cũng xử lý phím ESC để đảm bảo dọn dẹp đúng cách
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            setTimeout(cleanupModals, 300);
        }
    });
    // gọi hàm để chọn dọn dẹp đúng
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal').forEach(modalElement => {
            modalElement.addEventListener('hidden.bs.modal', function() {
                cleanupModals();
            });
        });
    });

});

// // Xử lý Quick View
// function setupQuickView() {
//     document.querySelectorAll('.product-quick-view-btn').forEach(button => {
//         button.addEventListener('click', function(e) {
//             e.preventDefault();
//             e.stopPropagation();
            
//             const productId = this.getAttribute('data-product-id');
//             if (!productId) return;
            
//             // Hiển thị loading trong modal
//             document.getElementById('quickViewTitle').textContent = 'Đang tải...';
//             document.getElementById('quickViewProductName').textContent = 'Đang tải...';
//             document.getElementById('quickViewDescription').textContent = 'Đang tải...';
//             document.getElementById('quickViewImage').style.backgroundImage = 'none';
            
//             // Hiển thị modal
//             const quickViewModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
//             quickViewModal.show();
            
//             // Lấy dữ liệu sản phẩm từ API
//             fetch(`index.php?page=ajax_product&id=${productId}`)
//             .then(response => response.json())
//             .then(product => {
//                 if (product) {
//                     // Cập nhật tiêu đề modal
//                     document.getElementById('quickViewTitle').textContent = product.name;
//                     document.getElementById('quickViewModalLabel').textContent = 'Xem nhanh: ' + product.name;
                    
//                     // Cập nhật thông tin sản phẩm
//                     document.getElementById('quickViewProductName').textContent = product.name;
//                     document.getElementById('quickViewDescription').textContent = product.short_description;
//                     document.getElementById('quickViewImage').style.backgroundImage = `url('${product.image_url}')`;
//                     document.getElementById('quickViewBrand').textContent = product.brand_name;
//                     document.getElementById('quickViewSku').textContent = product.sku || 'N/A';
                    
//                     // Cập nhật link chi tiết sản phẩm
//                     document.getElementById('quickViewDetailLink').href = `index.php?page=product_detail&id=${product.id}`;
                    
//                     // Cập nhật giá
//                     document.getElementById('quickViewPrice').textContent = new Intl.NumberFormat('vi-VN').format(product.price) + 'đ';
//                     if (product.old_price && product.old_price > product.price) {
//                         document.getElementById('quickViewOldPrice').textContent = new Intl.NumberFormat('vi-VN').format(product.old_price) + 'đ';
//                         document.getElementById('quickViewOldPrice').style.display = 'inline';
//                     } else {
//                         document.getElementById('quickViewOldPrice').style.display = 'none';
//                     }
                    
//                     // Cập nhật đánh giá
//                     const ratingContainer = document.getElementById('quickViewRating');
//                     ratingContainer.innerHTML = '';
//                     const rating = parseFloat(product.rating) || 0;
//                     for (let i = 1; i <= 5; i++) {
//                         const star = document.createElement('i');
//                         if (i <= rating) {
//                             star.classList.add('bi', 'bi-star-fill');
//                         } else if (i <= rating + 0.5) {
//                             star.classList.add('bi', 'bi-star-half');
//                         } else {
//                             star.classList.add('bi', 'bi-star');
//                         }
//                         ratingContainer.appendChild(star);
//                     }
//                     document.getElementById('quickViewReviewCount').textContent = `(${product.reviews_count || 0} đánh giá)`;
                    
//                     // Cập nhật trạng thái kho hàng
//                     const stockContainer = document.getElementById('quickViewStockContainer');
//                     const stockStatus = document.getElementById('quickViewStockStatus');
//                     if (product.stock > 0) {
//                         stockStatus.innerHTML = '<i class="bi bi-check-circle text-success"></i> Còn hàng';
//                         document.getElementById('quickViewAddToCart').disabled = false;
//                     } else {
//                         stockStatus.innerHTML = '<i class="bi bi-x-circle text-danger"></i> Hết hàng';
//                         document.getElementById('quickViewAddToCart').disabled = true;
//                     }
                    
//                     // Xử lý màu sắc (nếu có)
//                     const colorContainer = document.getElementById('quickViewColorContainer');
//                     const colorsDiv = document.getElementById('quickViewColors');
//                     if (product.colors && product.colors.length > 0) {
//                         colorContainer.style.display = 'block';
//                         colorsDiv.innerHTML = '';
                        
//                         try {
//                             const colors = typeof product.colors === 'string' ? JSON.parse(product.colors) : product.colors;
//                             colors.forEach(color => {
//                                 const colorBtn = document.createElement('button');
//                                 colorBtn.type = 'button';
//                                 colorBtn.classList.add('btn', 'btn-outline-secondary', 'btn-sm', 'color-option');
//                                 colorBtn.setAttribute('data-color', color);
//                                 colorBtn.textContent = color;
                                
//                                 colorBtn.addEventListener('click', function() {
//                                     document.querySelectorAll('.color-option').forEach(btn => btn.classList.remove('active'));
//                                     this.classList.add('active');
//                                 });
                                
//                                 colorsDiv.appendChild(colorBtn);
//                             });
//                         } catch (e) {
//                             colorContainer.style.display = 'none';
//                         }
//                     } else {
//                         colorContainer.style.display = 'none';
//                     }
                    
//                     // Xử lý biến thể (nếu có)
//                     const variationContainer = document.getElementById('quickViewVariationContainer');
//                     const variationsDiv = document.getElementById('quickViewVariations');
//                     if (product.variations && product.variations.length > 0) {
//                         variationContainer.style.display = 'block';
//                         variationsDiv.innerHTML = '';
                        
//                         try {
//                             const variations = typeof product.variations === 'string' ? JSON.parse(product.variations) : product.variations;
//                             variations.forEach(variation => {
//                                 const varBtn = document.createElement('button');
//                                 varBtn.type = 'button';
//                                 varBtn.classList.add('btn', 'btn-outline-secondary', 'btn-sm', 'variation-option');
//                                 varBtn.setAttribute('data-variation', variation);
//                                 varBtn.textContent = variation;
                                
//                                 varBtn.addEventListener('click', function() {
//                                     document.querySelectorAll('.variation-option').forEach(btn => btn.classList.remove('active'));
//                                     this.classList.add('active');
//                                 });
                                
//                                 variationsDiv.appendChild(varBtn);
//                             });
//                         } catch (e) {
//                             variationContainer.style.display = 'none';
//                         }
//                     } else {
//                         variationContainer.style.display = 'none';
//                     }
                    
//                     // Xử lý thumbnails (nếu có)
//                     const thumbsContainer = document.getElementById('quickViewThumbs');
//                     thumbsContainer.innerHTML = '';
                    
//                     if (product.images && product.images.length > 0) {
//                         try {
//                             const images = typeof product.images === 'string' ? JSON.parse(product.images) : product.images;
                            
//                             // Thêm ảnh chính
//                             const mainThumb = document.createElement('div');
//                             mainThumb.classList.add('quick-view-thumb', 'active');
//                             mainThumb.style.backgroundImage = `url('${product.image_url}')`;
//                             mainThumb.addEventListener('click', function() {
//                                 document.querySelectorAll('.quick-view-thumb').forEach(thumb => thumb.classList.remove('active'));
//                                 this.classList.add('active');
//                                 document.getElementById('quickViewImage').style.backgroundImage = this.style.backgroundImage;
//                             });
//                             thumbsContainer.appendChild(mainThumb);
                            
//                             // Thêm các ảnh khác
//                             images.forEach(imgUrl => {
//                                 if (imgUrl !== product.image_url) {
//                                     const thumb = document.createElement('div');
//                                     thumb.classList.add('quick-view-thumb');
//                                     thumb.style.backgroundImage = `url('${imgUrl}')`;
//                                     thumb.addEventListener('click', function() {
//                                         document.querySelectorAll('.quick-view-thumb').forEach(t => t.classList.remove('active'));
//                                         this.classList.add('active');
//                                         document.getElementById('quickViewImage').style.backgroundImage = this.style.backgroundImage;
//                                     });
//                                     thumbsContainer.appendChild(thumb);
//                                 }
//                             });
//                         } catch (e) {
//                             console.error('Error parsing images:', e);
//                         }
//                     }
                    
//                     // Cập nhật các nút action
//                     document.getElementById('quickViewAddToCart').setAttribute('data-product', product.id);
//                     document.getElementById('quickViewWishlist').setAttribute('data-product', product.id);
                    
//                     // Kiểm tra sản phẩm có trong wishlist không
//                     if (product.in_wishlist) {
//                         document.getElementById('quickViewWishlist').classList.add('active');
//                         document.getElementById('quickViewWishlist').innerHTML = '<i class="bi bi-heart-fill me-1"></i>Đã thêm vào yêu thích';
//                     } else {
//                         document.getElementById('quickViewWishlist').classList.remove('active');
//                         document.getElementById('quickViewWishlist').innerHTML = '<i class="bi bi-heart me-1"></i>Thêm vào yêu thích';
//                     }
//                 }
//             })
//             .catch(error => {
//                 console.error('Error loading product details:', error);
//                 alert('Không thể tải thông tin sản phẩm. Vui lòng thử lại sau.');
//             });
//         });
//     });
    
//     // Xử lý nút thêm vào giỏ hàng trong modal Quick View
//     document.getElementById('quickViewAddToCart').addEventListener('click', function() {
//         // Kiểm tra đăng nhập
//         if (!document.body.classList.contains('logged-in')) {
//             const quickViewModal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
//             if (quickViewModal) quickViewModal.hide();
            
//             setTimeout(() => {
//                 const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
//                 loginModal.show();
//             }, 500);
//             return;
//         }
        
//         const productId = this.getAttribute('data-product');
//         const quantity = document.getElementById('quantityInput').value || 1;
        
//         // Lấy thông tin màu sắc (nếu được chọn)
//         let color = null;
//         const selectedColor = document.querySelector('.color-option.active');
//         if (selectedColor) {
//             color = selectedColor.getAttribute('data-color');
//         }
        
//         // Lấy thông tin biến thể (nếu được chọn)
//         let variation = null;
//         const selectedVariation = document.querySelector('.variation-option.active');
//         if (selectedVariation) {
//             variation = selectedVariation.getAttribute('data-variation');
//         }
        
//         // Gửi request thêm vào giỏ hàng
//         let formData = new FormData();
//         formData.append('product_id', productId);
//         formData.append('quantity', quantity);
//         if (color) formData.append('color', color);
//         if (variation) formData.append('variation', variation);
        
//         fetch('index.php?page=add_to_cart', {
//             method: 'POST',
//             body: formData,
//             headers: {
//                 'X-Requested-With': 'XMLHttpRequest'
//             }
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 // Thành công
//                 this.innerHTML = '<i class="bi bi-check me-1"></i>Đã thêm vào giỏ';
//                 this.classList.remove('btn-primary');
//                 this.classList.add('btn-success');
                
//                 // Cập nhật số lượng giỏ hàng
//                 document.querySelectorAll('.cart-count').forEach(el => {
//                     el.textContent = data.cart_count || '0';
//                 });
                
//                 // Sau 1.5 giây, đóng modal và reset lại nút
//                 setTimeout(() => {
//                     const quickViewModal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
//                     if (quickViewModal) quickViewModal.hide();
                    
//                     this.innerHTML = '<i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ hàng';
//                     this.classList.remove('btn-success');
//                     this.classList.add('btn-primary');
//                 }, 1500);
//             } else {
//                 if (data.message.includes('đăng nhập')) {
//                     const quickViewModal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
//                     if (quickViewModal) quickViewModal.hide();
                    
//                     setTimeout(() => {
//                         const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
//                         loginModal.show();
//                     }, 500);
//                 } else {
//                     alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại sau.');
//                 }
//             }
//         })
//         .catch(error => {
//             console.error('Error adding to cart:', error);
//             alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
//         });
//     });
    
//     // Xử lý nút yêu thích trong modal Quick View
//     document.getElementById('quickViewWishlist').addEventListener('click', function() {
//         // Kiểm tra đăng nhập
//         if (!document.body.classList.contains('logged-in')) {
//             const quickViewModal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
//             if (quickViewModal) quickViewModal.hide();
            
//             setTimeout(() => {
//                 const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
//                 loginModal.show();
//             }, 500);
//             return;
//         }
        
//         const productId = this.getAttribute('data-product');
//         const isActive = this.classList.contains('active');
        
//         // Gửi request thêm/xóa khỏi wishlist
//         fetch(isActive ? 'index.php?page=remove_from_wishlist' : 'index.php?page=add_to_wishlist', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/x-www-form-urlencoded',
//                 'X-Requested-With': 'XMLHttpRequest'
//             },
//             body: `product_id=${productId}`
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 // Toggle active state
//                 this.classList.toggle('active');
                
//                 if (this.classList.contains('active')) {
//                     this.innerHTML = '<i class="bi bi-heart-fill me-1"></i>Đã thêm vào yêu thích';
//                 } else {
//                     this.innerHTML = '<i class="bi bi-heart me-1"></i>Thêm vào yêu thích';
//                 }
                
//                 // Cập nhật wishlist count nếu có
//                 const wishlistCountElements = document.querySelectorAll('.wishlist-count');
//                 wishlistCountElements.forEach(element => {
//                     let count = parseInt(element.textContent || '0');
//                     if (isActive) {
//                         count = Math.max(0, count - 1);
//                     } else {
//                         count++;
//                     }
//                     element.textContent = count;
//                 });
                
//                 // Cập nhật nút wishlist trong trang chính
//                 const productWishlistBtns = document.querySelectorAll(`.product-wishlist-btn[data-product-id="${productId}"]`);
//                 productWishlistBtns.forEach(btn => {
//                     if (this.classList.contains('active')) {
//                         btn.classList.add('active');
//                     } else {
//                         btn.classList.remove('active');
//                     }
//                 });
//             } else {
//                 alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại sau.');
//             }
//         })
//         .catch(error => {
//             console.error('Error updating wishlist:', error);
//             alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
//         });
//     });
    
//     // Xử lý nút tăng/giảm số lượng
//     document.getElementById('decreaseQuantity').addEventListener('click', function() {
//         const quantityInput = document.getElementById('quantityInput');
//         let value = parseInt(quantityInput.value);
//         if (value > 1) {
//             quantityInput.value = value - 1;
//         }
//     });
    
//     document.getElementById('increaseQuantity').addEventListener('click', function() {
//         const quantityInput = document.getElementById('quantityInput');
//         let value = parseInt(quantityInput.value);
//         quantityInput.value = value + 1;
//     });
// }

// // Gọi hàm setupQuickView khi trang đã tải xong
// document.addEventListener('DOMContentLoaded', function() {
//     setupQuickView();
// });