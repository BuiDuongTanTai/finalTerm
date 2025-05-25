<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Quản lý danh mục sản phẩm</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus"></i> Thêm danh mục mới
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
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
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
                        $stmt = $DBH->query("SELECT * FROM categories ORDER BY id ASC");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>" . (strlen($row['description']) > 100 ? substr($row['description'], 0, 100) . '...' : $row['description']) . "</td>";
                            echo "<td>" . ($row['status'] == 1 ? '<span class="badge bg-success">Hiện</span>' : '<span class="badge bg-secondary">Ẩn</span>') . "</td>";
                            echo "<td>";
                            echo "<div class='btn-group'>";
                            echo "<a href='index.php?act=edit_category&id={$row['id']}' class='btn btn-sm btn-primary'><i class='bi bi-pencil'></i></a>";
                            echo "<a href='javascript:void(0)' onclick='confirmDelete({$row['id']})' class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></a>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        
                        if ($stmt->rowCount() == 0) {
                            echo "<tr><td colspan='5' class='text-center'>Không có danh mục nào</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
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
                <form action="index.php?act=add_category" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status1" value="1" checked>
                                <label class="form-check-label" for="status1">Hiện</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status0" value="0">
                                <label class="form-check-label" for="status0">Ẩn</label>
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
// Xác nhận xóa danh mục
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
        window.location.href = `index.php?act=delete_category&id=${id}`;
    }
}
</script>