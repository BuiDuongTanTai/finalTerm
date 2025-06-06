<main>
    <!-- Page Header -->
    <section class="page-header py-5 mb-5 bg-light">
                <div class="col-12 text-center">
                    <h1 class="fw-bold mb-3"><?php echo $title; ?></h1>
                </div>
    </section>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="product-filter-advanced sticky-lg" style="top: 20px;" data-aos="fade-right">
                        <div class="filter-section mb-4">
                            <h5 class="filter-title d-flex justify-content-between align-items-center">
                                Danh mục sản phẩm
                                <i class="bi bi-chevron-down"></i>
                            </h5>
                            <div class="filter-body show">
                                <ul class="list-unstyled mb-0">
                                    <li>
                                        <a href="index.php?page=all_products" class="filter-link d-block py-2 <?php echo empty($category) ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                            <i class="bi bi-chevron-right me-2"></i>Tất cả
                                        </a>
                                    </li>
                                    <?php foreach($categories as $cat): ?>
                                    <li>
                                        <a href="index.php?page=all_products&category=<?php echo $cat->slug; ?>" class="filter-link d-block py-2 <?php echo $category == $cat->slug ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                            <i class="bi bi-chevron-right me-2"></i><?php echo $cat->name; ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="filter-section mb-4">
                            <h5 class="filter-title d-flex justify-content-between align-items-center">
                                Thương hiệu
                                <i class="bi bi-chevron-down"></i>
                            </h5>
                            <div class="filter-body show">
                                <ul class="list-unstyled mb-0">
                                    <li>
                                        <a href="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?>" class="filter-link d-block py-2 <?php echo empty($brand) ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                            <i class="bi bi-chevron-right me-2"></i>Tất cả
                                        </a>
                                    </li>
                                    <?php foreach($brands as $b): ?>
                                    <li>
                                        <a href="index.php?page=all_products&brand=<?php echo $b->slug; ?><?php echo !empty($category) ? '&category=' . $category : ''; ?>" class="filter-link d-block py-2 <?php echo $brand == $b->slug ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                            <i class="bi bi-chevron-right me-2"></i><?php echo $b->name; ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="filter-section mb-4">
                            <h5 class="filter-title d-flex justify-content-between align-items-center">
                                Khoảng giá
                                <i class="bi bi-chevron-down"></i>
                            </h5>
                            <div class="filter-body show">
                                <ul class="list-unstyled mb-0">
                                    <li>
                                        <a href="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?>" class="filter-link d-block py-2 <?php echo ($min_price == 0 && $max_price == 0) ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                            <i class="bi bi-chevron-right me-2"></i>Tất cả mức giá
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=all_products&min_price=0&max_price=5000000<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?>" class="filter-link d-block py-2 <?php echo ($min_price == 0 && $max_price == 5000000) ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                            <i class="bi bi-chevron-right me-2"></i>Dưới 5 triệu
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=all_products&min_price=5000000&max_price=15000000<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?>" class="filter-link d-block py-2 <?php echo ($min_price == 5000000 && $max_price == 15000000) ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                            <i class="bi bi-chevron-right me-2"></i>5 - 15 triệu
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=all_products&min_price=15000000&max_price=30000000<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?>" class="filter-link d-block py-2 <?php echo ($min_price == 15000000 && $max_price == 30000000) ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                            <i class="bi bi-chevron-right me-2"></i>15 - 30 triệu
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=all_products&min_price=30000000&max_price=50000000<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?>" class="filter-link d-block py-2 <?php echo ($min_price == 30000000 && $max_price == 50000000) ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                            <i class="bi bi-chevron-right me-2"></i>30 - 50 triệu
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=all_products&min_price=50000000&max_price=1000000000<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?>" class="filter-link d-block py-2 <?php echo ($min_price == 50000000 && $max_price == 1000000000) ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                            <i class="bi bi-chevron-right me-2"></i>Trên 50 triệu
                                        </a>
                                    </li>
                                </ul>
                                
                                <div class="mt-3">
                                    <form action="index.php" method="get" class="price-filter-form">
                                        <input type="hidden" name="page" value="all_products">
                                        <?php if (!empty($category)): ?>
                                        <input type="hidden" name="category" value="<?php echo $category; ?>">
                                        <?php endif; ?>
                                        <?php if (!empty($brand)): ?>
                                        <input type="hidden" name="brand" value="<?php echo $brand; ?>">
                                        <?php endif; ?>
                                        <?php if (!empty($sort)): ?>
                                        <input type="hidden" name="sort" value="<?php echo $sort; ?>">
                                        <?php endif; ?>
                                        <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">Áp dụng</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <a href="index.php?page=all_products" class="btn btn-outline-danger">Xóa bộ lọc</a>
                        </div>
                    </div>
                </div>
                
                <!-- Products Grid -->
                <div class="col-lg-9" data-aos="fade-left">
                    <!-- Sort and Filter Bar -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <span class="me-2">Sắp xếp theo:</span>
                            <select class="form-select form-select-sm" id="sortBy" onchange="window.location.href=this.value">
                                <option value="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?><?php echo ($min_price > 0 || $max_price > 0) ? '&min_price=' . $min_price . '&max_price=' . $max_price : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&sort=popular" <?php echo $sort == 'popular' ? 'selected' : ''; ?>>Phổ biến nhất</option>
                                <option value="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?><?php echo ($min_price > 0 || $max_price > 0) ? '&min_price=' . $min_price . '&max_price=' . $max_price : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&sort=newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                                <option value="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?><?php echo ($min_price > 0 || $max_price > 0) ? '&min_price=' . $min_price . '&max_price=' . $max_price : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&sort=price-asc" <?php echo $sort == 'price-asc' ? 'selected' : ''; ?>>Giá: Thấp đến cao</option>
                                <option value="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?><?php echo ($min_price > 0 || $max_price > 0) ? '&min_price=' . $min_price . '&max_price=' . $max_price : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&sort=price-desc" <?php echo $sort == 'price-desc' ? 'selected' : ''; ?>>Giá: Cao đến thấp</option>
                                <option value="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?><?php echo ($min_price > 0 || $max_price > 0) ? '&min_price=' . $min_price . '&max_price=' . $max_price : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&sort=rating" <?php echo $sort == 'rating' ? 'selected' : ''; ?>>Đánh giá</option>
                            </select>
                        </div>
                        <div>
                            <span>Hiển thị <?php echo count($products); ?> trong <?php echo $total_products; ?> sản phẩm</span>
                        </div>
                    </div>
                    
                    <?php if (!empty($search)): ?>
                    <div class="alert alert-info mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span>Kết quả tìm kiếm cho: <strong>"<?php echo $search; ?>"</strong></span>
                            </div>
                            <a href="index.php?page=all_products" class="btn btn-sm btn-outline-primary">Xóa tìm kiếm</a>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Products Grid -->
                    <?php if (empty($products)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-search" style="font-size: 3rem; color: #ddd;"></i>
                        <h3 class="mt-3">Không tìm thấy sản phẩm</h3>
                        <p class="text-muted">Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
                        <a href="index.php?page=all_products" class="btn btn-primary mt-3">Xem tất cả sản phẩm</a>
                    </div>
                    <?php else: ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach($products as $product): ?>
                        <div class="col-md-6 col-lg-4 mb-4 product-item" data-category="<?php echo $product->brand_name; ?>">
                        <div class="product-card h-100">
                            <div class="product-card-inner">
                                <div class="product-image-container">
                                <?php 
                                    // Xử lý hiển thị badge theo thứ tự ưu tiên: discount > hot > new > bestseller
                                    $badges = [];
                                    if (!empty($product->badges)) {
                                        $badges = json_decode($product->badges, true);
                                        if (!is_array($badges)) {
                                            $badges = [];
                                        }
                                    }

                                    // Chỉ hiển thị 1 badge theo thứ tự ưu tiên
                                    $badge_displayed = false;

                                    // 1. Ưu tiên cao nhất: Badge discount
                                    if (!$badge_displayed && (in_array('discount', $badges) || (!empty($product->old_price) && $product->old_price > $product->price))) {
                                        $discount_percent = 0;
                                        if (!empty($product->old_price) && $product->old_price > $product->price) {
                                            $discount_percent = round(100 - ($product->price / $product->old_price * 100));
                                        }
                                        if ($discount_percent > 0) {
                                            echo '<div class="product-badge sale">-' . $discount_percent . '%</div>';
                                        } else {
                                            echo '<div class="product-badge sale">SALE</div>';
                                        }
                                        $badge_displayed = true;
                                    }
                                    // 2. Ưu tiên thứ 2: Badge hot
                                    elseif (!$badge_displayed && (in_array('hot', $badges) || $product->is_hot)) {
                                        echo '<div class="product-badge hot">Hot</div>';
                                        $badge_displayed = true;
                                    }
                                    // 3. Ưu tiên thứ 3: Badge new
                                    elseif (!$badge_displayed && (in_array('new', $badges) || $product->is_new)) {
                                        echo '<div class="product-badge new">Mới</div>';
                                        $badge_displayed = true;
                                    }
                                    // 4. Ưu tiên thấp nhất: Badge bestseller
                                    elseif (!$badge_displayed && (in_array('bestseller', $badges) || $product->is_best)) {
                                        echo '<div class="product-badge best">Best</div>';
                                        $badge_displayed = true;
                                    }
                                ?>
                                    
                                    <button type="button" class="product-wishlist-btn" data-product-id="<?php echo $product->id; ?>">
                                        <i class="bi bi-heart"></i>
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                    
                                    <div class="product-image" style="background-image: url('<?php echo $product->image_url; ?>');"></div>
                                    
                                    <div class="product-overlay">
                                        <button class="btn btn-sm btn-outline-primary product-quick-view-btn" data-product-id="<?php echo $product->id; ?>">
                                            <i class="bi bi-eye me-1"></i>Xem nhanh
                                        </button>
                                        <?php if($product->stock > 0): ?>
                                            <form action="index.php?page=add_to_cart" method="post" class="d-inline">
                                                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ
                                                </button>
                                            </form>
                                            <?php else: ?>
                                            <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                <i class="bi bi-x-circle me-1"></i>Hết hàng
                                            </button>
                                            <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="product-info">
                                    <div class="product-brand"><?php echo $product->brand_name; ?></div>
                                    <h5 class="product-title">
                                        <a href="index.php?page=product_detail&id=<?php echo $product->id; ?>" class="text-decoration-none text-dark">
                                            <?php echo $product->name; ?>
                                        </a>
                                    </h5>
                                    <div class="product-rating">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= floor($product->rating)): ?>
                                                <i class="bi bi-star-fill"></i>
                                            <?php elseif($i - 0.5 <= $product->rating): ?>
                                                <i class="bi bi-star-half"></i>
                                            <?php else: ?>
                                                <i class="bi bi-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <span><?php echo $product->rating; ?> (<?php echo $product->reviews_count; ?>)</span>
                                    </div>
                                    <div class="product-price-wrapper">
                                        <?php if(!empty($product->old_price) && $product->old_price > $product->price): ?>
                                            <span class="product-price-old"><?php echo number_format($product->old_price, 0, ',', '.'); ?>đ</span>
                                        <?php endif; ?>
                                        <span class="product-price"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span>
                                    </div>
                                    <div class="product-meta">
                                        <div class="product-stock <?php echo $product->stock > 10 ? 'in-stock' : ($product->stock > 0 ? 'limited' : 'out-of-stock'); ?>">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span><?php echo $product->stock > 10 ? 'Còn hàng' : ($product->stock > 0 ? 'Sắp hết hàng' : 'Hết hàng'); ?></span>
                                        </div>
                                        <div class="product-sold">
                                            <i class="bi bi-bag-check"></i>
                                            <span>Đã bán: <?php echo $product->sold_count; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?><?php echo !empty($sort) ? '&sort=' . $sort : ''; ?><?php echo ($min_price > 0 || $max_price > 0) ? '&min_price=' . $min_price . '&max_price=' . $max_price : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&page_no=<?php echo $page - 1; ?>">
                                    <i class="bi bi-chevron-left"></i> Trước
                                </a>
                            </li>
                            <?php else: ?>
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-chevron-left"></i> Trước</span>
                            </li>
                            <?php endif; ?>
                            
                            <?php
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages, $page + 2);
                            
                            if ($start_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?><?php echo !empty($sort) ? '&sort=' . $sort : ''; ?><?php echo ($min_price > 0 || $max_price > 0) ? '&min_price=' . $min_price . '&max_price=' . $max_price : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&page_no=1">1</a>
                                </li>
                                <?php if ($start_page > 2): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?><?php echo !empty($sort) ? '&sort=' . $sort : ''; ?><?php echo ($min_price > 0 || $max_price > 0) ? '&min_price=' . $min_price . '&max_price=' . $max_price : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&page_no=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($end_page < $total_pages): ?>
                                <?php if ($end_page < $total_pages - 1): ?>
<li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?><?php echo !empty($sort) ? '&sort=' . $sort : ''; ?><?php echo ($min_price > 0 || $max_price > 0) ? '&min_price=' . $min_price . '&max_price=' . $max_price : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&page_no=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
                                </li>
                            <?php endif; ?>
                            
                            <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?page=all_products<?php echo !empty($category) ? '&category=' . $category : ''; ?><?php echo !empty($brand) ? '&brand=' . $brand : ''; ?><?php echo !empty($sort) ? '&sort=' . $sort : ''; ?><?php echo ($min_price > 0 || $max_price > 0) ? '&min_price=' . $min_price . '&max_price=' . $max_price : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&page_no=<?php echo $page + 1; ?>">
                                    Tiếp <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                            <?php else: ?>
                            <li class="page-item disabled">
                                <span class="page-link">Tiếp <i class="bi bi-chevron-right"></i></span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickViewModalLabel">Xem nhanh sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="quick-view-image mb-3" id="quickViewImage"></div>
                        <div class="quick-view-thumbs">
                            <div class="quick-view-thumb active" style="background-image: url('View/assets/images/product1.jpg');"></div>
                            <div class="quick-view-thumb" style="background-image: url('View/assets/images/product2.jpg');"></div>
                            <div class="quick-view-thumb" style="background-image: url('View/assets/images/product3.jpg');"></div>
                            <div class="quick-view-thumb" style="background-image: url('View/assets/images/product4.jpg');"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="quick-view-title" id="quickViewTitle">Product Title</h3>
                        <div class="quick-view-price mb-3" id="quickViewPrice">$0.00</div>
                        <div class="quick-view-description mb-4" id="quickViewDescription">Product description here.</div>
                        
                        <div class="quick-view-meta mb-4">
                            <div class="quick-view-meta-item">
                                <i class="bi bi-shield-check text-primary"></i>
                                <span>Bảo hành chính hãng 24 tháng</span>
                            </div>
                            <div class="quick-view-meta-item">
                                <i class="bi bi-truck text-primary"></i>
                                <span>Giao hàng miễn phí</span>
                            </div>
                        </div>
                        
                        <div class="quick-view-quantity">
                            <span>Số lượng:</span>
                            <button class="quantity-btn" id="decreaseQuantity">-</button>
                            <input type="text" id="quantityInput" class="form-control quantity-input" value="1">
                            <button class="quantity-btn" id="increaseQuantity">+</button>
                        </div>
                        
                        <div class="quick-view-actions">
                            <button class="btn btn-primary flex-grow-1" id="quickViewAddToCart" data-product="0">
                                <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ hàng
                            </button>
                            <button class="btn btn-outline-secondary" id="quickViewWishlist" data-product="0">
                                <i class="bi bi-heart me-1"></i>Thêm vào yêu thích
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý tất cả các link lọc
    const filterLinks = document.querySelectorAll('.filter-link');
    filterLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            loadProducts(url);
        });
    });

    // Xử lý select sắp xếp
    const sortSelect = document.getElementById('sortBy');
    if(sortSelect) {
        sortSelect.addEventListener('change', function() {
            const url = this.value;
            loadProducts(url);
        });
    }

    // Hàm load sản phẩm bằng AJAX
    function loadProducts(url) {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const productsGrid = document.querySelector('.row-cols-1');
                const newProductsGrid = doc.querySelector('.row-cols-1');
                
                if(productsGrid && newProductsGrid) {
                    productsGrid.innerHTML = newProductsGrid.innerHTML;
                }

                // Cập nhật URL mà không reload trang
                window.history.pushState({}, '', url);
            })
            .catch(error => console.error('Error:', error));
    }
});
</script>

