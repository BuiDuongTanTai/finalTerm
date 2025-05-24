<?php
// admin/model/blog.php

class Blog {
    private $conn;
    
    public function __construct() {
        // Sử dụng hàm connect() có sẵn của bạn
        $this->conn = connect();
    }
    
    // Lấy tất cả bài viết
    public function getAllBlogs($status = null, $search = null, $category_id = null) {
        $query = "SELECT b.*, c.name as category_name, 
                  (SELECT GROUP_CONCAT(t.name) FROM tags t 
                   INNER JOIN blog_tags bt ON t.id = bt.tag_id 
                   WHERE bt.blog_id = b.id) as tags
                  FROM blogs b 
                  LEFT JOIN blog_categories c ON b.category_id = c.id
                  WHERE 1=1";
        
        $params = [];
        
        if ($status) {
            $query .= " AND b.status = :status";
            $params['status'] = $status;
        }
        
        if ($search) {
            $query .= " AND (b.title LIKE :search OR b.summary LIKE :search)";
            $params['search'] = "%$search%";
        }
        
        if ($category_id) {
            $query .= " AND b.category_id = :category_id";
            $params['category_id'] = $category_id;
        }
        
        $query .= " ORDER BY b.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Lấy blog theo ID
    public function getBlogById($id) {
        $query = "SELECT b.*, 
                  (SELECT GROUP_CONCAT(tag_id) FROM blog_tags WHERE blog_id = b.id) as tag_ids
                  FROM blogs b WHERE b.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Thêm blog mới
    public function createBlog($data) {
        $query = "INSERT INTO blogs (title, slug, summary, content, image, category_id, author_id, author_name, status, published_at) 
                  VALUES (:title, :slug, :summary, :content, :image, :category_id, :author_id, :author_name, :status, :published_at)";
        
        $stmt = $this->conn->prepare($query);
        
        // Tạo slug
        $data['slug'] = $this->createSlug($data['title']);
        
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':summary', $data['summary']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':author_id', $data['author_id']);
        $stmt->bindParam(':author_name', $data['author_name']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':published_at', $data['published_at']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    
    // Cập nhật blog
    public function updateBlog($id, $data) {
        $query = "UPDATE blogs SET 
                  title = :title,
                  slug = :slug,
                  summary = :summary,
                  content = :content,
                  category_id = :category_id,
                  status = :status,
                  updated_at = NOW()";
        
        if (isset($data['image']) && $data['image']) {
            $query .= ", image = :image";
        }
        
        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $data['slug'] = $this->createSlug($data['title']);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':summary', $data['summary']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':status', $data['status']);
        
        if (isset($data['image']) && $data['image']) {
            $stmt->bindParam(':image', $data['image']);
        }
        
        return $stmt->execute();
    }
    
    // Xóa blog
    public function deleteBlog($id) {
        // Lấy thông tin ảnh trước khi xóa
        $blog = $this->getBlogById($id);
        
        $query = "DELETE FROM blogs WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            // Xóa file ảnh nếu có
            if ($blog && $blog['image'] && file_exists('../' . $blog['image'])) {
                unlink('../' . $blog['image']);
            }
            return true;
        }
        return false;
    }
    
    // Lấy tất cả danh mục
    public function getAllCategories() {
        $query = "SELECT *, (SELECT COUNT(*) FROM blogs WHERE category_id = blog_categories.id) as post_count 
                  FROM blog_categories ORDER BY name";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Lấy tất cả tags
    public function getAllTags() {
        $query = "SELECT * FROM tags ORDER BY name";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Thêm tags cho blog
    public function addTagsToBlog($blogId, $tagIds) {
        // Xóa tags cũ
        $deleteQuery = "DELETE FROM blog_tags WHERE blog_id = :blog_id";
        $deleteStmt = $this->conn->prepare($deleteQuery);
        $deleteStmt->bindParam(':blog_id', $blogId);
        $deleteStmt->execute();
        
        // Thêm tags mới
        if (!empty($tagIds)) {
            $insertQuery = "INSERT INTO blog_tags (blog_id, tag_id) VALUES (:blog_id, :tag_id)";
            $insertStmt = $this->conn->prepare($insertQuery);
            
            foreach ($tagIds as $tagId) {
                $insertStmt->bindParam(':blog_id', $blogId);
                $insertStmt->bindParam(':tag_id', $tagId);
                $insertStmt->execute();
            }
        }
    }
    
    // Tạo slug từ title
    private function createSlug($title) {
        $slug = mb_strtolower($title, 'UTF-8');
        
        // Chuyển đổi ký tự có dấu sang không dấu
        $slug = preg_replace('/[áàảãạăắằẳẵặâấầẩẫậ]/u', 'a', $slug);
        $slug = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $slug);
        $slug = preg_replace('/[íìỉĩị]/u', 'i', $slug);
        $slug = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $slug);
        $slug = preg_replace('/[úùủũụưứừửữự]/u', 'u', $slug);
        $slug = preg_replace('/[ýỳỷỹỵ]/u', 'y', $slug);
        $slug = preg_replace('/[đ]/u', 'd', $slug);
        
        // Xóa ký tự đặc biệt
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        
        // Thay thế khoảng trắng và dấu gạch ngang
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        
        return trim($slug, '-');
    }
    
    // Tăng lượt xem
    public function increaseView($id) {
        $query = "UPDATE blogs SET views = views + 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>