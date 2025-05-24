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
                            <label class="form-label">Trạng thái</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status1" value="1" <?php echo $product['status'] == 1 ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="status1">Hiện</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status0" value="0" <?php echo $product['status'] == 0 ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="status0">Ẩn</label>
                                </div>
                            </div>
                        </div>
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