<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Quản lý sản phẩm</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus"></i> Thêm sản phẩm mới
            </button>
        </div>
        <div class="card-body">
            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_GET['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_GET['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="" method="get" class="d-flex">
                        <input type="hidden" name="act" value="product">
                        <input type="text" name="search" class="form-control me-2" placeholder="Tìm" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button type="submit" class="btn btn-outline-primary">Tìm</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="" method="get" class="d-flex justify-content-end">
                        <input type="hidden" name="act" value="product">
                        <?php if (isset($_GET['search'])): ?>
                        <input type="hidden" name="search" value="<?php echo $_GET['search']; ?>">
                        <?php endif; ?>
                        <select name="category" class="form-select w-auto me-2" onchange="this.form.submit()">
                            <option value="">Lọc theo danh mục</option>
                            <?php
                            $DBH = connect();
                            $stmt = $DBH->query("SELECT id, name FROM categories WHERE status = 1");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $selected = (isset($_GET['category']) && $_GET['category'] == $row['id']) ? 'selected' : '';
                                echo "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Badge</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $DBH = connect();
                        
                        // Xây dựng câu truy vấn
                        $sql = "SELECT p.*, c.name as category_name 
                                FROM products p 
                                LEFT JOIN categories c ON p.category_id = c.id 
                                WHERE 1=1";
                        $params = [];
                        
                        // Tìm kiếm
                        if (isset($_GET['search']) && !empty($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql .= " AND (p.name LIKE :search OR p.id LIKE :search)";
                            $params[':search'] = "%$search%";
                        }
                        
                        // Lọc theo danh mục
                        if (isset($_GET['category']) && !empty($_GET['category'])) {
                            $category = $_GET['category'];
                            $sql .= " AND p.category_id = :category";
                            $params[':category'] = $category;
                        }
                        
                        $sql .= " ORDER BY p.id ASC";
                        
                        // Phân trang
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;
                        
                        // Đếm tổng số sản phẩm
                        $count_sql = str_replace("p.*, c.name as category_name", "COUNT(*)", $sql);
                        $count_stmt = $DBH->prepare($count_sql);
                        foreach ($params as $key => $value) {
                            $count_stmt->bindValue($key, $value);
                        }
                        $count_stmt->execute();
                        $total_products = $count_stmt->fetchColumn();
                        $total_pages = ceil($total_products / $limit);
                        
                        $sql .= " LIMIT :offset, :limit";
                        $params[':offset'] = $offset;
                        $params[':limit'] = $limit;
                        
                        $stmt = $DBH->prepare($sql);
                        foreach ($params as $key => $value) {
                            if ($key == ':offset' || $key == ':limit') {
                                $stmt->bindValue($key, $value, PDO::PARAM_INT);
                            } else {
                                $stmt->bindValue($key, $value);
                            }
                        }
                        $stmt->execute();
                        
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>";
                            if (!empty($row['image_url'])) {
                                echo "<img src='{$row['image_url']}' alt='{$row['name']}' class='img-thumbnail' style='max-height: 50px;'>";
                            } else {
                                echo "<div class='bg-secondary text-white d-flex align-items-center justify-content-center' style='width: 50px; height: 50px;'>No img</div>";
                            }
                            echo "</td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$row['category_name']}</td>";
                            echo "<td>" . number_format($row['price']) . " VND</td>";
                            echo "<td>{$row['stock']}</td>";
                            echo "<td>";
                            if (!empty($row['badges'])) {
                                $badges = json_decode($row['badges'], true);
                                if (is_array($badges)) {
                                    foreach ($badges as $badge) {
                                        switch ($badge) {
                                            case 'hot':
                                                echo '<span class="badge bg-danger me-1">HOT</span>';
                                                break;
                                            case 'new':
                                                echo '<span class="badge bg-info me-1">NEW</span>';
                                                break;
                                            case 'bestseller':
                                                echo '<span class="badge bg-success me-1">BESTSELLER</span>';
                                                break;
                                            case 'discount':
                                                // Tính phần trăm giảm giá
                                                if (!empty($row['old_price']) && $row['old_price'] > $row['price']) {
                                                    $discount = round(100 - ($row['price'] / $row['old_price'] * 100));
                                                    echo '<span class="badge bg-warning me-1">-' . $discount . '%</span>';
                                                } else {
                                                    echo '<span class="badge bg-warning me-1">DISCOUNT</span>';
                                                }
                                                break;
                                        }
                                    }
                                }
                            } else {
                                echo '<span class="badge bg-secondary">Bình thường</span>';
                            }
                            echo "</td>";
                            echo "<td>" . ($row['status'] == 1 ? '<span class="badge bg-success">Hiện</span>' : '<span class="badge bg-secondary">Ẩn</span>') . "</td>";
                            echo "<td>";
                            echo "<div class='btn-group'>";
                            echo "<a href='index.php?act=edit_product&id={$row['id']}' class='btn btn-sm btn-primary'><i class='bi bi-pencil'></i></a>";
                            echo "<a href='javascript:void(0)' onclick='confirmDelete({$row['id']})' class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></a>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        
                        if ($stmt->rowCount() == 0) {
                            echo "<tr><td colspan='8' class='text-center'>Không có sản phẩm nào</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?act=product<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['category']) ? '&category='.$_GET['category'] : ''; ?>&page=<?php echo $page-1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?act=product<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['category']) ? '&category='.$_GET['category'] : ''; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?act=product<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['category']) ? '&category='.$_GET['category'] : ''; ?>&page=<?php echo $page+1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>
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
                <form action="index.php?act=add_product" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Danh mục</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    <?php
                                    $DBH = connect();
                                    $stmt = $DBH->query("SELECT id, name FROM categories WHERE status = 1");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Giá</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="price" name="price" required>
                                            <span class="input-group-text">VND</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Số lượng</label>
                                        <input type="number" class="form-control" id="stock" name="stock" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="image" class="form-label">Hình ảnh</label>
                                <input type="file" class="form-control" id="image" name="image">
                                <div class="mt-2">
                                    <img id="image-preview" src="#" alt="Preview" style="max-width: 100%; max-height: 200px; display: none;">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Badge</label>
                                <div class="badge-checkboxes">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="badges[]" value="hot" id="badge_hot">
                                        <label class="form-check-label" for="badge_hot">
                                            <span class="badge bg-danger">HOT</span> - Sản phẩm nổi bật
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="badges[]" value="new" id="badge_new">
                                        <label class="form-check-label" for="badge_new">
                                            <span class="badge bg-info">NEW</span> - Sản phẩm mới
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="badges[]" value="bestseller" id="badge_bestseller">
                                        <label class="form-check-label" for="badge_bestseller">
                                            <span class="badge bg-success">BESTSELLER</span> - Bán chạy
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="badges[]" value="discount" id="badge_discount">
                                        <label class="form-check-label" for="badge_discount">
                                            <span class="badge bg-warning">DISCOUNT</span> - Giảm giá
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Có thể chọn nhiều badge cho một sản phẩm</small>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Hiển thị xem trước hình ảnh
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    const file = e.target.files[0];
    
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
});

// Xác nhận xóa sản phẩm
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        window.location.href = `index.php?act=delete_product&id=${id}`;
    }
}
</script>