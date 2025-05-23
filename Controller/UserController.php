<?php
// Controller/UserController.php - Controller xử lý người dùng

require_once 'Model/UserModel.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    // Xử lý đăng ký
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            
            // Kiểm tra thông tin
            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin bắt buộc.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
                    exit;
                }
                
                // Quay lại trang chủ (modal sẽ tự hiển thị nếu có error)
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'));
                exit;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Email không hợp lệ.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
                    exit;
                }
                
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'));
                exit;
            }
            
            if ($password !== $confirm_password) {
                $_SESSION['error'] = 'Mật khẩu xác nhận không khớp.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
                    exit;
                }
                
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'));
                exit;
            }
            
            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
                    exit;
                }
                
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'));
                exit;
            }
            
            // Đăng ký người dùng
            $result = $this->userModel->register($name, $email, $password, $phone);
            
            if ($result) {
                $_SESSION['success'] = 'Đăng ký thành công. Vui lòng đăng nhập.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => true, 'message' => $_SESSION['success']]);
                    exit;
                }
                
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'));
            } else {
                $_SESSION['error'] = 'Email đã tồn tại hoặc có lỗi xảy ra. Vui lòng thử lại.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
                    exit;
                }
                
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'));
            }
            exit;
        }
        
        // Nếu không phải POST request, chuyển hướng về trang chủ
        header('Location: index.php');
        exit;
    }
    
    // Xử lý đăng nhập
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $remember = isset($_POST['remember']) ? true : false;
            
            // Kiểm tra thông tin
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin đăng nhập.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
                    exit;
                }
                
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'));
                exit;
            }
            
            // Đăng nhập
            $user = $this->userModel->login($email, $password);
            
            if ($user) {
                // Lưu thông tin người dùng vào session
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_role'] = $user->role;
                
                // Lưu cookie nếu chọn "Ghi nhớ đăng nhập"
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    setcookie('remember_token', $token, time() + 30 * 24 * 60 * 60, '/');
                    
                    // Lưu token vào database (tùy chọn)
                    // ...
                }
                
                // Chuyển giỏ hàng từ session sang user
                if (isset($_SESSION['cart_id'])) {
                    require_once 'Model/CartModel.php';
                    $cartModel = new CartModel();
                    $cartModel->mergeCart($user->id, $_SESSION['cart_id']);
                    unset($_SESSION['cart_id']);
                }
                
                $_SESSION['success'] = 'Đăng nhập thành công.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode([
                        'success' => true, 
                        'message' => $_SESSION['success'], 
                        'user_name' => $user->name
                    ]);
                    exit;
                }
                
                // Chuyển hướng về trang trước đó nếu có
                if (isset($_SESSION['redirect_after_login'])) {
                    $redirect = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']);
                    header('Location: ' . $redirect);
                } else {
                    header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'));
                }
            } else {
                $_SESSION['error'] = 'Email hoặc mật khẩu không đúng.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
                    exit;
                }
                
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'));
            }
            exit;
        }
        
        // Lưu trang hiện tại để sau khi đăng nhập quay lại
        if (isset($_SERVER['HTTP_REFERER'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['HTTP_REFERER'];
        }
        
        // Nếu không phải POST request, chuyển hướng về trang chủ
        header('Location: index.php');
        exit;
    }
    
    // Xử lý đăng xuất
    public function logout() {
        // Xóa session
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_role']);
        
        // Xóa cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        $_SESSION['success'] = 'Đăng xuất thành công.';
        
        // Quay lại trang trước đó
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: index.php');
        }
        exit;
    }
    
    // Xử lý trang profile
    public function profile() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem trang cá nhân.';
            $_SESSION['redirect_after_login'] = 'index.php?page=profile';
            header('Location: index.php?page=login');
            exit;
        }
        
        // Lấy thông tin người dùng
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        if (!$user) {
            header('Location: index.php?page=error404');
            exit;
        }
        
        // Lấy danh sách đơn hàng của người dùng
        $orders = $this->userModel->getUserOrders($_SESSION['user_id']);
        
        // Truyền dữ liệu sang view
        $title = "Tài khoản của tôi";
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/user/profile.php';
        include VIEW_PATH . '/includes/footer.php';
    }
    
    // Xử lý cập nhật thông tin cá nhân
    public function updateProfile() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để cập nhật thông tin.';
            header('Location: index.php?page=login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            $address = isset($_POST['address']) ? trim($_POST['address']) : '';
            $city = isset($_POST['city']) ? trim($_POST['city']) : '';
            $district = isset($_POST['district']) ? trim($_POST['district']) : '';
            $ward = isset($_POST['ward']) ? trim($_POST['ward']) : '';
            
            // Kiểm tra thông tin
            if (empty($name)) {
                $_SESSION['error'] = 'Vui lòng điền họ và tên.';
                header('Location: index.php?page=profile');
                exit;
            }
            
            // Xử lý upload avatar nếu có
            $avatar = null;
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = USER_IMG_PATH;
                
                // Tạo thư mục nếu chưa tồn tại
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                // Kiểm tra định dạng và kích thước
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $max_size = 2 * 1024 * 1024; // 2MB
                
                if (!in_array($_FILES['avatar']['type'], $allowed_types)) {
                    $_SESSION['error'] = 'Chỉ chấp nhận file hình ảnh (JPG, PNG, GIF).';
                    header('Location: index.php?page=profile');
                    exit;
                }
                
                if ($_FILES['avatar']['size'] > $max_size) {
                    $_SESSION['error'] = 'Kích thước file không được vượt quá 2MB.';
                    header('Location: index.php?page=profile');
                    exit;
                }
                
                // Tạo tên file mới
                $file_name = uniqid() . '_' . $_FILES['avatar']['name'];
                $destination = $upload_dir . $file_name;
                
                // Upload file
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
                    $avatar = $destination;
                    
                    // Cập nhật avatar trong database
                    $this->userModel->updateAvatar($_SESSION['user_id'], $avatar);
                }
            }
            
            // Cập nhật thông tin người dùng
            $result = $this->userModel->updateUser($_SESSION['user_id'], $name, $phone, $address, $city, $district, $ward);
            
            if ($result) {
                $_SESSION['success'] = 'Cập nhật thông tin thành công.';
                
                // Cập nhật tên trong session
                $_SESSION['user_name'] = $name;
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => true, 'message' => $_SESSION['success']]);
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Cập nhật thông tin thất bại. Vui lòng thử lại.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
                    exit;
                }
            }
            
            header('Location: index.php?page=profile');
            exit;
        }
        
        // Nếu không phải POST request, chuyển hướng về trang profile
        header('Location: index.php?page=profile');
        exit;
    }
    
    // Xử lý đổi mật khẩu
    public function changePassword() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để đổi mật khẩu.';
            header('Location: index.php?page=login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
            $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            
            // Kiểm tra thông tin
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin.';
                header('Location: index.php?page=profile#change-password');
                exit;
            }
            
            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = 'Mật khẩu xác nhận không khớp.';
                header('Location: index.php?page=profile#change-password');
                exit;
            }
            
            if (strlen($new_password) < 6) {
                $_SESSION['error'] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
                header('Location: index.php?page=profile#change-password');
                exit;
            }
            
            // Đổi mật khẩu
            $result = $this->userModel->changePassword($_SESSION['user_id'], $current_password, $new_password);
            
            if ($result) {
                $_SESSION['success'] = 'Đổi mật khẩu thành công.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => true, 'message' => $_SESSION['success']]);
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Mật khẩu hiện tại không đúng hoặc có lỗi xảy ra. Vui lòng thử lại.';
                
                // Nếu là AJAX request, trả về JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
                    exit;
                }
            }
            
            header('Location: index.php?page=profile#change-password');
            exit;
        }
        
        // Nếu không phải POST request, chuyển hướng về trang profile
        header('Location: index.php?page=profile');
        exit;
    }
    
    // Xử lý xem chi tiết đơn hàng
    public function orderDetail() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem chi tiết đơn hàng.';
            header('Location: index.php?page=login');
            exit;
        }
        
        $order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($order_id <= 0) {
            header('Location: index.php?page=profile#orders');
            exit;
        }
        
        // Lấy thông tin đơn hàng
        $order = $this->userModel->getOrderById($order_id, $_SESSION['user_id']);
        
        if (!$order) {
            $_SESSION['error'] = 'Đơn hàng không tồn tại.';
            header('Location: index.php?page=profile#orders');
            exit;
        }
        
        // Lấy các sản phẩm trong đơn hàng
        $order_items = $this->userModel->getOrderItems($order_id);
        
        // Truyền dữ liệu sang view
        $title = "Chi tiết đơn hàng #" . str_pad($order_id, 6, '0', STR_PAD_LEFT);
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/user/order_detail.php';
        include VIEW_PATH . '/includes/footer.php';
    }
}