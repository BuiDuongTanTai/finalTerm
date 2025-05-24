<?php
require_once '../model/blog.php';
$blogModel = new Blog();

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
    
    $blogId = $blogModel->createBlog($data);
    
    if ($blogId && !empty($_POST['tags'])) {
        $blogModel->addTagsToBlog($blogId, $_POST['tags']);
    }
    
    header('Location: index.php?page=blog_manage');
    exit;
}

$categories = $blogModel->getAllCategories();
$tags = $blogModel->getAllTags();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm bài viết - CameraVN Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- TinyMCE Editor -->
    <script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/6/tinymce.min.js"></script>
</head>
<body>  
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h2>Thêm bài viết mới</h2>
                    <a href="?page=blog_manage" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Tiêu đề bài viết <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="title" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Tóm tắt <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="summary" rows="3" required></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="content" id="content" rows="15"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                                        <select class="form-select" name="category_id" required>
                                            <option value="">-- Chọn danh mục --</option>
                                            <?php foreach ($categories as $cat): ?>
                                                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Trạng thái</label>
                                        <select class="form-select" name="status">
                                            <option value="draft">Nháp</option>
                                            <option value="published">Xuất bản ngay</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Hình ảnh đại diện</label>
                                        <input type="file" class="form-control" name="image" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label">Tags</label>
                                    <div class="tag-checkboxes" style="max-height: 200px; overflow-y: auto;">
                                        <?php foreach ($tags as $tag): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tags[]" value="<?= $tag['id'] ?>" id="tag_<?= $tag['id'] ?>">
                                                <label class="form-check-label" for="tag_<?= $tag['id'] ?>">
                                                    <?= $tag['name'] ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mt-3">
                                <i class="bi bi-save"></i> Lưu bài viết
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            plugins: 'image link lists code table',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
            menubar: false
        });
    </script>
</body>
</html>