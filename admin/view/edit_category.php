<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Chỉnh sửa danh mục</h5>
        </div>
        <div class="card-body">
            <form action="index.php?act=update_category" method="post">
                <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên danh mục</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $category['name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo $category['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="status1" value="1" <?php echo $category['status'] == 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="status1">Hiện</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="status0" value="0" <?php echo $category['status'] == 0 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="status0">Ẩn</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <a href="index.php?act=cate" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>