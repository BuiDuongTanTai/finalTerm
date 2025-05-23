<div class="container">
    <div class="jumbotron bg-light p-4 mb-4">
        <h1 class="display-4">Trang quản trị CameraVN</h1>
        <p class="lead">Đây là trang quản trị của cửa hàng máy ảnh CameraVN. Quản lý danh mục sản phẩm, sản phẩm, đơn hàng, khách hàng và các chức năng khác.</p>
        <hr class="my-4">
        <p>Sử dụng menu phía trên hoặc các thẻ bên dưới để truy cập các chức năng quản trị.</p>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-header bg-primary text-white">Sản phẩm</div>
                <div class="card-body">
                    <div class="dashboard-number">
                        <?php
                        $DBH = connect();
                        $stmt = $DBH->query("SELECT COUNT(*) FROM products");
                        echo $stmt->fetchColumn();
                        ?>
                    </div>
                    <a href="index.php?act=product" class="btn btn-outline-primary btn-manage">Quản lý</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-header bg-success text-white">Đơn hàng</div>
                <div class="card-body">
                    <div class="dashboard-number">
                        <?php
                        $stmt = $DBH->query("SELECT COUNT(*) FROM orders");
                        echo $stmt->fetchColumn();
                        ?>
                    </div>
                    <a href="index.php?act=order" class="btn btn-outline-success btn-manage">Quản lý</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-header bg-info text-white">Khách hàng</div>
                <div class="card-body">
                    <div class="dashboard-number">
                        <?php
                        $stmt = $DBH->query("SELECT COUNT(*) FROM users");
                        echo $stmt->fetchColumn();
                        ?>
                    </div>
                    <a href="index.php?act=user" class="btn btn-outline-info btn-manage">Quản lý</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-header bg-warning text-dark">Bình luận</div>
                <div class="card-body">
                    <div class="dashboard-number">
                        <?php
                        $stmt = $DBH->query("SELECT COUNT(*) FROM comments");
                        echo $stmt->fetchColumn();
                        ?>
                    </div>
                    <a href="index.php?act=comment" class="btn btn-outline-warning btn-manage">Quản lý</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    Đơn hàng gần đây
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $DBH->query("SELECT o.id, u.fullname, o.order_date, o.status 
                                                FROM orders o 
                                                JOIN users u ON o.user_id = u.id 
                                                ORDER BY o.order_date DESC LIMIT 5");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['fullname']}</td>";
                                echo "<td>{$row['order_date']}</td>";
                                echo "<td>{$row['status']}</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    Sản phẩm mới nhất
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $DBH->query("SELECT id, name, price, status 
                                                FROM products 
                                                ORDER BY created_at DESC LIMIT 5");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>" . number_format($row['price']) . " VND</td>";
                                echo "<td>{$row['status']}</td>";
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