<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa bài viết - CameraVN Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tiny.cloud/1/ztadj9i62e8dgox15pu4w8vv1s1jgr8mcbg7w7pro5o9y0j1/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
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
                
                <form method="POST" action="index.php?act=update_blog" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $blog['id'] ?>">
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
                                        <label class="form-label">Tags</label>
                                        <select class="form-select" name="tags[]" multiple>
                                            <?php 
                                            $selectedTags = explode(',', $blog['tag_ids'] ?? '');
                                            foreach ($tags as $tag): 
                                            ?>
                                                <option value="<?= $tag['id'] ?>" 
                                                        <?= in_array($tag['id'], $selectedTags) ? 'selected' : '' ?>>
                                                    <?= $tag['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="text-muted">Giữ Ctrl để chọn nhiều tags</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                        <select class="form-select" name="status" required>
                                            <option value="draft" <?= $blog['status'] == 'draft' ? 'selected' : '' ?>>Nháp</option>
                                            <option value="published" <?= $blog['status'] == 'published' ? 'selected' : '' ?>>Đã xuất bản</option>
                                            <option value="archived" <?= $blog['status'] == 'archived' ? 'selected' : '' ?>>Lưu trữ</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Hình ảnh</label>
                                        <?php if ($blog['image']): ?>
                                            <div class="mb-2">
                                                <img src="../<?= $blog['image'] ?>" alt="" class="img-thumbnail" style="max-height: 200px;">
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control" name="image" accept="image/*">
                                        <small class="text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Thông tin thêm</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-muted d-block">Ngày tạo: <?= date('d/m/Y H:i', strtotime($blog['created_at'])) ?></small>
                                                <small class="text-muted d-block">Lượt xem: <?= number_format($blog['views']) ?></small>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted d-block">Tác giả: <?= $blog['author_name'] ?></small>
                                                <?php if ($blog['updated_at']): ?>
                                                    <small class="text-muted d-block">Cập nhật lần cuối: <?= date('d/m/Y H:i', strtotime($blog['updated_at'])) ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            images_upload_url: 'upload.php',
            automatic_uploads: true
        });
    </script>
</body>
</html>