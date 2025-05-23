
<main>
    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 hero-title">Chụp lại khoảnh khắc</h1>
                    <h2 class="display-5">với công nghệ hàng đầu</h2>
                    <p class="lead mb-4">Khám phá các dòng máy ảnh chuyên nghiệp từ những thương hiệu uy tín nhất thế giới.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="index.php?page=all_products" class="btn btn-primary btn-lg px-4 shadow-sm">Mua ngay</a>
                        <a href="#services" class="btn btn-outline-light btn-lg px-4">Dịch vụ</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Danh mục sản phẩm</h2>
                <p class="lead">Khám phá các dòng sản phẩm đa dạng và chất lượng tại CameraVN</p>
            </div>
            
            <div class="row g-4" data-aos="fade-up">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <a href="index.php?page=all_products&category=dslr" class="text-decoration-none">
                        <div class="category-card text-center p-4">
                            <div class="category-icon">
                                <i class="bi bi-camera"></i>
                            </div>
                            <h4>Máy ảnh DSLR</h4>
                            <p class="text-muted mb-0">Khám phá các dòng máy ảnh DSLR chuyên nghiệp</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="index.php?page=all_products&category=mirrorless" class="text-decoration-none">
                        <div class="category-card text-center p-4">
                            <div class="category-icon">
                                <i class="bi bi-camera2"></i>
                            </div>
                            <h4>Máy ảnh Mirrorless</h4>
                            <p class="text-muted mb-0">Nhỏ gọn, hiệu suất cao, lựa chọn của nhiếp ảnh gia hiện đại</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="index.php?page=all_products&category=lens" class="text-decoration-none">
                        <div class="category-card text-center p-4">
                            <div class="category-icon">
                                <i class="bi bi-circles-extend"></i>
                            </div>
                            <h4>Ống kính (Lens)</h4>
                            <p class="text-muted mb-0">Ống kính chất lượng cao cho mọi nhu cầu nhiếp ảnh</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>Sản phẩm chính hãng</h4>
                        <p class="text-muted">Mọi sản phẩm tại CameraVN đều được nhập khẩu chính hãng 100%, đảm bảo chất lượng và độ tin cậy cao nhất.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-tools"></i>
                        </div>
                        <h4>Bảo hành toàn quốc</h4>
                        <p class="text-muted">Chế độ bảo hành chính hãng lên đến 24 tháng với hệ thống trung tâm bảo hành trên toàn quốc.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h4>Giao hàng miễn phí</h4>
                        <p class="text-muted">Miễn phí giao hàng toàn quốc cho đơn hàng từ 5 triệu đồng, đảm bảo an toàn và nhanh chóng.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured-products-section py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Sản phẩm nổi bật</h2>
                <p class="lead">Khám phá các sản phẩm máy ảnh và phụ kiện hàng đầu từ thương hiệu nổi tiếng thế giới</p>
            </div>
            
            <div class="product-filter-wrapper mb-4" data-aos="fade-up">
                <button type="button" class="product-filter-btn active" data-filter="all">Tất cả</button>
                <button type="button" class="product-filter-btn" data-filter="Canon">Canon</button>
                <button type="button" class="product-filter-btn" data-filter="Sony">Sony</button>
                <button type="button" class="product-filter-btn" data-filter="Nikon">Nikon</button>
                <button type="button" class="product-filter-btn" data-filter="Fujifilm">Fujifilm</button>
                <button type="button" class="product-filter-btn" data-filter="Panasonic">Panasonic</button>
                <button type="button" class="product-filter-btn" data-filter="Leica">Leica</button>
            </div>
            
            <div class="row g-4" data-aos="fade-up">
                <?php if (!empty($featured_products)): ?>
                    <?php foreach ($featured_products as $product): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-4 product-item" data-category="<?php echo $product->brand_name; ?>">
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
                                    
                                    <button type="button" class="product-wishlist-btn" data-product-id="<?php echo $product->id; ?>">
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
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>Không có sản phẩm nổi bật nào.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="index.php?page=all_products" class="btn btn-outline-primary view-all-products-btn">
                    Xem tất cả sản phẩm <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Promotion Banner with Enhanced Animations -->
    <section class="container my-5" data-aos="fade-up">
        <div class="card promo-banner border-0 overflow-hidden">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-lg-8 p-5 d-flex align-items-center promo-content">
                        <div>
                            <h2 class="mb-3 fw-bold display-5 promo-title">Khuyến mãi đặc biệt tháng 3</h2>
                            <p class="lead mb-4 promo-description">Giảm đến 30% cho dòng máy ảnh Sony Alpha và ống kính Canon RF Series.</p>
                            <div class="countdown-timer">
                                <div class="countdown-box">
                                    <div class="countdown-number" id="days">15</div>
                                    <div class="countdown-label">Ngày</div>
                                </div>
                                <div class="countdown-box">
                                    <div class="countdown-number" id="hours">08</div>
                                    <div class="countdown-label">Giờ</div>
                                </div>
                                <div class="countdown-box">
                                    <div class="countdown-number" id="minutes">45</div>
                                    <div class="countdown-label">Phút</div>
                                </div>
                                <div class="countdown-box">
                                    <div class="countdown-number" id="seconds">20</div>
                                    <div class="countdown-label">Giây</div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-cta mt-4">Mua ngay</a>
                        </div>
                    </div>
                    <!-- <div class="col-lg-4 position-relative promo-image-container"> -->
                        <img src="View/assets/images/hero - Copy.jpg" alt="Camera Promo" class="promo-image">
                        <div class="floating-discount-badge">-30%</div>
                        <div class="pulse-circle"></div>
                        <div class="pulse-circle delay-1"></div>
                        <div class="pulse-circle delay-2"></div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </section>

    <!-- New Products Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Sản phẩm mới</h2>
                <p class="lead">Khám phá các sản phẩm mới nhất vừa được ra mắt tại CameraVN</p>
            </div>
            
            <div class="row g-4" data-aos="fade-up">
                <?php if (!empty($new_products)): ?>
                    <?php foreach ($new_products as $index => $product): ?>
                        <?php if ($index < 4): // Chỉ hiển thị 4 sản phẩm ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="product-card h-100">
                                <div class="product-card-inner">
                                    <div class="product-image-container">
                                        <div class="product-badge new">Mới</div>
                                        
                                        <button type="button" class="product-wishlist-btn" data-product-id="<?php echo $product->id; ?>">
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
                                        <div class="product-price-wrapper">
                                            <?php if(!empty($product->old_price) && $product->old_price > $product->price): ?>
                                                <span class="product-price-old"><?php echo number_format($product->old_price, 0, ',', '.'); ?>đ</span>
                                            <?php endif; ?>
                                            <span class="product-price"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>Không có sản phẩm mới nào.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (count($new_products) > 4): ?>
            <div class="text-center mt-4">
                <a href="index.php?page=all_products?sort=newest" class="btn btn-outline-primary">
                    Xem thêm sản phẩm mới <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Best Selling Products -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Sản phẩm bán chạy</h2>
                <p class="lead">Những sản phẩm được khách hàng tin dùng và lựa chọn nhiều nhất</p>
            </div>
            
            <div class="row g-4" data-aos="fade-up">
                <?php if (!empty($bestselling_products)): ?>
                    <?php foreach ($bestselling_products as $index => $product): ?>
                        <?php if ($index < 4): // Chỉ hiển thị 4 sản phẩm ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="product-card h-100">
                                <div class="product-card-inner">
                                    <div class="product-image-container">
                                        <?php if($product->is_best): ?>
                                            <div class="product-badge best">Best</div>
                                        <?php elseif($product->is_hot): ?>
                                            <div class="product-badge hot">Hot</div>
                                        <?php endif; ?>
                                        
                                        <button type="button" class="product-wishlist-btn" data-product-id="<?php echo $product->id; ?>">
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
                                            <span><?php echo $product->rating; ?></span>
                                        </div>
                                        <div class="product-price-wrapper">
                                            <?php if(!empty($product->old_price) && $product->old_price > $product->price): ?>
                                                <span class="product-price-old"><?php echo number_format($product->old_price, 0, ',', '.'); ?>đ</span>
                                            <?php endif; ?>
                                            <span class="product-price"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span>
                                        </div>
                                        <div class="product-sold mt-2">
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo min(100, ($product->sold_count / ($product->sold_count + $product->stock)) * 100); ?>%" aria-valuenow="<?php echo $product->sold_count; ?>" aria-valuemin="0" aria-valuemax="<?php echo $product->sold_count + $product->stock; ?>"></div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-1">
                                                <small>Đã bán: <?php echo $product->sold_count; ?></small>
                                                <small>Còn lại: <?php echo $product->stock; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>Không có sản phẩm bán chạy nào.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (count($bestselling_products) > 4): ?>
            <?php endif; ?>
        </div>
    </section>

        <!-- Why Choose Us Section -->
    <section class="why-choose-us py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Tại sao chọn CameraVN?</h2>
                <p class="lead">Chúng tôi tự hào mang đến cho bạn những sản phẩm chất lượng với dịch vụ hoàn hảo</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="choose-us-item text-center">
                        <div class="choose-us-icon mx-auto mb-4">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5>Sản phẩm chính hãng</h5>
                        <p class="text-muted">100% nhập khẩu trực tiếp từ nhà sản xuất</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="choose-us-item text-center">
                        <div class="choose-us-icon mx-auto mb-4">
                            <i class="bi bi-patch-check"></i>
                        </div>
                        <h5>Bảo hành chính hãng</h5>
                        <p class="text-muted">Thời gian bảo hành lên đến 24 tháng</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="choose-us-item text-center">
                        <div class="choose-us-icon mx-auto mb-4">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h5>Tư vấn chuyên nghiệp</h5>
                        <p class="text-muted">Đội ngũ tư vấn viên là nhiếp ảnh gia</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="choose-us-item text-center">
                        <div class="choose-us-icon mx-auto mb-4">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h5>Giao hàng toàn quốc</h5>
                        <p class="text-muted">Miễn phí giao hàng với đơn từ 5 triệu</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonial-section py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Khách hàng nói gì về chúng tôi</h2>
                <p class="lead">Những phản hồi từ khách hàng là động lực để chúng tôi không ngừng cải thiện dịch vụ</p>
            </div>
            
            <div class="testimonial-swiper swiper" data-aos="fade-up">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-avatar">NT</div>
                            <div class="testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="testimonial-content">
                                "Tôi đã mua chiếc Sony A7 IV tại CameraVN và vô cùng hài lòng. Sản phẩm chính hãng, nhân viên tư vấn chuyên nghiệp và tận tình. Chắc chắn sẽ quay lại mua thêm ống kính."
                            </div>
                            <h5 class="testimonial-author">Nguyễn Thanh</h5>
                            <p class="testimonial-role">Nhiếp ảnh gia chuyên nghiệp</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-avatar">TH</div>
                            <div class="testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <div class="testimonial-content">
                                "Dịch vụ bảo dưỡng máy ảnh tại CameraVN rất tốt. Máy ảnh Nikon của tôi được vệ sinh kỹ lưỡng, chất lượng ảnh cải thiện rõ rệt. Giá cả hợp lý, thời gian nhanh chóng."
                            </div>
                            <h5 class="testimonial-author">Trần Hải</h5>
                            <p class="testimonial-role">Nhiếp ảnh gia tự do</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-avatar">PL</div>
                            <div class="testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <div class="testimonial-content">
                                "Khóa học nhiếp ảnh cơ bản tại CameraVN thực sự hữu ích cho người mới. Giảng viên nhiệt tình, nhiều bài thực hành thực tế. Đã nâng cao kỹ năng chụp ảnh của tôi rất nhiều."
                            </div>
                            <h5 class="testimonial-author">Phạm Lan</h5>
                            <p class="testimonial-role">Sinh viên</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-avatar">HN</div>
                            <div class="testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="testimonial-content">
                                "Tôi đã mua ống kính Canon tại CameraVN và được tư vấn rất kỹ về sản phẩm. Nhân viên kiến thức chuyên sâu, giá cả cạnh tranh. Sẽ quay lại nhiều lần nữa!"
                            </div>
                            <h5 class="testimonial-author">Hoàng Nam</h5>
                            <p class="testimonial-role">YouTuber</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mb-4">Đăng ký nhận thông tin</h2>
                    <p class="text-white mb-4">Cập nhật tin tức về sản phẩm mới, khuyến mãi và các bài viết hướng dẫn nhiếp ảnh.</p>
                    <div class="newsletter-form">
                        <input type="email" class="form-control newsletter-input" placeholder="Email của bạn">
                        <button type="submit" class="btn btn-dark newsletter-btn">Đăng ký</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                            <div class="quick-view-thumbs" id="quickViewThumbs">
                                <!-- Thumbnails will be added dynamically -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 class="h4 mb-2" id="quickViewProductName">Tên sản phẩm</h3>
                            
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <span class="me-2">Brand:</span>
                                    <strong id="quickViewBrand">Brand Name</strong>
                                </div>
                                <div>
                                    <span class="me-2">SKU:</span>
                                    <span id="quickViewSku">SKU123456</span>
                                </div>
                            </div>
                            
                            <div id="quickViewRating" class="mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span id="quickViewReviewCount">(42 đánh giá)</span>
                            </div>
                            
                            <div class="mb-3">
                                <span class="h5 text-primary fw-bold" id="quickViewPrice">19.490.000đ</span>
                                <span class="text-decoration-line-through text-muted ms-2" id="quickViewOldPrice">22.990.000đ</span>
                            </div>
                            
                            <div class="mb-4" id="quickViewDescription">
                                Mô tả ngắn về sản phẩm sẽ được hiển thị ở đây.
                            </div>
                            
                            <div class="mb-3" id="quickViewStockContainer">
                                <span class="me-2">Tình trạng:</span>
                                <span class="text-success" id="quickViewStockStatus">
                                    <i class="bi bi-check-circle"></i> Còn hàng
                                </span>
                            </div>
                            
                            <div class="mb-3 d-none" id="quickViewColorContainer">
                                <label class="form-label">Màu sắc:</label>
                                <div id="quickViewColors" class="d-flex gap-2">
                                    <!-- Colors will be added dynamically -->
                                </div>
                            </div>
                            
                            <div class="mb-3 d-none" id="quickViewVariationContainer">
                                <label class="form-label">Phiên bản:</label>
                                <div id="quickViewVariations" class="d-flex gap-2">
                                    <!-- Variations will be added dynamically -->
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Số lượng:</label>
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-secondary" id="decreaseQuantity">-</button>
                                    <input type="number" id="quantityInput" class="form-control mx-2 text-center" value="1" min="1" style="width: 70px;">
                                    <button type="button" class="btn btn-outline-secondary" id="increaseQuantity">+</button>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-3 mb-3">
                                <button type="button" class="btn btn-primary flex-grow-1" id="quickViewAddToCart">
                                    <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ hàng
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="quickViewWishlist">
                                    <i class="bi bi-heart me-1"></i>Thêm vào yêu thích
                                </button>
                            </div>
                            
                            <a href="#" id="quickViewDetailLink" class="btn btn-link text-decoration-none">
                                <i class="bi bi-info-circle me-1"></i>Xem chi tiết sản phẩm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>


