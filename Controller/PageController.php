<?php
// Controller/PageController.php - Controller xử lý các trang cơ bản

class PageController {
    public function home() {
        $title = "Trang chủ";
        
        // Get products with badge system
        require_once MODEL_PATH . '/ProductModel.php';
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

    public function about() {
        $title = "Về chúng tôi";
        
        // Load view
        include VIEW_PATH . '/includes/header.php';
        include VIEW_PATH . '/includes/navbar.php';
        include VIEW_PATH . '/page/about.php';
        include VIEW_PATH . '/includes/footer.php';
    }
}