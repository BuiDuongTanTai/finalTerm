<div class="container mt-4">
    <h2 class="mb-4">Quản lý đánh giá</h2>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
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
                        $stmt = $DBH->query("SELECT r.*, p.name as product_name 
                                            FROM reviews r 
                                            LEFT JOIN products p ON r.product_id = p.id 
                                            ORDER BY r.created_at DESC");
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
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$stars}</td>";
                            echo "<td>" . substr($row['comment'], 0, 50) . "...</td>";
                            echo "<td>{$statusBadge}</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['created_at'])) . "</td>";
                            echo "<td>
                                    <button class='btn btn-sm btn-success approve-review' data-id='{$row['id']}'>
                                        <i class='fas fa-check'></i>
                                    </button>
                                    <button class='btn btn-sm btn-danger reject-review' data-id='{$row['id']}'>
                                        <i class='fas fa-times'></i>
                                    </button>
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

<script>
// Duyệt đánh giá
document.querySelectorAll('.approve-review').forEach(button => {
    button.addEventListener('click', function() {
        const reviewId = this.getAttribute('data-id');
        window.location.href = `index.php?act=update_review_status&id=${reviewId}&status=approved`;
    });
});

// Từ chối đánh giá
document.querySelectorAll('.reject-review').forEach(button => {
    button.addEventListener('click', function() {
        const reviewId = this.getAttribute('data-id');
        window.location.href = `index.php?act=update_review_status&id=${reviewId}&status=rejected`;
    });
});
</script>