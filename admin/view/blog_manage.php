<!-- <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Blog - CameraVN Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body> -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h2>Quản lý Blog</h2>
                    <a href="?act=add_blog" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Thêm bài viết mới
                    </a>
                </div>
                
                <!-- Filter -->
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <input type="hidden" name="act" value="blog_manage">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="search" 
                                       placeholder="Tìm kiếm bài viết..." 
                                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="category">
                                    <option value="">Tất cả danh mục</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" 
                                                <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['name']) ?> (<?= $cat['post_count'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="status">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="published" <?= (isset($_GET['status']) && $_GET['status'] == 'published') ? 'selected' : '' ?>>Đã xuất bản</option>
                                    <option value="draft" <?= (isset($_GET['status']) && $_GET['status'] == 'draft') ? 'selected' : '' ?>>Nháp</option>
                                    <option value="archived" <?= (isset($_GET['status']) && $_GET['status'] == 'archived') ? 'selected' : '' ?>>Lưu trữ</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Lọc
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Blog list -->
                <div class="card">
                    <div class="card-body">
                        <?php if (empty($blogs)): ?>
                            <div class="text-center py-5">
                                <i class="bi bi-newspaper display-1 text-muted"></i>
                                <p class="mt-3 text-muted">Chưa có bài viết nào</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="10%">Hình ảnh</th>
                                            <th width="30%">Tiêu đề</th>
                                            <th width="12%">Danh mục</th>
                                            <th width="10%">Tác giả</th>
                                            <th width="8%">Lượt xem</th>
                                            <th width="10%">Trạng thái</th>
                                            <th width="10%">Ngày tạo</th>
                                            <th width="5%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($blogs as $blog): ?>
                                        <tr>
                                            <td><?= $blog['id'] ?></td>
                                            <td>
                                                <?php if ($blog['image']): ?>
                                                    <img src="../<?= $blog['image'] ?>" alt="" 
                                                         class="img-thumbnail" 
                                                         style="width: 80px; height: 60px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                                         style="width: 80px; height: 60px; font-size: 12px;">
                                                        No Image
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($blog['title']) ?></div>
                                                <small class="text-muted d-block mt-1">
                                                    <?= mb_substr(htmlspecialchars($blog['summary']), 0, 80) ?>...
                                                </small>
                                                <?php if ($blog['tags']): ?>
                                                    <div class="mt-1">
                                                        <?php foreach (explode(',', $blog['tags']) as $tag): ?>
                                                            <span class="badge bg-light text-dark me-1"><?= $tag ?></span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $blog['category_name'] ?></td>
                                            <td><?= $blog['author_name'] ?></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= number_format($blog['views']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = [
                                                    'published' => 'success',
                                                    'draft' => 'secondary',
                                                    'archived' => 'warning'
                                                ];
                                                $statusText = [
                                                    'published' => 'Đã xuất bản',
                                                    'draft' => 'Nháp',
                                                    'archived' => 'Lưu trữ'
                                                ];
                                                ?>
                                                <span class="badge bg-<?= $statusClass[$blog['status']] ?>">
                                                    <?= $statusText[$blog['status']] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small><?= date('d/m/Y', strtotime($blog['created_at'])) ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="?act=edit_blog&id=<?= $blog['id'] ?>" 
                                                       class="btn btn-sm btn-warning" title="Sửa">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="?act=delete_blog&id=<?= $blog['id'] ?>" 
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')"
                                                       title="Xóa">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>