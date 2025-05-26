<?php
require_once 'model/blog.php';
$blogModel = new Blog();

// Lấy danh sách bài viết
$category_id = $_GET['category'] ?? null;
$blogs = $category_id ? $blogModel->getBlogsByCategory($category_id) : $blogModel->getAllBlogs('published');

// Lấy bài viết phổ biến
$featured_posts = $blogModel->getFeaturedPosts(5);

// Lấy danh mục
$categories = $blogModel->getAllCategories();
?>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <!-- Danh mục -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh mục</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="?page=blog" class="text-decoration-none <?= !$category_id ? 'text-primary fw-bold' : 'text-dark' ?>">
                                Tất cả bài viết
                            </a>
                        </li>
                        <?php foreach ($categories as $cat): ?>
                        <li class="mb-2">
                            <a href="?page=blog&category=<?= $cat['id'] ?>" 
                               class="text-decoration-none <?= $category_id == $cat['id'] ? 'text-primary fw-bold' : 'text-dark' ?>">
                                <?= $cat['name'] ?>
                                <span class="badge bg-secondary float-end"><?= $cat['post_count'] ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Bài viết phổ biến -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Bài viết phổ biến</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($featured_posts as $post): ?>
                    <div class="d-flex mb-3">
                        <?php if ($post['image']): ?>
                        <img src="<?= $post['image'] ?>" alt="<?= $post['title'] ?>" 
                             class="rounded" style="width: 80px; height: 60px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="ms-3">
                            <h6 class="mb-1">
                                <a href="?page=blog_detail&id=<?= $post['id'] ?>" class="text-decoration-none text-dark">
                                    <?= $post['title'] ?>
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="bi bi-eye"></i> <?= number_format($post['views']) ?>
                            </small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="row">
                <?php if (empty($blogs)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        Chưa có bài viết nào trong danh mục này.
                    </div>
                </div>
                <?php else: ?>
                <?php foreach ($blogs as $blog): ?>
                <div class="col-md-6 mb-4">
                    <div class="card blog-card h-100">
                        <?php if ($blog['image']): ?>
                        <img src="<?= $blog['image'] ?>" class="card-img-top" alt="<?= $blog['title'] ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="blog-meta">
                                <span><i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($blog['created_at'])) ?></span>
                                <span><i class="bi bi-eye"></i> <?= number_format($blog['views']) ?> lượt xem</span>
                            </div>
                            <span class="badge bg-success mb-3"><?= $blog['category_name'] ?></span>
                            <h5 class="card-title"><?= $blog['title'] ?></h5>
                            <p class="card-text"><?= $blog['summary'] ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small"><i class="bi bi-person"></i> <?= $blog['author_name'] ?></span>
                                <a href="?page=blog_detail&id=<?= $blog['id'] ?>" class="btn btn-outline-primary btn-sm">
                                    Đọc tiếp <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>