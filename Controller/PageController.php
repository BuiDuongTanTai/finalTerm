<?php
// Controller/PageController.php - Controller xử lý các trang cơ bản

class PageController {
    public function home() {
        $title = "Trang chủ";
        
        // Get featured products
        require_once MODEL_PATH . '/ProductModel.php';
        $productModel = new ProductModel();
        $featured_products = $productModel->getFeaturedProducts();
        $new_products = $productModel->getNewProducts();
        $bestselling_products = $productModel->getBestSellingProducts();
        
        // Load view
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/homepage.php';
        include VIEW_PATH . '/includes/footer.php';
    }
    
    public function about() {
        $title = "Giới thiệu";
        
        // Load view
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/about.php';
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
        
        // Load view
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/blog.php';
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
}