<?php
// Controller/CartController.php - Controller xử lý giỏ hàng

require_once 'Model/CartModel.php';
require_once 'Model/ProductModel.php';

class CartController {
    private $cartModel;
    private $productModel;
    
    public function __construct() {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        
        // Tạo session_id cho giỏ hàng nếu chưa có
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['cart_id'])) {
            $_SESSION['cart_id'] = bin2hex(random_bytes(16));
        }
    }
    
    // Xử lý xem giỏ hàng
    public function viewCart() {
        $cart_items = [];
        $total_amount = 0;
        
        if (isset($_SESSION['user_id'])) {
            $cart_items = $this->cartModel->getCart($_SESSION['user_id']);
            $total_amount = $this->cartModel->calculateCartTotal($_SESSION['user_id']);
        } elseif (isset($_SESSION['cart_id'])) {
            $cart_items = $this->cartModel->getCart(null, $_SESSION['cart_id']);
            $total_amount = $this->cartModel->calculateCartTotal(null, $_SESSION['cart_id']);
        }
        
        // Sản phẩm gợi ý
        $recommended_products = $this->productModel->getBestSellingProducts(4);
        
        // Truyền dữ liệu sang view
        $title = "Giỏ hàng";
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/cart.php';
        include VIEW_PATH . '/includes/footer.php';
    }
    
    // Xử lý thêm sản phẩm vào giỏ hàng
    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }
        
        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        $buy_now = isset($_POST['buy_now']) ? (bool)$_POST['buy_now'] : false;
        
        // Các tùy chọn như màu sắc, kích thước, v.v.
        $options = [];
        if (isset($_POST['color'])) {
            $options['color'] = $_POST['color'];
        }
        if (isset($_POST['variation'])) {
            $options['variation'] = $_POST['variation'];
        }
        
        // Kiểm tra đăng nhập nếu bắt buộc
        $requires_login = true; // Có thể cấu hình từ admin panel

        if ($requires_login && !isset($_SESSION['user_id'])) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.']);
                exit;
            } else {
                $_SESSION['error'] = 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.';
                $_SESSION['redirect_after_login'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
                header('Location: index.php?page=login');
                exit;
            }
        }
        
        if ($product_id <= 0 || $quantity <= 0) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => 'Thông tin sản phẩm không hợp lệ.']);
                exit;
            } else {
                $_SESSION['error'] = 'Thông tin sản phẩm không hợp lệ.';
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php?page=all_products'));
                exit;
            }
        }
        
        // Kiểm tra sản phẩm có tồn tại không
        $product = $this->productModel->getProductById($product_id);
        
        if (!$product) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
                exit;
            } else {
                $_SESSION['error'] = 'Sản phẩm không tồn tại.';
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php?page=all_products'));
                exit;
            }
        }
        
        // Kiểm tra số lượng sản phẩm
        if ($quantity > $product->stock) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => 'Số lượng sản phẩm trong kho không đủ.']);
                exit;
            } else {
                $_SESSION['error'] = 'Số lượng sản phẩm trong kho không đủ.';
                header('Location: index.php?page=product_detail&id=' . $product_id);
                exit;
            }
        }
        
        // Trước khi thêm sản phẩm "Mua ngay", hãy xóa giỏ hàng hiện tại
        if ($buy_now && isset($_SESSION['user_id'])) {
            $this->cartModel->clearCart($_SESSION['user_id']);
        } elseif ($buy_now && isset($_SESSION['cart_id'])) {
            $this->cartModel->clearCart(null, $_SESSION['cart_id']);
        }
        
        // Thêm vào giỏ hàng
        $success = false;
        if (isset($_SESSION['user_id'])) {
            $success = $this->cartModel->addToCart($product_id, $quantity, $options, $_SESSION['user_id']);
        } elseif (isset($_SESSION['cart_id'])) {
            $success = $this->cartModel->addToCart($product_id, $quantity, $options, null, $_SESSION['cart_id']);
        }
        
        if ($success) {
            // Đếm số lượng sản phẩm trong giỏ hàng
            $cart_count = isset($_SESSION['user_id']) ? 
                $this->cartModel->countCartItems($_SESSION['user_id']) : 
                (isset($_SESSION['cart_id']) ? $this->cartModel->countCartItems(null, $_SESSION['cart_id']) : 0);
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Đã thêm sản phẩm vào giỏ hàng.',
                    'cart_count' => $cart_count
                ]);
                exit;
            } else {
                $_SESSION['success'] = 'Đã thêm sản phẩm vào giỏ hàng.';
                if ($buy_now) {
                    header('Location: index.php?page=checkout');
                } else {
                    header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php?page=cart'));
                }
                exit;
            }
        } else {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.']);
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php?page=product_detail&id=' . $product_id));
                exit;
            }
        }
    }
    
    // Xử lý cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }
        
        $cart_id = isset($_POST['cart_id']) ? (int)$_POST['cart_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        
        if ($cart_id <= 0) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => 'Thông tin không hợp lệ.']);
                exit;
            } else {
                $_SESSION['error'] = 'Thông tin không hợp lệ.';
                header('Location: index.php?page=cart');
                exit;
            }
        }
        
        // Cập nhật giỏ hàng
        $success = false;
        if (isset($_SESSION['user_id'])) {
            $success = $this->cartModel->updateCart($cart_id, $quantity, $_SESSION['user_id']);
        } elseif (isset($_SESSION['cart_id'])) {
            $success = $this->cartModel->updateCart($cart_id, $quantity, null, $_SESSION['cart_id']);
        }
        
        if ($success) {
            // Tính lại tổng tiền
            $total_amount = 0;
            if (isset($_SESSION['user_id'])) {
                $total_amount = $this->cartModel->calculateCartTotal($_SESSION['user_id']);
            } elseif (isset($_SESSION['cart_id'])) {
                $total_amount = $this->cartModel->calculateCartTotal(null, $_SESSION['cart_id']);
            }
            
            // Đếm số lượng sản phẩm trong giỏ hàng
            $cart_count = isset($_SESSION['user_id']) ? 
                $this->cartModel->countCartItems($_SESSION['user_id']) : 
                (isset($_SESSION['cart_id']) ? $this->cartModel->countCartItems(null, $_SESSION['cart_id']) : 0);
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Đã cập nhật giỏ hàng.',
                    'total_amount' => number_format($total_amount, 0, ',', '.') . 'đ',
                    'cart_count' => $cart_count
                ]);
                exit;
            } else {
                $_SESSION['success'] = 'Đã cập nhật giỏ hàng.';
                header('Location: index.php?page=cart');
                exit;
            }
        } else {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.']);
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
                header('Location: index.php?page=cart');
                exit;
            }
        }
    }
    
    // Xử lý xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }
        
        $cart_id = isset($_POST['cart_id']) ? (int)$_POST['cart_id'] : 0;
        
        if ($cart_id <= 0) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => 'Thông tin không hợp lệ.']);
                exit;
            } else {
                $_SESSION['error'] = 'Thông tin không hợp lệ.';
                header('Location: index.php?page=cart');
                exit;
            }
        }
        
        // Xóa khỏi giỏ hàng
        $success = false;
        if (isset($_SESSION['user_id'])) {
            $success = $this->cartModel->removeFromCart($cart_id, $_SESSION['user_id']);
        } elseif (isset($_SESSION['cart_id'])) {
            $success = $this->cartModel->removeFromCart($cart_id, null, $_SESSION['cart_id']);
        }
        
        if ($success) {
            // Tính lại tổng tiền
            $total_amount = 0;
            if (isset($_SESSION['user_id'])) {
                $total_amount = $this->cartModel->calculateCartTotal($_SESSION['user_id']);
            } elseif (isset($_SESSION['cart_id'])) {
                $total_amount = $this->cartModel->calculateCartTotal(null, $_SESSION['cart_id']);
            }
            
            // Đếm số lượng sản phẩm trong giỏ hàng
            $cart_count = isset($_SESSION['user_id']) ? 
                $this->cartModel->countCartItems($_SESSION['user_id']) : 
                (isset($_SESSION['cart_id']) ? $this->cartModel->countCartItems(null, $_SESSION['cart_id']) : 0);
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
                    'total_amount' => number_format($total_amount, 0, ',', '.') . 'đ',
                    'cart_count' => $cart_count
                ]);
                exit;
            } else {
                $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng.';
                header('Location: index.php?page=cart');
                exit;
            }
        } else {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.']);
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
                header('Location: index.php?page=cart');
                exit;
            }
        }
    }
    
    // Xử lý xóa toàn bộ giỏ hàng
    public function clearCart() {
        // Kiểm tra Ajax request
        if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
            header('Location: index.php');
            exit;
        }
        
        $success = false;
        if (isset($_SESSION['user_id'])) {
            $success = $this->cartModel->clearCart($_SESSION['user_id']);
        } elseif (isset($_SESSION['cart_id'])) {
            $success = $this->cartModel->clearCart(null, $_SESSION['cart_id']);
        }
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Đã xóa toàn bộ giỏ hàng.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.']);
        }
        exit;
    }
    
    // Xử lý trang thanh toán
    public function checkout() {
        // Kiểm tra giỏ hàng có sản phẩm không
        $cart_items = [];
        $total_amount = 0;
        
        if (isset($_SESSION['user_id'])) {
            $cart_items = $this->cartModel->getCart($_SESSION['user_id']);
            $total_amount = $this->cartModel->calculateCartTotal($_SESSION['user_id']);
        } elseif (isset($_SESSION['cart_id'])) {
            $cart_items = $this->cartModel->getCart(null, $_SESSION['cart_id']);
            $total_amount = $this->cartModel->calculateCartTotal(null, $_SESSION['cart_id']);
        }
        
        if (empty($cart_items)) {
            $_SESSION['error'] = 'Giỏ hàng của bạn đang trống.';
            header('Location: index.php?page=cart');
            exit;
        }
        
        // Thông tin người dùng
        $user = null;
        if (isset($_SESSION['user_id'])) {
            require_once 'Model/UserModel.php';
            $userModel = new UserModel();
            $user = $userModel->getUserById($_SESSION['user_id']);
        } else {
            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
            $_SESSION['error'] = 'Vui lòng đăng nhập để thanh toán.';
            $_SESSION['redirect_after_login'] = 'index.php?page=checkout';
            header('Location: index.php?page=login');
            exit;
        }
        
        // Tính phí vận chuyển, thuế, v.v.
        $shipping_fee = 0;
        if ($total_amount < 5000000) {
            $shipping_fee = 50000; // Phí vận chuyển tiêu chuẩn
        }
        
        $tax_amount = $total_amount * 0.1; // Thuế VAT 10%
        $discount_amount = 0; // Giảm giá (nếu có)
        $final_amount = $total_amount + $shipping_fee + $tax_amount - $discount_amount;
        
        // Truyền dữ liệu sang view
        $title = "Thanh toán";
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/checkout.php';
        include VIEW_PATH . '/includes/footer.php';
    }
    
    // Xử lý đặt hàng
    public function placeOrder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }
        
        // Kiểm tra giỏ hàng có sản phẩm không
        $cart_items = [];
        $total_amount = 0;
        
        if (isset($_SESSION['user_id'])) {
            $cart_items = $this->cartModel->getCart($_SESSION['user_id']);
            $total_amount = $this->cartModel->calculateCartTotal($_SESSION['user_id']);
        } elseif (isset($_SESSION['cart_id'])) {
            $cart_items = $this->cartModel->getCart(null, $_SESSION['cart_id']);
            $total_amount = $this->cartModel->calculateCartTotal(null, $_SESSION['cart_id']);
        }
        
        if (empty($cart_items)) {
            $_SESSION['error'] = 'Giỏ hàng của bạn đang trống.';
            header('Location: index.php?page=cart');
            exit;
        }
        
        // Lấy thông tin từ form
        $name = isset($_POST['first_name']) && isset($_POST['last_name']) ? 
            trim($_POST['first_name'] . ' ' . $_POST['last_name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';
        $city = isset($_POST['city']) ? trim($_POST['city']) : '';
        $district = isset($_POST['district']) ? trim($_POST['district']) : '';
        $ward = isset($_POST['ward']) ? trim($_POST['ward']) : '';
        $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
        $shipping_method = isset($_POST['shipping_method']) ? $_POST['shipping_method'] : '';
        $notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';
        
        // Kiểm tra thông tin
        if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($city) || empty($district) || empty($ward) || empty($payment_method) || empty($shipping_method)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin.';
            header('Location: index.php?page=checkout');
            exit;
        }
        
        // Tạo tài khoản mới nếu người dùng chọn
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        
        if (!$user_id && isset($_POST['create_account']) && $_POST['create_account'] == '1') {
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            
            if (empty($password) || $password !== $confirm_password) {
                $_SESSION['error'] = 'Mật khẩu không hợp lệ hoặc không khớp.';
                header('Location: index.php?page=checkout');
                exit;
            }
            
            require_once 'Model/UserModel.php';
            $userModel = new UserModel();
            $register_result = $userModel->register($name, $email, $password, $phone);
            
            if ($register_result) {
                // Đăng nhập tài khoản mới
                $user = $userModel->login($email, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['user_name'] = $user->name;
                    $_SESSION['user_email'] = $user->email;
                    $_SESSION['user_role'] = $user->role;
                    
                    $user_id = $user->id;
                    
                    // Chuyển giỏ hàng từ session sang user
                    if (isset($_SESSION['cart_id'])) {
                        $this->cartModel->mergeCart($user_id, $_SESSION['cart_id']);
                        unset($_SESSION['cart_id']);
                        
                        // Lấy lại giỏ hàng
                        $cart_items = $this->cartModel->getCart($user_id);
                    }
                }
            }
        }
        
        // Tính phí vận chuyển, thuế, v.v.
        $shipping_fee = 0;
        switch ($shipping_method) {
            case 'standard':
                $shipping_fee = $total_amount >= 5000000 ? 0 : 50000;
                break;
            case 'express':
                $shipping_fee = 50000;
                break;
            case 'same_day':
                $shipping_fee = 100000;
                break;
        }
        
        $tax_amount = $total_amount * 0.1; // Thuế VAT 10%
        $discount_amount = 0; // Giảm giá (nếu có)
        $final_amount = $total_amount + $shipping_fee + $tax_amount - $discount_amount;
        
        // Tạo đơn hàng
        $order_id = $this->cartModel->createOrder(
            $user_id, $name, $email, $phone, $address, $city, $district, $ward,
            $final_amount, $shipping_fee, $discount_amount, $tax_amount,
            $payment_method, $shipping_method, $notes
        );
        
        if ($order_id) {
            // Thêm các sản phẩm vào đơn hàng
            $this->cartModel->addOrderItems($order_id, $cart_items);
            
            // Xóa giỏ hàng
            if ($user_id) {
                $this->cartModel->clearCart($user_id);
            } elseif (isset($_SESSION['cart_id'])) {
                $this->cartModel->clearCart(null, $_SESSION['cart_id']);
            }
            
            $_SESSION['success'] = 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng tại CameraVN.';
            
            if ($payment_method == 'bank_transfer') {
                // Chuyển đến trang hướng dẫn thanh toán chuyển khoản
                header('Location: index.php?page=order_success&id=' . $order_id . '&payment=bank');
            } else {
                // Chuyển đến trang thông báo đặt hàng thành công
                header('Location: index.php?page=order_success&id=' . $order_id);
            }
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại sau.';
            header('Location: index.php?page=checkout');
        }
        
        exit;
    }
    
    // Xử lý trang đặt hàng thành công
    public function orderSuccess() {
        $order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $payment_type = isset($_GET['payment']) ? $_GET['payment'] : '';
        
        if ($order_id <= 0) {
            header('Location: index.php');
            exit;
        }
        
        // Lấy thông tin đơn hàng
        $order = null;
        $order_items = [];
        
        if (isset($_SESSION['user_id'])) {
            require_once 'Model/UserModel.php';
            $userModel = new UserModel();
            $order = $userModel->getOrderById($order_id, $_SESSION['user_id']);
            if ($order) {
                $order_items = $userModel->getOrderItems($order_id);
            }
        }
        
        // Truyền dữ liệu sang view
        $title = "Đặt hàng thành công";
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/order_success.php';
        include VIEW_PATH . '/includes/footer.php';
    }
    
    // Endpoint API để lấy thông tin giỏ hàng cho AJAX
    public function ajaxCart() {
        header('Content-Type: application/json');
        
        $cart_items = [];
        $total_amount = 0;
        
        if (isset($_SESSION['user_id'])) {
            $cart_items = $this->cartModel->getCart($_SESSION['user_id']);
            $total_amount = $this->cartModel->calculateCartTotal($_SESSION['user_id']);
        } elseif (isset($_SESSION['cart_id'])) {
            $cart_items = $this->cartModel->getCart(null, $_SESSION['cart_id']);
            $total_amount = $this->cartModel->calculateCartTotal(null, $_SESSION['cart_id']);
        }
        
        echo json_encode([
            'items' => $cart_items,
            'total_amount' => $total_amount,
            'formatted_total' => number_format($total_amount, 0, ',', '.') . 'đ'
        ]);
        exit;
    }
    
    // Endpoint API để lấy số lượng sản phẩm trong giỏ hàng cho AJAX
    public function ajaxCartCount() {
        header('Content-Type: application/json');
        
        $count = 0;
        
        if (isset($_SESSION['user_id'])) {
            $count = $this->cartModel->countCartItems($_SESSION['user_id']);
        } elseif (isset($_SESSION['cart_id'])) {
            $count = $this->cartModel->countCartItems(null, $_SESSION['cart_id']);
        }
        
        echo json_encode(['count' => $count]);
        exit;
    }
}