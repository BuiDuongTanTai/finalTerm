<?php
require_once '../model/blog.php';

class AdminBlogController {
    private $blogModel;
    
    public function __construct() {
        $this->blogModel = new Blog();
    }
    
    public function index() {
        // Lấy tham số filter
        $search = $_GET['search'] ?? null;
        $category = $_GET['category'] ?? null;
        $status = $_GET['status'] ?? null;
        
        $blogs = $this->blogModel->getAllBlogs($status, $search, $category);
        $categories = $this->blogModel->getAllCategories();
        
        include '../view/blog_manage.php';
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'title' => $_POST['title'],
                'summary' => $_POST['summary'],
                'content' => $_POST['content'],
                'category_id' => $_POST['category_id'],
                'author_id' => $_SESSION['user_id'] ?? 1,
                'author_name' => $_SESSION['user_name'] ?? 'Admin',
                'status' => $_POST['status'],
                'published_at' => $_POST['status'] == 'published' ? date('Y-m-d H:i:s') : null,
                'image' => ''
            ];
            
            // Xử lý upload ảnh
            if (!empty($_FILES['image']['name'])) {
                $uploadDir = '../uploads/blog/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $data['image'] = 'uploads/blog/' . $fileName;
                }
            }
            
            $blogId = $this->blogModel->createBlog($data);
            
            if ($blogId && !empty($_POST['tags'])) {
                $this->blogModel->addTagsToBlog($blogId, $_POST['tags']);
            }
            
            header('Location: index.php?act=blog_manage');
            exit;
        }
        
        $categories = $this->blogModel->getAllCategories();
        $tags = $this->blogModel->getAllTags();
        
        include '../view/add_blog.php';
    }
    
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $blog = $this->blogModel->getBlogById($id);
        
        if (!$blog) {
            header('Location: index.php?act=blog_manage');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'title' => $_POST['title'],
                'summary' => $_POST['summary'],
                'content' => $_POST['content'],
                'category_id' => $_POST['category_id'],
                'status' => $_POST['status']
            ];
            
            // Xử lý upload ảnh mới
            if (!empty($_FILES['image']['name'])) {
                $uploadDir = '../uploads/blog/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $data['image'] = 'uploads/blog/' . $fileName;
                    
                    // Xóa ảnh cũ
                    if ($blog['image'] && file_exists('../' . $blog['image'])) {
                        unlink('../' . $blog['image']);
                    }
                }
            }
            
            $this->blogModel->updateBlog($id, $data);
            
            // Cập nhật tags
            $tags = $_POST['tags'] ?? [];
            $this->blogModel->addTagsToBlog($id, $tags);
            
            header('Location: index.php?act=blog_manage');
            exit;
        }
        
        $categories = $this->blogModel->getAllCategories();
        $tags = $this->blogModel->getAllTags();
        
        include '../view/edit_blog.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? 0;
        
        if ($id) {
            $this->blogModel->deleteBlog($id);
        }
        
        header('Location: index.php?act=blog_manage');
        exit;
    }
}
?>