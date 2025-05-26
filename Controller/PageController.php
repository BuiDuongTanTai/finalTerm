<?php
// Controller/PageController.php - Controller xử lý các trang cơ bản

require_once MODEL_PATH . '/ProductModel.php';
require_once MODEL_PATH . '/BlogModel.php'; // Thêm BlogModel

class PageController {
    public function home() {
        $title = "Trang chủ";
        
        // Get products with badge system
        $productModel = new ProductModel();
        
        // Sản phẩm nổi bật (HOT + BESTSELLER + is_featured)
        $featured_products = $productModel->getFeaturedProductsWithBadge(6);
        
        // Sản phẩm mới (NEW badge + is_new)
        $new_products = $productModel->getNewProductsWithBadge(6);
        
        // Sản phẩm bán chạy (BESTSELLER badge + sold_count cao)
        $bestselling_products = $productModel->getBestsellerProducts(6);
        
        // Sản phẩm giảm giá (DISCOUNT badge + có old_price)
        $discount_products = $productModel->getDiscountProductsWithBadge(6);
        
        // Load view
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/homepage.php';
        include VIEW_PATH . '/includes/footer.php';
    }
    
    public function contact() {
        $title = "Liên hệ";
        
        // Load view
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/contact.php';
        include VIEW_PATH . '/includes/footer.php';
    }
    
    public function blog() {
        $title = "Blog nhiếp ảnh";
        
        // Lấy trang hiện tại từ URL
        $current_page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $per_page = 6; // Số bài viết mỗi trang
        
        // Lấy category từ URL nếu có
        $category_slug = isset($_GET['category']) ? $_GET['category'] : null;
        
        // Lấy dữ liệu blog và danh mục từ Model
        $blogModel = new BlogModel();
        $published_blogs = $blogModel->getAllBlogs('published', null, $category_slug, $current_page, $per_page);
        $total_blogs = $blogModel->getTotalBlogs('published', null, $category_slug);
        $categories = $blogModel->getAllCategories();
        $popular_posts = $blogModel->getFeaturedPosts(5); // Lấy 5 bài nổi bật nhất

        // Tính toán số trang
        $total_pages = ceil($total_blogs / $per_page);

        // Load view và truyền dữ liệu
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/blog.php'; // Truyền các biến: $title, $published_blogs, $categories, $popular_posts, $current_page, $total_pages
        include VIEW_PATH . '/includes/footer.php';
    }
    
    public function error404() {
        $title = "Không tìm thấy trang";
        
        // Load view
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/error404.php';
        include VIEW_PATH . '/includes/footer.php';
    }
    
    public function termsOfUse() {
        $title = "Điều khoản sử dụng";
        
        // Load view
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/termsofuse.php';
        include VIEW_PATH . '/includes/footer.php';
    }

    public function about() {
        $title = "Về chúng tôi";
        
        // Load view
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/about.php';
        include VIEW_PATH . '/includes/footer.php';
    }
}