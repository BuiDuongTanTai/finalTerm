<!-- Thay thế phần đếm số lượng trong home.php -->
<?php
$DBH = connect();
?>

<!-- Sản phẩm -->
<div class="col-md-3">
    <div class="card dashboard-card">
        <div class="card-body">
            <h5 class="card-title">Sản phẩm</h5>
            <p class="dashboard-number">
                <?php
                $stmt = $DBH->query("SELECT COUNT(*) FROM products");
                echo $stmt->fetchColumn();
                ?>
            </p>
            <a href="index.php?act=product" class="btn btn-primary btn-manage">Quản lý</a>
        </div>
    </div>
</div>

<!-- Đơn hàng -->
<div class="col-md-3">
    <div class="card dashboard-card">
        <div class="card-body">
            <h5 class="card-title">Đơn hàng</h5>
            <p class="dashboard-number">
                <?php
                $stmt = $DBH->query("SELECT COUNT(*) FROM orders");
                echo $stmt->fetchColumn();
                ?>
            </p>
            <a href="index.php?act=order" class="btn btn-primary btn-manage">Quản lý</a>
        </div>
    </div>
</div>

<!-- Khách hàng -->
<div class="col-md-3">
    <div class="card dashboard-card">
        <div class="card-body">
            <h5 class="card-title">Khách hàng</h5>
            <p class="dashboard-number">
                <?php
                $stmt = $DBH->query("SELECT COUNT(*) FROM users WHERE role = 'customer'");
                echo $stmt->fetchColumn();
                ?>
            </p>
            <a href="index.php?act=user" class="btn btn-primary btn-manage">Quản lý</a>
        </div>
    </div>
</div>

<!-- Đánh giá -->
<div class="col-md-3">
    <div class="card dashboard-card">
        <div class="card-body">
            <h5 class="card-title">Đánh giá</h5>
            <p class="dashboard-number">
                <?php
                $stmt = $DBH->query("SELECT COUNT(*) FROM reviews");
                echo $stmt->fetchColumn();
                ?>
            </p>
            <a href="index.php?act=review" class="btn btn-primary btn-manage">Quản lý</a>
        </div>
    </div>
</div>