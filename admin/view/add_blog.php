<!DOCTYPE html>
<html lang="vi">
<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h2>Thêm bài viết mới</h2>
                    <a href="?act=blog_manage" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>
                
                <form method="POST" action="?act=add_blog" enctype="multipart/form-data">
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
                                        <textarea class="form-control" name="summary" rows="3" maxlength="500" required></textarea>
                                        <small class="text-muted">Tối đa 500 ký tự</small>
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
                                <div class="card-header">
                                    <h6 class="mb-0">Thông tin bài viết</h6>
                                </div>
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
                                        <label class="form-label">Tags</label>
                                        <select class="form-select" name="tags[]" multiple>
                                            <?php foreach ($tags as $tag): ?>
                                                <option value="<?= $tag['id'] ?>"><?= $tag['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="text-muted">Giữ Ctrl để chọn nhiều tags</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                        <select class="form-select" name="status" required>
                                            <option value="draft">Nháp</option>
                                            <option value="published">Đã xuất bản</option>
                                            <option value="archived">Lưu trữ</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Hình ảnh</label>
                                        <input type="file" class="form-control" name="image" accept="image/*">
                                        <small class="text-muted">Kích thước đề xuất: 800x400px</small>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured">
                                            <label class="form-check-label" for="featured">
                                                Bài viết phổ biến
                                            </label>
                                        </div>
                                        <small class="text-muted">Bài viết này sẽ hiển thị trong phần bài viết phổ biến</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Thông tin thêm</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-muted d-block">Ngày tạo: <?= date('d/m/Y H:i') ?></small>
                                                <div class="mb-2">
                                                    <label class="form-label">Lượt xem:</label>
                                                    <input type="number" class="form-control form-control-sm" name="views" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">Tác giả:</label>
                                                    <input type="text" class="form-control form-control-sm" name="author_name" value="<?= $_SESSION['admin']['name'] ?? 'Admin' ?>">
                                                </div>
                                                <small class="text-muted d-block">Cập nhật lần cuối: <?= date('d/m/Y H:i') ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm bài viết
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