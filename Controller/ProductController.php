<?php
// Controller/ProductController.php - Controller xử lý sản phẩm

require_once 'Model/ProductModel.php';

class ProductController {
    private $productModel;
    
    public function __construct() {
        $this->productModel = new ProductModel();
    }
    
    // Xử lý trang danh sách sản phẩm
    public function allProducts() {
        // Lấy tham số từ URL
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'popular';
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        $brand = isset($_GET['brand']) ? $_GET['brand'] : '';
        $min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
        $max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 0;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
        
        // Xử lý price_range nếu có
        if (isset($_GET['price_range']) && !empty($_GET['price_range'])) {
            $price_range = explode('-', $_GET['price_range']);
            if (count($price_range) == 2) {
                $min_price = (int)$price_range[0];
                $max_price = (int)$price_range[1];
            }
        }
        
        // Thiết lập phân trang
        $items_per_page = 12;
        $offset = ($page - 1) * $items_per_page;
        
        // Lấy tổng số sản phẩm
        $total_products = $this->productModel->countProducts($category, $brand, $min_price, $max_price, $search);
        $total_pages = ceil($total_products / $items_per_page);
        
        // Lấy danh sách sản phẩm
        $products = $this->productModel->getAllProducts(
            $sort, $category, $brand, $min_price, $max_price, $search, $items_per_page, $offset
        );
        
        // Lấy danh sách danh mục và thương hiệu cho bộ lọc
        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();
        
        // Nếu người dùng đã đăng nhập, lấy danh sách yêu thích
        $wishlist = [];
        if (isset($_SESSION['user_id'])) {
            $wishlist_products = $this->productModel->getUserWishlist($_SESSION['user_id']);
            foreach ($wishlist_products as $product) {
                $wishlist[] = $product->id;
            }
        }
        
        // Truyền dữ liệu sang view
        $title = "Tất cả sản phẩm";
        if (!empty($search)) {
            $title = "Kết quả tìm kiếm: " . $search;
        } elseif (!empty($category)) {
            foreach ($categories as $cat) {
                if ($cat->slug == $category) {
                    $title = "Danh mục: " . $cat->name;
                    break;
                }
            }
        } elseif (!empty($brand)) {
            foreach ($brands as $b) {
                if ($b->slug == $brand) {
                    $title = "Thương hiệu: " . $b->name;
                    break;
                }
            }
        }
        
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/all_products.php';
        include VIEW_PATH . '/includes/footer.php';
    }
    
