<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Quản lý đánh giá</h5>
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
                        <input type="hidden" name="act" value="comment">
                        <input type="text" name="search" class="form-control me-2" placeholder="Tìm theo tên sản phẩm hoặc người đánh giá" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button type="submit" class="btn btn-outline-primary">Tìm</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="" method="get" class="d-flex justify-content-end">
                        <input type="hidden" name="act" value="comment">
                        <?php if (isset($_GET['search'])): ?>
                        <input type="hidden" name="search" value="<?php echo $_GET['search']; ?>">
                        <?php endif; ?>
                        <select name="status" class="form-select w-auto me-2" onchange="this.form.submit()">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" <?php echo (isset($_GET['status']) && $_GET['status'] == 'pending') ? 'selected' : ''; ?>>Chờ duyệt</option>
                            <option value="approved" <?php echo (isset($_GET['status']) && $_GET['status'] == 'approved') ? 'selected' : ''; ?>>Đã duyệt</option>
                            <option value="rejected" <?php echo (isset($_GET['status']) && $_GET['status'] == 'rejected') ? 'selected' : ''; ?>>Từ chối</option>
                        </select>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sản phẩm</th>
                            <th>Người đánh giá</th>
                            <th>Đánh giá</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Ngày</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $DBH = connect();
                        
                        // Xây dựng câu truy vấn
                        $sql = "SELECT r.*, p.name as product_name 
                                FROM reviews r 
                                LEFT JOIN products p ON r.product_id = p.id 
                                WHERE 1=1";
                        $params = [];
                        
                        // Tìm kiếm
                        if (isset($_GET['search']) && !empty($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql .= " AND (p.name LIKE :search OR r.name LIKE :search OR r.comment LIKE :search)";
                            $params[':search'] = "%$search%";
                        }
                        
                        // Lọc theo trạng thái
                        if (isset($_GET['status']) && !empty($_GET['status'])) {
                            $status = $_GET['status'];
                            $sql .= " AND r.status = :status";
                            $params[':status'] = $status;
                        }
                        
                        $sql .= " ORDER BY r.created_at DESC";
                        
                        // Phân trang
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;
                        
                        // Đếm tổng số đánh giá
                        $count_sql = str_replace("r.*, p.name as product_name", "COUNT(*)", $sql);
                        $count_stmt = $DBH->prepare($count_sql);
                        foreach ($params as $key => $value) {
                            $count_stmt->bindValue($key, $value);
                        }
                        $count_stmt->execute();
                        $total_reviews = $count_stmt->fetchColumn();
                        $total_pages = ceil($total_reviews / $limit);
                        
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
                            $stars = str_repeat('⭐', $row['rating']);
                            $statusBadge = '';
                            switch($row['status']) {
                                case 'pending':
                                    $statusBadge = '<span class="badge bg-warning">Chờ duyệt</span>';
                                    break;
                                case 'approved':
                                    $statusBadge = '<span class="badge bg-success">Đã duyệt</span>';
                                    break;
                                case 'rejected':
                                    $statusBadge = '<span class="badge bg-danger">Từ chối</span>';
                                    break;
                            }
                            
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['product_name']}</td>";
                            echo "<td>{$row['name']}<br><small class='text-muted'>{$row['email']}</small></td>";
                            echo "<td>{$stars}</td>";
                            echo "<td>";
                            echo "<button type='button' class='btn btn-sm btn-link p-0' data-bs-toggle='modal' data-bs-target='#reviewModal{$row['id']}'>";
                            echo substr($row['comment'], 0, 50) . (strlen($row['comment']) > 50 ? '...' : '');
                            echo "</button>";
                            echo "</td>";
                            echo "<td>{$statusBadge}</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['created_at'])) . "</td>";
                            echo "<td>";
                            echo "<div class='btn-group'>";
                            
                            if ($row['status'] == 'pending') {
                                echo "<a href='index.php?act=update_review_status&id={$row['id']}&status=approved' class='btn btn-sm btn-success' title='Duyệt'><i class='bi bi-check-lg'></i></a>";
                                echo "<a href='index.php?act=update_review_status&id={$row['id']}&status=rejected' class='btn btn-sm btn-danger' title='Từ chối'><i class='bi bi-x-lg'></i></a>";
                            } else {
                                echo "<a href='javascript:void(0)' onclick='confirmDelete({$row['id']})' class='btn btn-sm btn-danger' title='Xóa'><i class='bi bi-trash'></i></a>";
                            }
                            
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                            
                            // Modal hiển thị đầy đủ nội dung đánh giá
                            echo "
                            <div class='modal fade' id='reviewModal{$row['id']}' tabindex='-1' aria-labelledby='reviewModalLabel{$row['id']}' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='reviewModalLabel{$row['id']}'>Đánh giá từ {$row['name']}</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <p><strong>Sản phẩm:</strong> {$row['product_name']}</p>
                                            <p><strong>Người đánh giá:</strong> {$row['name']} ({$row['email']})</p>
                                            <p><strong>Đánh giá:</strong> {$stars} ({$row['rating']} sao)</p>
                                            <p><strong>Tiêu đề:</strong> " . ($row['title'] ? $row['title'] : 'Không có tiêu đề') . "</p>
                                            <p><strong>Nội dung:</strong></p>
                                            <div class='p-3 bg-light'>{$row['comment']}</div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Đóng</button>";
                                            
                            if ($row['status'] == 'pending') {
                                echo "<a href='index.php?act=update_review_status&id={$row['id']}&status=approved' class='btn btn-success'>Duyệt</a>";
                                echo "<a href='index.php?act=update_review_status&id={$row['id']}&status=rejected' class='btn btn-danger'>Từ chối</a>";
                            }
                                            
                            echo "
                                        </div>
                                    </div>
                                </div>
                            </div>";
                        }
                        
                        if ($stmt->rowCount() == 0) {
                            echo "<tr><td colspan='8' class='text-center'>Không có đánh giá nào</td></tr>";
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
                        <a class="page-link" href="?act=comment<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['status']) ? '&status='.$_GET['status'] : ''; ?>&page=<?php echo $page-1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?act=comment<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['status']) ? '&status='.$_GET['status'] : ''; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?act=comment<?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?><?php echo isset($_GET['status']) ? '&status='.$_GET['status'] : ''; ?>&page=<?php echo $page+1; ?>" aria-label="Next">
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

<script>
// Xác nhận xóa đánh giá
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa đánh giá này?')) {
        window.location.href = `index.php?act=delete_review&id=${id}`;
    }
}
</script>