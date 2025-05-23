<?php
// index.php - File chính của website
session_start(); // Start session

// Định nghĩa đường dẫn cơ bản
define('BASE_PATH', __DIR__);
define('VIEW_PATH', BASE_PATH . '/View');
define('MODEL_PATH', BASE_PATH . '/Model');
define('CONTROLLER_PATH', BASE_PATH . '/Controller');

// Require config file
require_once MODEL_PATH . '/config.php';

// Autoload function
function autoloadClasses($class_name) {
    // Controller
    $controller_path = CONTROLLER_PATH . '/' . $class_name . '.php';
    if (file_exists($controller_path)) {
        require_once $controller_path;
        return;
    }
    
    // Model
    $model_path = MODEL_PATH . '/' . $class_name . '.php';
    if (file_exists($model_path)) {
        require_once $model_path;
        return;
    }
}

// Register autoload function
spl_autoload_register('autoloadClasses');

// Create Router
class Router {
    private $controller;
    private $method;
    private $params = [];
    
    public function __construct() {
        $this->processURL();
        $this->callController();
    }
    
    private function processURL() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        
        switch ($page) {
            case 'all_products':
                $this->controller = 'ProductController';
                $this->method = 'allProducts';
                break;
                
            case 'product_detail':
                $this->controller = 'ProductController';
                $this->method = 'productDetail';
                break;
                
            case 'add_to_cart':
                $this->controller = 'CartController';
                $this->method = 'addToCart';
                break;
                
            case 'cart':
                $this->controller = 'CartController';
                $this->method = 'viewCart';
                break;
                
            case 'update_cart':
                $this->controller = 'CartController';
                $this->method = 'updateCart';
                break;
                
            case 'remove_from_cart':
                $this->controller = 'CartController';
                $this->method = 'removeFromCart';
                break;
                
            case 'checkout':
                $this->controller = 'CartController';
                $this->method = 'checkout';
                break;
                
            case 'place_order':
                $this->controller = 'CartController';
                $this->method = 'placeOrder';
                break;
                
            case 'login':
                $this->controller = 'UserController';
                $this->method = 'login';
                break;
                
            case 'register':
                $this->controller = 'UserController';
                $this->method = 'register';
                break;
                
            case 'logout':
                $this->controller = 'UserController';
                $this->method = 'logout';
                break;
                
            case 'profile':
                $this->controller = 'UserController';
                $this->method = 'profile';
                break;
                
            case 'update_profile':
                $this->controller = 'UserController';
                $this->method = 'updateProfile';
                break;
                
            case 'change_password':
                $this->controller = 'UserController';
                $this->method = 'changePassword';
                break;
                
            case 'about':
                $this->controller = 'PageController';
                $this->method = 'about';
                break;
                
            case 'contact':
                $this->controller = 'PageController';
                $this->method = 'contact';
                break;
                
            case 'blog':
                $this->controller = 'PageController';
                $this->method = 'blog';
                break;
                
            case 'error404':
                $this->controller = 'PageController';
                $this->method = 'error404';
                break;
                
            case 'add_to_wishlist':
                $this->controller = 'ProductController';
                $this->method = 'addToWishlist';
                break;
                
            case 'remove_from_wishlist':
                $this->controller = 'ProductController';
                $this->method = 'removeFromWishlist';
                break;
                
            case 'wishlist':
                $this->controller = 'ProductController';
                $this->method = 'viewWishlist';
                break;
                
            case 'add_review':
                $this->controller = 'ProductController';
                $this->method = 'addReview';
                break;
                
            case 'termsofuse':
                $this->controller = 'PageController';
                $this->method = 'termsOfUse';
                break;
                
            case 'ajax_product':
                $this->controller = 'ProductController';
                $this->method = 'ajaxProduct';
                break;
                
            case 'ajax_cart':
                $this->controller = 'CartController';
                $this->method = 'ajaxCart';
                break;
                
            case 'ajax_cart_count':
                $this->controller = 'CartController';
                $this->method = 'ajaxCartCount';
                break;
                
            case 'clear_cart':
                $this->controller = 'CartController';
                $this->method = 'clearCart';
                break;
                
            case 'order_success':
                $this->controller = 'CartController';
                $this->method = 'orderSuccess';
                break;
                
            case 'order_detail':
                $this->controller = 'UserController';
                $this->method = 'orderDetail';
                break;
                
            default:
                $this->controller = 'PageController';
                $this->method = 'home';
                break;
        }
    }
    
    private function callController() {
        if (class_exists($this->controller)) {
            $controller = new $this->controller();
            
            if (method_exists($controller, $this->method)) {
                call_user_func_array([$controller, $this->method], $this->params);
            } else {
                // Method not found - show 404
                $page_controller = new PageController();
                $page_controller->error404();
            }
        } else {
            // Controller not found - show 404
            require_once CONTROLLER_PATH . '/PageController.php';
            $page_controller = new PageController();
            $page_controller->error404();
        }
    }
}

// Initialize Router
$router = new Router();