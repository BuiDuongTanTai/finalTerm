<?php
class BlogModel {
    private $db;
    
    public function __construct() {
        $this->db = new PDO("mysql:host=localhost;dbname=your_database", "username", "password");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    // Lấy tất cả bài viết
    public function getAllBlogs($status = null) {
        $sql = "SELECT b.*, c.name as category_name, 
                (SELECT GROUP_CONCAT(t.name) FROM tags t 
                 INNER JOIN blog_tags bt ON t.id = bt.tag_id 
                 WHERE bt.blog_id = b.id) as tags
                FROM blogs b 
                LEFT JOIN blog_categories c ON b.category_id = c.id";
        
        if ($status) {
            $sql .= " WHERE b.status = :status";
        }
        
        $sql .= " ORDER BY b.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        if ($status) {
            $stmt->bindParam(':status', $status);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Thêm bài viết mới
    public function createBlog($data) {
        $sql = "INSERT INTO blogs (title, slug, summary, content, image, category_id, author_id, author_name, status, published_at) 
                VALUES (:title, :slug, :summary, :content, :image, :category_id, :author_id, :author_name, :status, :published_at)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }
    
    // Cập nhật bài viết
    public function updateBlog($id, $data) {
        $sql = "UPDATE blogs SET 
                title = :title,
                slug = :slug,
                summary = :summary,
                content = :content,
                image = :image,
                category_id = :category_id,
                status = :status,
                updated_at = NOW()
                WHERE id = :id";
        
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    
    // Xóa bài viết
    public function deleteBlog($id) {
        $sql = "DELETE FROM blogs WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    // Lấy tất cả danh mục
    public function getAllCategories() {
        $sql = "SELECT * FROM blog_categories ORDER BY name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Quản lý tags
    public function addTagsToBlog($blogId, $tagIds) {
        $sql = "INSERT INTO blog_tags (blog_id, tag_id) VALUES (:blog_id, :tag_id)";
        $stmt = $this->db->prepare($sql);
        
        foreach ($tagIds as $tagId) {
            $stmt->execute(['blog_id' => $blogId, 'tag_id' => $tagId]);
        }
    }
}
?>