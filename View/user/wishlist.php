<main>
    <!-- Wishlist Content -->
    <section class="py-5">
        <div class="container">
            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php if(empty($wishlist_products)): ?>
            <!-- Empty Wishlist -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-heart" style="font-size: 5rem; color: #e0e0e0;"></i>
                </div>
                <h3>Danh sách yêu thích trống</h3>
                <p class="text-muted mb-4">Bạn chưa thêm sản phẩm nào vào danh sách yêu thích</p>
                <a href="index.php?page=all_products" class="btn btn-primary">
                    <i class="bi bi-shop me-2"></i>Khám phá sản phẩm
                </a>
            </div>
            <?php else: ?>
            <div class="row">
                <?php foreach($wishlist_products as $product): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="product-card h-100">
                        <div class="product-card-inner">
                            <div class="product-image-container">
                                <?php if(!empty($product->old_price) && $product->old_price > $product->price): 
                                    $discount_percent = round(100 - ($product->price / $product->old_price * 100));
                                ?>
                                    <div class="product-badge sale">-<?php echo $discount_percent; ?>%</div>
                                <?php endif; ?>
                                
                                <?php if($product->is_new): ?>
                                    <div class="product-badge new">Mới</div>
                                <?php endif; ?>
                                
                                <button type="button" class="product-wishlist-btn active" data-product-id="<?php echo $product->id; ?>">
                                    <i class="bi bi-heart"></i>
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                                
                                <div class="product-image" style="background-image: url('<?php echo $product->image_url; ?>');"></div>
                                
                                <div class="product-overlay">
                                    <button class="btn btn-sm btn-outline-primary product-quick-view-btn" data-product-id="<?php echo $product->id; ?>">
                                        <i class="bi bi-eye me-1"></i>Xem nhanh
                                    </button>
                                    <a href="index.php?page=product_detail&id=<?php echo $product->id; ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-info-circle me-1"></i>Chi tiết
                                    </a>
                                </div>
                            </div>
                            
                            <div class="product-info">
                                <h5 class="product-title">
                                    <a href="index.php?page=product_detail&id=<?php echo $product->id; ?>" class="text-decoration-none text-dark">
                                        <?php echo $product->name; ?>
                                    </a>
                                </h5>
                                <div class="product-price-wrapper">
                                    <?php if(!empty($product->old_price) && $product->old_price > $product->price): ?>
                                        <span class="product-price-old"><?php echo number_format($product->old_price, 0, ',', '.'); ?>đ</span>
                                    <?php endif; ?>
                                    <span class="product-price"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted">Thêm vào: <?php echo date('d/m/Y', strtotime($product->added_at)); ?></small>
                                    <?php if($product->stock > 0): ?>
                                    <button type="button" class="btn btn-primary btn-sm add-to-cart-btn" data-product-id="<?php echo $product->id; ?>">
                                        <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ
                                    </button>
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
            
            <!-- Return Button -->
            <div class="text-center mt-5">
                <a href="index.php?page=profile" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Quay lại trang tài khoản
                </a>
            </div>
        </div>
    </section>
</main>

