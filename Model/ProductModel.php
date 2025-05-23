<?php
// Model/ProductModel.php - Model xử lý sản phẩm

require_once 'Model/Database.php';

class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts($sort = 'popular', $category = '', $brand = '', $min_price = 0, $max_price = 0, $search = '', $limit = 0, $offset = 0) {
        $params = [];
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name FROM products p 
                  JOIN categories c ON p.category_id = c.id 
                  JOIN brands b ON p.brand_id = b.id 
                  WHERE p.status = 1 ";

        // Lọc theo danh mục
        if (!empty($category)) {
            $query .= "AND c.slug = ? ";
            $params[] = $category;
        }

        // Lọc theo thương hiệu
        if (!empty($brand)) {
            $query .= "AND b.slug = ? ";
            $params[] = $brand;
        }

        // Lọc theo giá
        if ($min_price > 0 && $max_price > 0) {
            $query .= "AND p.price BETWEEN ? AND ? ";
            $params[] = $min_price;
            $params[] = $max_price;
        } elseif ($min_price > 0) {
            $query .= "AND p.price >= ? ";
            $params[] = $min_price;
        } elseif ($max_price > 0) {
            $query .= "AND p.price <= ? ";
            $params[] = $max_price;
        }

        // Tìm kiếm
        if (!empty($search)) {
            $query .= "AND (p.name LIKE ? OR p.short_description LIKE ? OR p.description LIKE ?) ";
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
        }

        // Sắp xếp
        switch ($sort) {
            case 'newest':
                $query .= "ORDER BY p.created_at DESC ";
                break;
            case 'price-asc':
                $query .= "ORDER BY p.price ASC ";
                break;
            case 'price-desc':
                $query .= "ORDER BY p.price DESC ";
                break;
            case 'rating':
                $query .= "ORDER BY p.rating DESC ";
                break;
            case 'discount':
                $query .= "ORDER BY ((p.old_price - p.price) / p.old_price) DESC ";
                break;
            default: // popular
                $query .= "ORDER BY p.sold_count DESC ";
                break;
        }

        // Giới hạn kết quả
        if ($limit > 0) {
            $query .= "LIMIT ?, ?";
            $params[] = $offset;
            $params[] = $limit;
        }

