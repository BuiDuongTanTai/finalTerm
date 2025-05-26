<?php

class BlogModel {
    private $db;

    public function __construct() {
        // Kết nối database
        try {
            // Sử dụng thông tin kết nối từ config.php
            global $db; // Giả định biến $db được thiết lập trong config.php
            $this->db = $db;
        } catch(PDOException $e) {
            // Ghi log lỗi hoặc xử lý theo cách phù hợp
            error_log("Lỗi kết nối database trong BlogModel: " . $e->getMessage());
            // Tùy chọn: hiển thị lỗi cho admin hoặc chuyển hướng đến trang lỗi
            // die("Lỗi kết nối database.");
        }
    }

    // Lấy tất cả bài viết blog (có thể lọc theo status, search, category)
    public function getAllBlogs($status = null, $search = null, $category_slug = null, $page = 1, $per_page = 6) {
        $sql = "SELECT ";
        $sql .= "b.*, bc.name as category_name, u.name as author_name, ";
        $sql .= "CONCAT('View/assets/images/', b.image) as image "; // Thêm đường dẫn ảnh
        $sql .= "FROM blogs b ";
        $sql .= "LEFT JOIN blog_categories bc ON b.category_id = bc.id ";
        $sql .= "LEFT JOIN users u ON b.author_id = u.id ";
        $sql .= "WHERE 1=1 "; // Mệnh đề WHERE luôn đúng để dễ dàng thêm điều kiện

        $params = [];

        if ($status !== null) {
            $sql .= "AND b.status = ? ";
            $params[] = $status;
        }
        if ($search !== null) {
            $sql .= "AND (b.title LIKE ? OR b.summary LIKE ? OR b.content LIKE ?) ";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
        }
        if ($category_slug !== null) {
            $sql .= "AND bc.slug = ? ";
            $params[] = $category_slug;
        }

        // Tính toán offset cho phân trang
        $offset = ($page - 1) * $per_page;
        
        $sql .= "ORDER BY b.published_at DESC, b.created_at DESC ";
        $sql .= "LIMIT ? OFFSET ?";
        $params[] = $per_page;
        $params[] = $offset;

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Lỗi khi lấy tất cả bài viết blog: " . $e->getMessage());
            return [];
        }
    }

    // Lấy tổng số bài viết (cho phân trang)
    public function getTotalBlogs($status = null, $search = null, $category_slug = null) {
        $sql = "SELECT COUNT(*) as total FROM blogs b ";
        $sql .= "LEFT JOIN blog_categories bc ON b.category_id = bc.id ";
        $sql .= "WHERE 1=1 ";

        $params = [];

        if ($status !== null) {
            $sql .= "AND b.status = ? ";
            $params[] = $status;
        }
        if ($search !== null) {
            $sql .= "AND (b.title LIKE ? OR b.summary LIKE ? OR b.content LIKE ?) ";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
        }
        if ($category_slug !== null) {
            $sql .= "AND bc.slug = ? ";
            $params[] = $category_slug;
        }

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result->total;
        } catch(PDOException $e) {
            error_log("Lỗi khi đếm tổng số bài viết: " . $e->getMessage());
            return 0;
        }
    }

    // Lấy danh sách tất cả danh mục blog cùng số lượng bài viết đã xuất bản
    public function getAllCategories() {
        $sql = "SELECT ";
        $sql .= "bc.*, COUNT(b.id) as post_count ";
        $sql .= "FROM blog_categories bc ";
        $sql .= "LEFT JOIN blogs b ON bc.id = b.category_id AND b.status = 'published' ";
        $sql .= "GROUP BY bc.id ";
        $sql .= "ORDER BY bc.name ASC";

        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Lỗi khi lấy tất cả danh mục blog: " . $e->getMessage());
            return [];
        }
    }

    // Lấy bài viết theo ID
    public function getBlogById($id) {
        $sql = "SELECT ";
        $sql .= "b.*, bc.name as category_name, u.name as author_name ";
        $sql .= "FROM blogs b ";
        $sql .= "LEFT JOIN blog_categories bc ON b.category_id = bc.id ";
        $sql .= "LEFT JOIN users u ON b.author_id = u.id ";
        $sql .= "WHERE b.id = ? LIMIT 1";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Lỗi khi lấy bài viết theo ID: " . $e->getMessage());
            return null;
        }
    }

    // Tăng lượt xem cho bài viết
    public function incrementViews($id) {
        $sql = "UPDATE blogs SET views = views + 1 WHERE id = ?";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return true;
        } catch(PDOException $e) {
            error_log("Lỗi khi tăng lượt xem: " . $e->getMessage());
            return false;
        }
    }

    // Lấy các bài viết nổi bật (featured)
    public function getFeaturedPosts($limit = 5) {
        $sql = "SELECT ";
        $sql .= "b.*, bc.name as category_name, u.name as author_name, ";
        $sql .= "CONCAT('View/assets/images/', b.image) as image "; // Thêm đường dẫn ảnh
        $sql .= "FROM blogs b ";
        $sql .= "LEFT JOIN blog_categories bc ON b.category_id = bc.id ";
        $sql .= "LEFT JOIN users u ON b.author_id = u.id ";
        $sql .= "WHERE b.status = 'published' AND b.featured = 1 ";
        $sql .= "ORDER BY b.published_at DESC, b.created_at DESC ";
        $sql .= "LIMIT ?";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Lỗi khi lấy bài viết nổi bật: " . $e->getMessage());
            return [];
        }
    }
    
    // Lấy tất cả tags
    public function getAllTags() {
        $sql = "SELECT * FROM tags ORDER BY name ASC";
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Lỗi khi lấy tất cả tags: " . $e->getMessage());
            return [];
        }
    }
    
    // Lấy tags của một bài viết
    public function getTagsByBlogId($blog_id) {
         $sql = "SELECT t.* FROM tags t ";
         $sql .= "JOIN blog_tags bt ON t.id = bt.tag_id ";
         $sql .= "WHERE bt.blog_id = ?";
         try {
             $stmt = $this->db->prepare($sql);
             $stmt->execute([$blog_id]);
             return $stmt->fetchAll(PDO::FETCH_OBJ);
         } catch(PDOException $e) {
             error_log("Lỗi khi lấy tags theo blog ID: " . $e->getMessage());
             return [];
         }
    }

    // Thêm bài viết blog mới
    public function createBlog($data) {
        $sql = "INSERT INTO blogs (title, slug, summary, content, image, category_id, author_id, author_name, status, featured, published_at, created_at, updated_at) ";
        $sql .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        // Tạo slug tự động nếu không có
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = $this->createSlug($data['title']);
        }

        // Đảm bảo featured là 0 hoặc 1
        $featured = $data['featured'] ?? 0;
        $featured = ($featured == 1) ? 1 : 0;

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['title'],
                $data['slug'],
                $data['summary'] ?? '',
                $data['content'] ?? '',
                $data['image'] ?? null,
                $data['category_id'] ?? null,
                $data['author_id'] ?? null,
                $data['author_name'] ?? null,
                $data['status'] ?? 'draft',
                $featured,
                $data['published_at'] ?? null
            ]);
            return $this->db->lastInsertId();
        } catch(PDOException $e) {
            error_log("Lỗi khi tạo bài viết blog: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật bài viết blog
    public function updateBlog($id, $data) {
        $sql = "UPDATE blogs SET ";
        $fields = [];
        $params = [];

        if (isset($data['title'])) { $fields[] = 'title = ?'; $params[] = $data['title']; }
        if (isset($data['slug'])) { 
            // Tạo slug tự động nếu cần
            if (empty($data['slug']) && isset($data['title'])) {
                 $data['slug'] = $this->createSlug($data['title']);
            } else if (empty($data['slug'])) {
                 // Giữ slug cũ nếu không có title mới và slug mới
            } else {
                 $fields[] = 'slug = ?'; $params[] = $data['slug'];
            }
        }
        if (isset($data['summary'])) { $fields[] = 'summary = ?'; $params[] = $data['summary']; }
        if (isset($data['content'])) { $fields[] = 'content = ?'; $params[] = $data['content']; }
        if (isset($data['image'])) { $fields[] = 'image = ?'; $params[] = $data['image']; }
        if (isset($data['category_id'])) { $fields[] = 'category_id = ?'; $params[] = $data['category_id']; }
        if (isset($data['author_id'])) { $fields[] = 'author_id = ?'; $params[] = $data['author_id']; }
        if (isset($data['author_name'])) { $fields[] = 'author_name = ?'; $params[] = $data['author_name']; }
        if (isset($data['status'])) { 
            $fields[] = 'status = ?'; $params[] = $data['status']; 
            // Cập nhật published_at nếu trạng thái chuyển sang published và chưa có published_at
            if ($data['status'] == 'published') {
                 // Kiểm tra xem blog đã có published_at chưa
                 $current_blog = $this->getBlogById($id);
                 if (!$current_blog || $current_blog->published_at == null) {
                    $fields[] = 'published_at = NOW()';
                 }
            } else {
                // Tùy chọn: đặt published_at về null nếu chuyển trạng thái khác published
                // $fields[] = 'published_at = NULL';
            }
        }
         if (isset($data['featured'])) { 
            // Đảm bảo featured là 0 hoặc 1
            $featured = ($data['featured'] == 1) ? 1 : 0;
            $fields[] = 'featured = ?'; $params[] = $featured;
        }

        $fields[] = 'updated_at = NOW()'; // Cập nhật thời gian chỉnh sửa

        $sql .= implode(', ', $fields);
        $sql .= " WHERE id = ?";
        $params[] = $id;

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch(PDOException $e) {
            error_log("Lỗi khi cập nhật bài viết blog: " . $e->getMessage());
            return false;
        }
    }

    // Xóa bài viết blog
    public function deleteBlog($id) {
        $sql = "DELETE FROM blogs WHERE id = ?";

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch(PDOException $e) {
            error_log("Lỗi khi xóa bài viết blog: " . $e->getMessage());
            return false;
        }
    }
    
    // Thêm tags vào bài viết blog
    public function addTagsToBlog($blog_id, $tag_ids) {
        // Xóa tags cũ của bài viết này trước
        $this->db->prepare("DELETE FROM blog_tags WHERE blog_id = ?")->execute([$blog_id]);

        if (empty($tag_ids)) {
            return true; // Không có tags để thêm
        }

        $sql = "INSERT INTO blog_tags (blog_id, tag_id) VALUES ";
        $values = [];
        $params = [];

        foreach ($tag_ids as $tag_id) {
            $values[] = "(?, ?)";
            $params[] = $blog_id;
            $params[] = $tag_id;
        }

        $sql .= implode(', ', $values);

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch(PDOException $e) {
            error_log("Lỗi khi thêm tags vào bài viết blog: " . $e->getMessage());
            return false;
        }
    }
    
    // Hàm tạo slug từ chuỗi
    private function createSlug($string) {
        $slug = strtolower($string);
        $slug = preg_replace('/[áàảãạăắằẳẵặâấầẩẫậ]/u', 'a', $slug);
        $slug = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $slug);
        $slug = preg_replace('/[íìỉĩị]/u', 'i', $slug);
        $slug = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $slug);
        $slug = preg_replace('/[úùủũụưứừửữự]/u', 'u', $slug);
        $slug = preg_replace('/[ýỳỷỹỵ]/u', 'y', $slug);
        $slug = preg_replace('/[đ]/u', 'd', $slug);
        $slug = preg_replace('/[^a-z0-9\s-]/u', '', $slug); // Loại bỏ ký tự đặc biệt trừ dấu gạch ngang và khoảng trắng
        $slug = preg_replace('/\s+/', '-', $slug); // Thay thế khoảng trắng bằng dấu gạch ngang
        $slug = preg_replace('/-+/', '-', $slug); // Loại bỏ các dấu gạch ngang liên tiếp
        $slug = trim($slug, '-');
        return $slug;
    }
}
?> 