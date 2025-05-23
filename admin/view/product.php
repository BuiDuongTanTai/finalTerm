<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Quản lý sản phẩm</h2>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Danh sách sản phẩm</span>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        Thêm sản phẩm mới
                    </button>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form class="d-flex">
                                <input class="form-control me-2" type="search" placeholder="Tìm kiếm sản phẩm" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Tìm</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <select class="form-select w-50">
                                    <option selected>Lọc theo danh mục</option>
                                    <?php
                                    $DBH = connect();
                                    $stmt = $DBH->query("SELECT id, name FROM categories WHERE status = 1");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $DBH->query("SELECT p.*, c.name as category_name 
                                                    FROM products p 
                                                    LEFT JOIN categories c ON p.category_id = c.id 
                                                    ORDER BY p.id DESC");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>{$row['id']}</td>";
                                    echo "<td><img src='uploads/{$row['image']}' width='50' height='50' alt='{$row['name']}'></td>";
                                    echo "<td>{$row['name']}</td>";
                                    echo "<td>{$row['category_name']}</td>";
                                    echo "<td>" . number_format($row['price']) . " VND</td>";
                                    echo "<td>{$row['quantity']}</td>";
                                    echo "<td>" . ($row['status'] == 1 ? 'Hiện' : 'Ẩn') . "</td>";
                                    echo "<td>
                                            <button class='btn btn-sm btn-info view-btn' data-id='{$row['id']}'>Xem</button>
                                            <button class='btn btn-sm btn-warning edit-btn' data-id='{$row['id']}'>Sửa</button>
                                            <button class='btn btn-sm btn-danger delete-btn' data-id='{$row['id']}'>Xóa</button>
                                          </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Trước</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Sau</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal thêm sản phẩm -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" action="index.php?act=add_product" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productName" class="form-label">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="productName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="productCategory" class="form-label">Danh mục</label>
                                <select class="form-select" id="productCategory" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    <?php
                                    $stmt = $DBH->query("SELECT id, name FROM categories WHERE status = 1");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Giá</label>
                                <input type="number" class="form-control" id="productPrice" name="price" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label for="productQuantity" class="form-label">Số lượng</label>
                                <input type="number" class="form-control" id="productQuantity" name="quantity" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productImage" class="form-label">Hình ảnh</label>
                                <input type="file" class="form-control" id="productImage" name="image" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="productDescription" name="description" rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="productStatusActive" value="1" checked>
                                    <label class="form-check-label" for="productStatusActive">
                                        Hiện
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="productStatusInactive" value="0">
                                    <label class="form-check-label" for="productStatusInactive">
                                        Ẩn
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" form="addProductForm" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>