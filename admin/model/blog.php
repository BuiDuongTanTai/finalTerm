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
            $query .= " AND (b.title LIKE :search OR b.summary LIKE :search OR b.content LIKE :search)";
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
        $query = "INSERT INTO blogs (title, slug, summary, content, image, category_id, author_id, author_name, status, published_at, featured) 
                  VALUES (:title, :slug, :summary, :content, :image, :category_id, :author_id, :author_name, :status, :published_at, :featured)";
        
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
        $stmt->bindParam(':featured', $data['featured']);
        
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
                  featured = :featured,
                  author_id = :author_id,
                  author_name = :author_name,
                  views = :views,
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
        $stmt->bindParam(':featured', $data['featured']);
        $stmt->bindParam(':author_id', $data['author_id']);
        $stmt->bindParam(':author_name', $data['author_name']);
        $stmt->bindParam(':views', $data['views']);
        
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
        $query = "SELECT c.*, COUNT(b.id) as post_count 
                  FROM blog_categories c 
                  LEFT JOIN blogs b ON c.id = b.category_id 
                  GROUP BY c.id 
                  ORDER BY c.name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Lấy tất cả tags
    public function getAllTags() {
        $query = "SELECT * FROM tags ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Thêm tags cho blog
    public function addTagsToBlog($blogId, $tagIds) {
        // Xóa tags cũ
        $query = "DELETE FROM blog_tags WHERE blog_id = :blog_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':blog_id', $blogId);
        $stmt->execute();
        
        // Thêm tags mới
        if (!empty($tagIds)) {
            $query = "INSERT INTO blog_tags (blog_id, tag_id) VALUES (:blog_id, :tag_id)";
            $stmt = $this->conn->prepare($query);
            
            foreach ($tagIds as $tagId) {
                $stmt->bindParam(':blog_id', $blogId);
                $stmt->bindParam(':tag_id', $tagId);
                $stmt->execute();
            }
        }
    }
    
    // Tạo slug từ tiêu đề
    private function createSlug($title) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        return $slug;
    }
    
    // Lấy bài viết phổ biến
    public function getPopularPosts($limit = 5) {
        $query = "SELECT b.*, c.name as category_name 
                  FROM blogs b 
                  LEFT JOIN blog_categories c ON b.category_id = c.id 
                  WHERE b.status = 'published' 
                  ORDER BY b.views DESC 
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Cập nhật lượt xem
    public function updateViews($id) {
        $query = "UPDATE blogs SET views = views + 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Lấy bài viết theo danh mục
    public function getBlogsByCategory($category_id) {
        $query = "SELECT b.*, c.name as category_name,
                  (SELECT GROUP_CONCAT(t.name) FROM tags t 
                   INNER JOIN blog_tags bt ON t.id = bt.tag_id 
                   WHERE bt.blog_id = b.id) as tags
                  FROM blogs b 
                  LEFT JOIN blog_categories c ON b.category_id = c.id
                  WHERE b.category_id = :category_id AND b.status = 'published'
                  ORDER BY b.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getFeaturedPosts($limit = 5) {
        $query = "SELECT b.*, c.name as category_name 
                  FROM blogs b 
                  LEFT JOIN blog_categories c ON b.category_id = c.id 
                  WHERE b.status = 'published' AND b.featured = 1
                  ORDER BY b.views DESC 
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>