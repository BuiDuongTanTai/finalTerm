<main>
    <!-- Page Header -->
    <section class="page-header py-5 mb-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fw-bold mb-3">Sản phẩm đã xem gần đây</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Recently Viewed Products Section -->
    <section class="py-5">
        <div class="container">
            <?php if(empty($recently_viewed_products)): ?>
            <!-- Empty Recently Viewed -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-clock-history" style="font-size: 5rem; color: #e0e0e0;"></i>
                </div>
                <h3>Chưa có sản phẩm nào được xem</h3>
                <p class="text-muted mb-4">Bạn chưa xem sản phẩm nào gần đây</p>
                <a href="index.php?page=all_products" class="btn btn-primary">
                    <i class="bi bi-shop me-2"></i>Khám phá sản phẩm
                </a>
            </div>
            <?php else: ?>
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h5>Những sản phẩm bạn đã xem gần đây (<?php echo count($recently_viewed_products); ?>)</h5>
                <a href="index.php?page=clear_recently_viewed" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-2"></i>Xóa lịch sử xem
                </a>
            </div>
            <div class="row g-4">
                <?php foreach($recently_viewed_products as $product): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="product-card h-100">
                        <div class="product-card-inner">
                            <div class="product-image-container">
                                <?php if(!empty($product->old_price) && $product->old_price > $product->price): 
                                    $discount_percent = round(100 - ($product->price / $product->old_price * 100));
                                ?>
                                    <div class="product-badge sale">-<?php echo $discount_percent; ?>%</div>
                                <?php elseif($product->is_new): ?>
                                    <div class="product-badge new">Mới</div>
                                <?php elseif($product->is_hot): ?>
                                    <div class="product-badge hot">Hot</div>
                                <?php elseif($product->is_best): ?>
                                    <div class="product-badge best">Best</div>
                                <?php endif; ?>
                                
                                <button type="button" class="product-wishlist-btn <?php echo isset($wishlist) && in_array($product->id, $wishlist) ? 'active' : ''; ?>" data-product-id="<?php echo $product->id; ?>">
                                    <i class="bi bi-heart"></i>
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                                
                                <div class="product-image" style="background-image: url('<?php echo $product->image_url; ?>');"></div>
                                
                                <div class="product-overlay">
                                    <button class="btn btn-sm btn-outline-primary product-quick-view-btn" data-product-id="<?php echo $product->id; ?>">
                                        <i class="bi bi-eye me-1"></i>Xem nhanh
                                    </button>
                                    <button class="btn btn-sm btn-primary product-add-to-cart-btn" data-product-id="<?php echo $product->id; ?>">
                                        <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ
                                    </button>
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
                                <div class="product-actions mt-3">
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
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>