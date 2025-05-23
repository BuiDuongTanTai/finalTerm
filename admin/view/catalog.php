<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Quản lý danh mục sản phẩm</h2>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Danh sách danh mục</span>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        Thêm danh mục mới
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $DBH = connect();
                                $stmt = $DBH->query("SELECT * FROM categories ORDER BY id DESC");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>{$row['id']}</td>";
                                    echo "<td>{$row['name']}</td>";
                                    echo "<td>{$row['description']}</td>";
                                    echo "<td>" . ($row['status'] == 1 ? 'Hiện' : 'Ẩn') . "</td>";
                                    echo "<td>
                                            <button class='btn btn-sm btn-warning edit-btn' data-id='{$row['id']}'>Sửa</button>
                                            <button class='btn btn-sm btn-danger delete-btn' data-id='{$row['id']}'>Xóa</button>
                                          </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal thêm danh mục -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Thêm danh mục mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm" action="index.php?act=add_category" method="post">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="categoryDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="statusActive" value="1" checked>
                            <label class="form-check-label" for="statusActive">
                                Hiện
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="statusInactive" value="0">
                            <label class="form-check-label" for="statusInactive">
                                Ẩn
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" form="addCategoryForm" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>