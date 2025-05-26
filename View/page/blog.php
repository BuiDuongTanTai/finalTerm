<?php
// View/page/blog.php

// require_once MODEL_PATH . '/BlogModel.php'; // Xóa dòng này
// $blogModel = new BlogModel(); // Xóa dòng này

// Lấy danh sách bài viết blog đã xuất bản (Dữ liệu được truyền từ Controller)
// $published_blogs = $blogModel->getAllBlogs('published'); // Xóa dòng này

// Lấy danh sách danh mục blog (Dữ liệu được truyền từ Controller)
// $categories = $blogModel->getAllCategories(); // Xóa dòng này

?>
<main>
    <!-- Blog Hero Section -->
    <section class="blog-hero">
        <div class="container">
            <h1 class="display-4 fw-bold">Blog Nhiếp Ảnh CameraVN</h1>
            <p class="lead">Khám phá kiến thức, kỹ thuật và xu hướng mới nhất trong thế giới nhiếp ảnh</p>
        </div>
    </section>

    <!-- Blog Content -->
    <section class="blog-section">
        <div class="container">
            <div class="row">
                <!-- Blog Posts -->
                <div class="col-lg-8">
                    <div class="row">
                        <?php if (!empty($published_blogs)): ?>
                            <?php foreach ($published_blogs as $blog): ?>
                                <!-- Blog Post -->
                                <div class="col-md-6 mb-4">
                                    <div class="card blog-card h-100">
                                        <img src="<?= BASE_URL . 'View/assets/images/' . $blog->image ?>" class="card-img-top" alt="<?= $blog->title ?>">
                                        <div class="card-body">
                                            <div class="blog-meta">
                                                <span><i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($blog->published_at)) ?></span>
                                                <span><i class="bi bi-eye"></i> <?= number_format($blog->views) ?> lượt xem</span>
                                            </div>
                                            <span class="badge bg-primary mb-3"><?= $blog->category_name ?></span>
                                            <h5 class="card-title"><?= $blog->title ?></h5>
                                            <p class="card-text"><?= $blog->summary ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small"><i class="bi bi-person"></i> <?= $blog->author_name ?></span>
                                                <a href="index.php?page=blog_detail&id=<?= $blog->id ?>" class="btn btn-outline-primary btn-sm">Đọc tiếp <i class="bi bi-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p>Chưa có bài viết blog nào được xuất bản.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                    <nav class="blog-pagination" aria-label="Blog pagination">
                        <ul class="pagination">
                            <?php if ($current_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?page=blog&p=<?= $current_page - 1 ?><?= isset($_GET['category']) ? '&category=' . $_GET['category'] : '' ?>">
                                    <i class="bi bi-chevron-left"></i> Trước
                                </a>
                            </li>
                            <?php else: ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    <i class="bi bi-chevron-left"></i> Trước
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?page=blog&p=<?= $i ?><?= isset($_GET['category']) ? '&category=' . $_GET['category'] : '' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?page=blog&p=<?= $current_page + 1 ?><?= isset($_GET['category']) ? '&category=' . $_GET['category'] : '' ?>">
                                    Tiếp <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                            <?php else: ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    Tiếp <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Search Widget -->
                    <div class="blog-search">
                        <h5>Tìm kiếm</h5>
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Tìm kiếm bài viết...">
                                <button class="btn" type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Widget -->
                    <div class="blog-categories">
                        <h5>Danh mục</h5>
                        <?php if (!empty($categories)): ?>
                            <ul>
                                <?php foreach ($categories as $category): ?>
                                    <li>
                                        <a href="index.php?page=blog&category=<?= $category->slug ?>">
                                            <?= $category->name ?>
                                            <span class="badge rounded-pill"><?= $category->post_count ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Chưa có danh mục nào.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Popular Posts Widget -->
                    <?php
                        // $popular_posts = $blogModel->getFeaturedPosts(5); // Lấy 5 bài nổi bật nhất (Xóa dòng này)
                    ?>
                    <?php if (!empty($popular_posts)): ?>
                    <div class="blog-popular-posts">
                        <h5>Bài viết nổi bật</h5>
                        <ul>
                            <?php foreach ($popular_posts as $post): ?>
                            <li>
                                <a href="index.php?page=blog_detail&id=<?= $post->id ?>">
                                    <img src="<?= BASE_URL . 'View/assets/images/' . $post->image ?>" alt="<?= $post->title ?>" class="img-fluid rounded">
                                    <div class="post-info">
                                        <h6><?= $post->title ?></h6>
                                        <small><i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($post->published_at)) ?></small>
                                    </div>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php // TODO: Add Tags Widget ?>

                </div>
            </div>
        </div>
    </section>

</main>