<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Chỉnh sửa sản phẩm</h5>
        </div>
        <div class="card-body">
            <form action="index.php?act=update_product" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Chọn danh mục</option>
                                <?php
                                $DBH = connect();
                                $stmt = $DBH->query("SELECT id, name FROM categories WHERE status = 1");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($row['id'] == $product['category_id']) ? 'selected' : '';
                                    echo "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
                                        <span class="input-group-text">VND</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="old_price" class="form-label">Giá cũ (để tính giảm giá)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="old_price" name="old_price" value="<?php echo $product['old_price'] ?? 0; ?>">
                                        <span class="input-group-text">VND</span>
                                    </div>
                                    <small class="text-muted">Để trống hoặc 0 nếu không có giá cũ</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Số lượng</label>
                                    <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $product['stock']; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="5"><?php echo $product['description']; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh</label>
                            <?php if (!empty($product['image_url'])): ?>
                                <div class="mb-2">
                                    <img src="<?php echo $product['image_url']; ?>" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="image" name="image">
                            <small class="text-muted">Để trống nếu không muốn thay đổi hình ảnh</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Hiển thị sản phẩm trong các section</label>
                            <div class="section-checkboxes">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" 
                                        <?php echo $product['is_featured'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_featured">
                                        <span class="badge bg-primary">NỔI BẬT</span> - Hiển thị trong section "Sản phẩm nổi bật"
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_new" value="1" id="is_new"
                                        <?php echo $product['is_new'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_new">
                                        <span class="badge bg-info">MỚI</span> - Hiển thị trong section "Sản phẩm mới"
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_bestseller" value="1" id="is_bestseller"
                                        <?php echo $product['is_bestseller'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_bestseller">
                                        <span class="badge bg-success">BÁN CHẠY</span> - Hiển thị trong section "Sản phẩm bán chạy"
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_discount" value="1" id="is_discount"
                                        <?php echo $product['is_discount'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_discount">
                                        <span class="badge bg-warning">GIẢM GIÁ</span> - Hiển thị trong section "Sản phẩm giảm giá"
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_promotion" value="1" id="is_promotion"
                                        <?php echo $product['is_promotion'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_promotion">
                                        <span class="badge bg-danger">KHUYẾN MÃI</span> - Hiển thị trong banner khuyến mãi
                                    </label>
                                </div>
                            </div>
                            <small class="text-muted">Có thể chọn nhiều section để hiển thị sản phẩm</small>
                        </div>

                        <div class="mb-3" id="promotion_url_section" style="<?php echo $product['is_promotion'] ? '' : 'display: none;'; ?>">
                            <label for="promotion_url" class="form-label">Link tùy chỉnh cho nút "Mua ngay" (Khuyến mãi)</label>
                            <input type="url" class="form-control" id="promotion_url" name="promotion_url" 
                                value="<?php echo $product['promotion_url'] ?? ''; ?>" 
                                placeholder="Ví dụ: index.php?page=product_detail&id=<?php echo $product['id']; ?>">
                            <small class="text-muted">Để trống sẽ dùng link mặc định đến trang chi tiết sản phẩm</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Badge hiển thị trên sản phẩm</label>
                            <div class="badge-checkboxes">
                                <?php 
                                $current_badges = [];
                                if (!empty($product['badges'])) {
                                    $current_badges = json_decode($product['badges'], true);
                                    if (!is_array($current_badges)) {
                                        $current_badges = [];
                                    }
                                }
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="badges[]" value="hot" id="badge_hot" 
                                        <?php echo in_array('hot', $current_badges) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="badge_hot">
                                        <span class="badge bg-danger">HOT</span> - Badge nổi bật
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="badges[]" value="new" id="badge_new"
                                        <?php echo in_array('new', $current_badges) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="badge_new">
                                        <span class="badge bg-info">NEW</span> - Badge mới
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="badges[]" value="bestseller" id="badge_bestseller"
                                        <?php echo in_array('bestseller', $current_badges) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="badge_bestseller">
                                        <span class="badge bg-success">BESTSELLER</span> - Badge bán chạy
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="badges[]" value="discount" id="badge_discount"
                                        <?php echo in_array('discount', $current_badges) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="badge_discount">
                                        <span class="badge bg-warning">DISCOUNT</span> - Badge giảm giá
                                    </label>
                                </div>
                            </div>
                            <small class="text-muted">Badge sẽ hiển thị trên ảnh sản phẩm theo thứ tự ưu tiên</small>
                        </div>

                        <script>
                        // Hiển thị/ẩn trường promotion_url khi tick/untick is_promotion
                        document.getElementById('is_promotion').addEventListener('change', function() {
                            const promotionUrlSection = document.getElementById('promotion_url_section');
                            const promotionUrlInput = document.getElementById('promotion_url');
                            
                            if (this.checked) {
                                promotionUrlSection.style.display = 'block';
                                // Auto fill với link chi tiết sản phẩm nếu trống
                                if (!promotionUrlInput.value) {
                                    promotionUrlInput.value = 'index.php?page=product_detail&id=<?php echo $product['id']; ?>';
                                }
                            } else {
                                promotionUrlSection.style.display = 'none';
                            }
                        });
                        </script>
                    </div>
                </div>
                
                <div class="mb-3">
                    <a href="index.php?act=product" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>