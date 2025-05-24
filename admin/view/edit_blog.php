<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa bài viết - CameraVN Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h2>Sửa bài viết</h2>
                    <a href="?act=blog_manage" class="btn btn-secondary">
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
                                        <input type="text" class="form-control" name="title" 
                                               value="<?= htmlspecialchars($blog['title']) ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Tóm tắt <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="summary" rows="3" maxlength="500" required><?= htmlspecialchars($blog['summary']) ?></textarea>
                                        <small class="text-muted">Tối đa 500 ký tự</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="content" id="content" rows="15"><?= htmlspecialchars($blog['content']) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Thông tin bài viết</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                                        <select class="form-select" name="category_id" required>
                                            <option value="">-- Chọn danh mục --</option>
                                            <?php foreach ($categories as $cat): ?>
                                                <option value="<?= $cat['id'] ?>" 
                                                        <?= $cat['id'] == $blog['category_id'] ? 'selected' : '' ?>>
                                                    <?= $cat['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Trạng thái</label>
                                        <select class="form-select" name="status">
                                            <option value="draft" <?= $blog['status'] == 'draft' ? 'selected' : '' ?>>Nháp</option>
                                            <option value="published" <?= $blog['status'] == 'published' ? 'selected' : '' ?>>Đã xuất bản</option>
                                            <option value="archived" <?= $blog['status'] == 'archived' ? 'selected' : '' ?>>Lưu trữ</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Hình ảnh đại diện</label>
                                        <?php if ($blog['image']): ?>
                                            <div class="mb-2">
                                                <img src="../<?= $blog['image'] ?>" class="img-thumbnail" style="max-width: 100%;">
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(this)">
                                        <small class="text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                                        <div id="imagePreview" class="mt-2"></div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> Tạo ngày: <?= date('d/m/Y H:i', strtotime($blog['created_at'])) ?><br>
                                            <?php if ($blog['updated_at']): ?>
                                                <i class="bi bi-pencil"></i> Cập nhật: <?= date('d/m/Y H:i', strtotime($blog['updated_at'])) ?><br>
                                            <?php endif; ?>
                                            <i class="bi bi-eye"></i> Lượt xem: <?= number_format($blog['views']) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Tags</h6>
                                </div>
                                <div class="card-body">
                                    <div class="tag-checkboxes" style="max-height: 200px; overflow-y: auto;">
                                        <?php 
                                        $currentTagIds = $blog['tag_ids'] ? explode(',', $blog['tag_ids']) : [];
                                        foreach ($tags as $tag): 
                                        ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="tags[]" value="<?= $tag['id'] ?>" 
                                                       id="tag_<?= $tag['id'] ?>"
                                                       <?= in_array($tag['id'], $currentTagIds) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="tag_<?= $tag['id'] ?>">
                                                    <?= $tag['name'] ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-save"></i> Cập nhật bài viết
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            plugins: 'image link lists code table media',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image media | code',
            menubar: false,
            language: 'vi'
        });
        
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 100%;">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>