    // Xử lý trang chi tiết sản phẩm
    public function productDetail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            header('Location: index.php?page=all_products');
            exit;
        }
        
        // Lấy thông tin sản phẩm
        $product = $this->productModel->getProductById($id);
        
        if (!$product) {
            header('Location: index.php?page=error404');
            exit;
        }
        
        // Lấy sản phẩm liên quan
        $related_products = $this->productModel->getRelatedProducts($id, $product->category_id);
        
        // Lấy đánh giá sản phẩm
        $reviews = $this->productModel->getProductReviews($id);
        $total_reviews = $this->productModel->countProductReviews($id);
        
        // Kiểm tra sản phẩm có trong danh sách yêu thích không
        $is_in_wishlist = false;
        if (isset($_SESSION['user_id'])) {
            $is_in_wishlist = $this->productModel->isInWishlist($_SESSION['user_id'], $id);
        }
        
        // Truyền dữ liệu sang view
        $title = $product->name . " - " . $product->brand_name;
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/product_detail.php';
        include VIEW_PATH . '/includes/footer.php';
    }
    
    // Xử lý thêm đánh giá sản phẩm
    public function addReview() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }
        
        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
        
        if ($product_id <= 0 || $rating <= 0 || $rating > 5 || empty($title) || empty($comment)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin đánh giá.';
            header('Location: index.php?page=product_detail&id=' . $product_id);
            exit;
        }
        
        // Thông tin người dùng
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        
        if (!$user_id && (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin cá nhân.';
            header('Location: index.php?page=product_detail&id=' . $product_id);
            exit;
        }
        
        // Lấy thông tin người dùng nếu đã đăng nhập
        if ($user_id) {
            require_once 'Model/UserModel.php';
            $userModel = new UserModel();
            $user = $userModel->getUserById($user_id);
            if ($user) {
                $name = $user->name;
                $email = $user->email;
            }
        }
        
        // Xử lý hình ảnh (nếu có)
        $images = [];
        if (isset($_FILES['images']) && is_array($_FILES['images']['name'])) {
            $upload_dir = REVIEW_IMG_PATH;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $filename = uniqid() . '_' . $_FILES['images']['name'][$key];
                    $destination = $upload_dir . $filename;
                    
                    if (move_uploaded_file($tmp_name, $destination)) {
                        $images[] = $destination;
                    }
                }
            }
        }
        
        // Thêm đánh giá
        $success = $this->productModel->addReview($product_id, $user_id, $name, $email, $rating, $title, $comment, $images);
        
        if ($success) {
            // Cập nhật xếp hạng sản phẩm
            $this->productModel->updateProductRating($product_id);
            
            $_SESSION['success'] = 'Cảm ơn bạn đã đánh giá sản phẩm. Đánh giá của bạn sẽ được hiển thị sau khi được phê duyệt.';
        } else {
            $_SESSION['error'] = 'Đã xảy ra lỗi khi gửi đánh giá. Vui lòng thử lại sau.';
        }
        
        header('Location: index.php?page=product_detail&id=' . $product_id);
        exit;
    }
    
    // Xử lý thêm sản phẩm vào danh sách yêu thích
    public function addToWishlist() {
        // Kiểm tra Ajax request
        if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
            header('Location: index.php');
            exit;
        }
        
        // Cần đăng nhập để sử dụng chức năng yêu thích
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào danh sách yêu thích.']);
            exit;
        }
        
        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        
        if ($product_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không hợp lệ.']);
            exit;
        }
        
        $success = $this->productModel->addToWishlist($_SESSION['user_id'], $product_id);
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Đã thêm sản phẩm vào danh sách yêu thích.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Đã xảy ra lỗi. Vui lòng thử lại sau.']);
        }
        exit;
    }
    
    // Xử lý xóa sản phẩm khỏi danh sách yêu thích
    public function removeFromWishlist() {
        // Kiểm tra Ajax request
        if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
            header('Location: index.php');
            exit;
        }
        
        // Cần đăng nhập để sử dụng chức năng yêu thích
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để xóa sản phẩm khỏi danh sách yêu thích.']);
            exit;
        }
        
        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        
        if ($product_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không hợp lệ.']);
            exit;
        }
        
        $success = $this->productModel->removeFromWishlist($_SESSION['user_id'], $product_id);
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Đã xảy ra lỗi. Vui lòng thử lại sau.']);
        }
        exit;
    }
    
    // Xử lý xem danh sách sản phẩm yêu thích
    public function viewWishlist() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem danh sách yêu thích.';
            $_SESSION['redirect_after_login'] = 'index.php?page=wishlist';
            header('Location: index.php?page=login');
            exit;
        }
        
        $wishlist_products = $this->productModel->getUserWishlist($_SESSION['user_id']);
        
        // Truyền dữ liệu sang view
        $title = "Danh sách yêu thích";
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/user/wishlist.php';
        include VIEW_PATH . '/includes/footer.php';
    }

    // Endpoint API để lấy thông tin sản phẩm cho AJAX
    public function ajaxProduct() {
        header('Content-Type: application/json');
        
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            echo json_encode(['error' => 'Invalid product ID']);
            exit;
        }
        
        // Lấy thông tin sản phẩm
        $product = $this->productModel->getProductById($id);
        
        if (!$product) {
            echo json_encode(['error' => 'Product not found']);
            exit;
        }
        
        // Kiểm tra sản phẩm có trong danh sách yêu thích không
        $is_in_wishlist = false;
        if (isset($_SESSION['user_id'])) {
            $is_in_wishlist = $this->productModel->isInWishlist($_SESSION['user_id'], $id);
        }
        
        // Thêm thông tin vào sản phẩm
        $product->in_wishlist = $is_in_wishlist;
        
        // Chuyển đổi các JSON string thành arrays
        if (isset($product->images) && !empty($product->images)) {
            $product->images = json_decode($product->images);
        }
        if (isset($product->colors) && !empty($product->colors)) {
            $product->colors = json_decode($product->colors);
        }
        if (isset($product->variations) && !empty($product->variations)) {
            $product->variations = json_decode($product->variations);
        }
        if (isset($product->specifications) && !empty($product->specifications)) {
            $product->specifications = json_decode($product->specifications);
        }
        
        echo json_encode($product);
        exit;
    }
}