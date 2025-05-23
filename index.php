<?php
// index.php - Entry point

// Bắt đầu session
session_start();

// Thiết lập timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Định nghĩa hằng số cơ bản
define('ROOT_PATH', __DIR__);
define('MODEL_PATH', ROOT_PATH . '/Model');
define('VIEW_PATH', ROOT_PATH . '/View');
define('CONTROLLER_PATH', ROOT_PATH . '/Controller');

// Load config file
require_once MODEL_PATH . '/config.php';

// Xác định trang hiện tại
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Xử lý yêu cầu dựa trên $page
switch ($page) {
    case 'home':
        require_once CONTROLLER_PATH . '/PageController.php';
        $pageController = new PageController();
        $pageController->home();
        break;
        
    case 'about':
        require_once CONTROLLER_PATH . '/PageController.php';
        $pageController = new PageController();
        $pageController->about();
        break;
        
    case 'contact':
        require_once CONTROLLER_PATH . '/PageController.php';
        $pageController = new PageController();
        $pageController->contact();
        break;
        
    case 'blog':
        require_once CONTROLLER_PATH . '/PageController.php';
        $pageController = new PageController();
        $pageController->blog();
        break;
        
    case 'all_products':
        require_once CONTROLLER_PATH . '/ProductController.php';
        $productController = new ProductController();
        $productController->allProducts();
        break;
        
    case 'product_detail':
        require_once CONTROLLER_PATH . '/ProductController.php';
        $productController = new ProductController();
        $productController->productDetail();
        break;
        
    case 'add_review':
        require_once CONTROLLER_PATH . '/ProductController.php';
        $productController = new ProductController();
        $productController->addReview();
        break;
        
    case 'wishlist':
        require_once CONTROLLER_PATH . '/ProductController.php';
        $productController = new ProductController();
        $productController->viewWishlist();
        break;
        
    case 'add_to_wishlist':
        require_once CONTROLLER_PATH . '/ProductController.php';
        $productController = new ProductController();
        $productController->addToWishlist();
        break;
        
    case 'remove_from_wishlist':
        require_once CONTROLLER_PATH . '/ProductController.php';
        $productController = new ProductController();
        $productController->removeFromWishlist();
        break;
        
    case 'ajax_product':
        require_once CONTROLLER_PATH . '/ProductController.php';
        $productController = new ProductController();
        $productController->ajaxProduct();
        break;
        
    case 'cart':
        require_once CONTROLLER_PATH . '/CartController.php';
        $cartController = new CartController();
        $cartController->viewCart();
        break;
        
    case 'add_to_cart':
        require_once CONTROLLER_PATH . '/CartController.php';
        $cartController = new CartController();
        $cartController->addToCart();
        break;
        
    case 'update_cart':
        require_once CONTROLLER_PATH . '/CartController.php';
        $cartController = new CartController();
        $cartController->updateCart();
        break;
        
    case 'remove_from_cart':
        require_once CONTROLLER_PATH . '/CartController.php';
        $cartController = new CartController();
        $cartController->removeFromCart();
        break;
        
    case 'clear_cart':
        require_once CONTROLLER_PATH . '/CartController.php';
        $cartController = new CartController();
        $cartController->clearCart();
        break;
        
    case 'checkout':
        require_once CONTROLLER_PATH . '/CartController.php';
        $cartController = new CartController();
        $cartController->checkout();
        break;
        
    case 'place_order':
        require_once CONTROLLER_PATH . '/CartController.php';
        $cartController = new CartController();
        $cartController->placeOrder();
        break;
        
    case 'order_success':
        require_once CONTROLLER_PATH . '/CartController.php';
        $cartController = new CartController();
        $cartController->orderSuccess();
        break;
        
    case 'ajax_cart':
        require_once CONTROLLER_PATH . '/CartController.php';
        $cartController = new CartController();
        $cartController->ajaxCart();
        break;
        
    case 'ajax_cart_count':
        require_once CONTROLLER_PATH . '/CartController.php';
        $cartController = new CartController();
        $cartController->ajaxCartCount();
        break;
        
    case 'register':
        require_once CONTROLLER_PATH . '/UserController.php';
        $userController = new UserController();
        $userController->register();
        break;
        
    case 'login':
        require_once CONTROLLER_PATH . '/UserController.php';
        $userController = new UserController();
        $userController->login();
        break;
        
    case 'logout':
        require_once CONTROLLER_PATH . '/UserController.php';
        $userController = new UserController();
        $userController->logout();
        break;
        
    case 'profile':
        require_once CONTROLLER_PATH . '/UserController.php';
        $userController = new UserController();
        $userController->profile();
        break;
        
    case 'update_profile':
        require_once CONTROLLER_PATH . '/UserController.php';
        $userController = new UserController();
        $userController->updateProfile();
        break;
        
    case 'change_password':
        require_once CONTROLLER_PATH . '/UserController.php';
        $userController = new UserController();
        $userController->changePassword();
        break;
        
    case 'order_detail':
        require_once CONTROLLER_PATH . '/UserController.php';
        $userController = new UserController();
        $userController->orderDetail();
        break;
        
    case 'termsofuse':
        require_once CONTROLLER_PATH . '/PageController.php';
        $pageController = new PageController();
        $pageController->termsOfUse();
        break;
        
    // ========== ROUTES CHO SẢN PHẨM ĐÃ XEM GẦN ĐÂY ==========
    case 'recently_viewed':
        require_once CONTROLLER_PATH . '/ProductController.php';
        $productController = new ProductController();
        $productController->recentlyViewed();
        break;
        
    case 'clear_recently_viewed':
        require_once CONTROLLER_PATH . '/ProductController.php';
        $productController = new ProductController();
        $productController->clearRecentlyViewed();
        break;
        
    case 'ajax_save_recently_viewed':
        require_once CONTROLLER_PATH . '/ProductController.php';
        $productController = new ProductController();
        $productController->ajaxSaveRecentlyViewed();
        break;
    // ========== KẾT THÚC ROUTES SẢN PHẨM ĐÃ XEM GẦN ĐÂY ==========
        
    case 'error404':
    default:
        require_once CONTROLLER_PATH . '/PageController.php';
        $pageController = new PageController();
        $pageController->error404();
        break;
}