        return $this->db->fetchAll($query, $params);
    }

    // Đếm tổng số sản phẩm (cho phân trang)
    public function countProducts($category = '', $brand = '', $min_price = 0, $max_price = 0, $search = '') {
        $params = [];
        $query = "SELECT COUNT(*) as total FROM products p 
                  JOIN categories c ON p.category_id = c.id 
                  JOIN brands b ON p.brand_id = b.id 
                  WHERE p.status = 1 ";

        // Lọc theo danh mục
        if (!empty($category)) {
            $query .= "AND c.slug = ? ";
            $params[] = $category;
        }

        // Lọc theo thương hiệu
        if (!empty($brand)) {
            $query .= "AND b.slug = ? ";
            $params[] = $brand;
        }

        // Lọc theo giá
        if ($min_price > 0 && $max_price > 0) {
            $query .= "AND p.price BETWEEN ? AND ? ";
            $params[] = $min_price;
            $params[] = $max_price;
        } elseif ($min_price > 0) {
            $query .= "AND p.price >= ? ";
            $params[] = $min_price;
        } elseif ($max_price > 0) {
            $query .= "AND p.price <= ? ";
            $params[] = $max_price;
        }

        // Tìm kiếm
        if (!empty($search)) {
            $query .= "AND (p.name LIKE ? OR p.short_description LIKE ? OR p.description LIKE ?) ";
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
        }

        $result = $this->db->fetchOne($query, $params);
        return $result ? $result->total : 0;
    }

    // Lấy chi tiết sản phẩm theo ID
    public function getProductById($id) {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name FROM products p 
                  JOIN categories c ON p.category_id = c.id 
                  JOIN brands b ON p.brand_id = b.id 
                  WHERE p.id = ? AND p.status = 1";
        return $this->db->fetchOne($query, [$id]);
    }

    // Lấy chi tiết sản phẩm theo Slug
    public function getProductBySlug($slug) {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name FROM products p 
                  JOIN categories c ON p.category_id = c.id 
                  JOIN brands b ON p.brand_id = b.id 
                  WHERE p.slug = ? AND p.status = 1";
        return $this->db->fetchOne($query, [$slug]);
    }

    // Lấy sản phẩm nổi bật
    public function getFeaturedProducts($limit = 6) {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name FROM products p 
                  JOIN categories c ON p.category_id = c.id 
                  JOIN brands b ON p.brand_id = b.id 
                  WHERE p.status = 1 AND p.is_featured = 1 
                  ORDER BY p.sold_count DESC 
                  LIMIT ?";
        return $this->db->fetchAll($query, [$limit]);
    }

    // Lấy sản phẩm mới
    public function getNewProducts($limit = 6) {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name FROM products p 
                  JOIN categories c ON p.category_id = c.id 
                  JOIN brands b ON p.brand_id = b.id 
                  WHERE p.status = 1 AND p.is_new = 1 
                  ORDER BY p.created_at DESC 
                  LIMIT ?";
        return $this->db->fetchAll($query, [$limit]);
    }

    // Lấy sản phẩm bán chạy
    public function getBestSellingProducts($limit = 6) {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name FROM products p 
                  JOIN categories c ON p.category_id = c.id 
                  JOIN brands b ON p.brand_id = b.id 
                  WHERE p.status = 1 
                  ORDER BY p.sold_count DESC 
                  LIMIT ?";
        return $this->db->fetchAll($query, [$limit]);
    }

    // Lấy sản phẩm đang giảm giá
    public function getDiscountedProducts($limit = 6) {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN brands b ON p.brand_id = b.id 
                    WHERE p.status = 1 AND p.old_price > 0 AND p.old_price > p.price 
                    ORDER BY (p.old_price - p.price) / p.old_price DESC 
                    LIMIT ?";
        return $this->db->fetchAll($query, [$limit]);
    }

    // Lấy sản phẩm liên quan
    public function getRelatedProducts($product_id, $category_id, $limit = 4) {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN brands b ON p.brand_id = b.id 
                    WHERE p.status = 1 AND p.id != ? AND p.category_id = ? 
                    ORDER BY p.sold_count DESC 
                    LIMIT ?";
        return $this->db->fetchAll($query, [$product_id, $category_id, $limit]);
    }

    // Lấy tất cả danh mục
    public function getAllCategories() {
        $query = "SELECT * FROM categories WHERE status = 1 ORDER BY name ASC";
        return $this->db->fetchAll($query);
    }

    // Lấy tất cả thương hiệu
    public function getAllBrands() {
        $query = "SELECT * FROM brands WHERE status = 1 ORDER BY name ASC";
        return $this->db->fetchAll($query);
    }

    // Lấy danh sách đánh giá của sản phẩm
    public function getProductReviews($product_id, $limit = 5, $offset = 0) {
        $query = "SELECT r.*, u.name as user_name, u.avatar as user_avatar 
                    FROM reviews r 
                    LEFT JOIN users u ON r.user_id = u.id 
                    WHERE r.product_id = ? AND r.status = 'approved' 
                    ORDER BY r.created_at DESC 
                    LIMIT ?, ?";
        return $this->db->fetchAll($query, [$product_id, $offset, $limit]);
    }

    // Đếm số lượng đánh giá của sản phẩm
    public function countProductReviews($product_id) {
        $query = "SELECT COUNT(*) as total FROM reviews WHERE product_id = ? AND status = 'approved'";
        $result = $this->db->fetchOne($query, [$product_id]);
        return $result ? $result->total : 0;
    }

    // Thêm đánh giá sản phẩm
    public function addReview($product_id, $user_id, $name, $email, $rating, $title, $comment, $images = null) {
        $query = "INSERT INTO reviews (product_id, user_id, name, email, rating, title, comment, images) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $images_json = $images ? json_encode($images) : null;
        return $this->db->execute($query, [$product_id, $user_id, $name, $email, $rating, $title, $comment, $images_json]);
    }

    // Cập nhật xếp hạng sản phẩm sau khi có đánh giá mới
    public function updateProductRating($product_id) {
        $query = "SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM reviews
                    WHERE product_id = ? AND status = 'approved'";
        $result = $this->db->fetchOne($query, [$product_id]);
        
        if ($result && $result->total > 0) {
            $update_query = "UPDATE products SET rating = ?, reviews_count = ? WHERE id = ?";
            return $this->db->execute($update_query, [round($result->avg_rating, 1), $result->total, $product_id]);
        }
        
        return false;
    }

    // Thêm vào danh sách yêu thích
    public function addToWishlist($user_id, $product_id) {
        // Kiểm tra xem đã có trong wishlist chưa
        $check_query = "SELECT id FROM wishlists WHERE user_id = ? AND product_id = ?";
        $exists = $this->db->fetchOne($check_query, [$user_id, $product_id]);
        
        if (!$exists) {
            $query = "INSERT INTO wishlists (user_id, product_id) VALUES (?, ?)";
            return $this->db->execute($query, [$user_id, $product_id]);
        }
        
        return true;
    }

    // Xóa khỏi danh sách yêu thích
    public function removeFromWishlist($user_id, $product_id) {
        $query = "DELETE FROM wishlists WHERE user_id = ? AND product_id = ?";
        return $this->db->execute($query, [$user_id, $product_id]);
    }

    // Kiểm tra sản phẩm có trong danh sách yêu thích không
    public function isInWishlist($user_id, $product_id) {
        $query = "SELECT id FROM wishlists WHERE user_id = ? AND product_id = ?";
        return $this->db->fetchOne($query, [$user_id, $product_id]) ? true : false;
    }

    // Lấy danh sách sản phẩm yêu thích của người dùng
    public function getUserWishlist($user_id) {
        $query = "SELECT p.*, w.created_at as added_at FROM wishlists w 
                    JOIN products p ON w.product_id = p.id 
                    WHERE w.user_id = ? 
                    ORDER BY w.created_at DESC";
        return $this->db->fetchAll($query, [$user_id]);
    }


    // Lưu sản phẩm vào danh sách đã xem gần đây
    public function saveRecentlyViewed($product_id) {
        // Bắt đầu session nếu chưa bắt đầu
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Khởi tạo mảng lưu sản phẩm đã xem gần đây nếu chưa có
        if (!isset($_SESSION['recently_viewed'])) {
            $_SESSION['recently_viewed'] = [];
        }
        
        // Kiểm tra xem sản phẩm đã có trong danh sách chưa
        if (in_array($product_id, $_SESSION['recently_viewed'])) {
            // Nếu đã có, xóa khỏi vị trí cũ
            $key = array_search($product_id, $_SESSION['recently_viewed']);
            unset($_SESSION['recently_viewed'][$key]);
        }
        
        // Thêm sản phẩm vào đầu danh sách
        array_unshift($_SESSION['recently_viewed'], $product_id);
        
        // Giới hạn số lượng sản phẩm lưu trữ (ví dụ: 10 sản phẩm)
        if (count($_SESSION['recently_viewed']) > 10) {
            $_SESSION['recently_viewed'] = array_slice($_SESSION['recently_viewed'], 0, 10);
        }
    }

    // Lấy danh sách sản phẩm đã xem gần đây
    public function getRecentlyViewedProducts() {
        // Bắt đầu session nếu chưa bắt đầu
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Nếu không có danh sách sản phẩm đã xem, trả về mảng rỗng
        if (!isset($_SESSION['recently_viewed']) || empty($_SESSION['recently_viewed'])) {
            return [];
        }
        
        // Lấy danh sách ID sản phẩm
        $product_ids = $_SESSION['recently_viewed'];
        
        // Khởi tạo mảng kết quả
        $products = [];
        
        // Lấy thông tin từng sản phẩm
        foreach ($product_ids as $id) {
            $product = $this->getProductById($id);
            if ($product) {
                $products[] = $product;
            }
        }
        
        return $products;
    }

    // Xóa danh sách sản phẩm đã xem gần đây
    public function clearRecentlyViewedProducts() {
        // Bắt đầu session nếu chưa bắt đầu
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Xóa danh sách sản phẩm đã xem
        unset($_SESSION['recently_viewed']);
    }

    // Đếm số lượng sản phẩm đã xem gần đây
    public function countRecentlyViewedProducts() {
        // Bắt đầu session nếu chưa bắt đầu
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Nếu không có danh sách sản phẩm đã xem, trả về 0
        if (!isset($_SESSION['recently_viewed']) || empty($_SESSION['recently_viewed'])) {
            return 0;
        }
        
        return count($_SESSION['recently_viewed']);
    }
}