<?php
session_start();
include_once 'model/config.php';
include_once 'model/user.php';

$action = isset($_GET['act']) ? $_GET['act'] : 'home';

if (!isset($_SESSION['admin']) && $action != 'login') {
    $action = 'login';
}

include 'view/header.php';

switch ($action) {
    case "home":
        include 'view/home.php';
        break;

    case "login":
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_submit'])) {
            $email = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
            $pass = $_POST['password'];

            // Kiểm tra đăng nhập
            if (CheckLogin($email, $pass)) {
                $_SESSION['admin'] = $email;
                
                // Nếu người dùng chọn "Ghi nhớ đăng nhập"
                if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
                    setcookie('admin_username', $email, time() + (86400 * 30), "/"); // 30 ngày
                }
                
                header("Location: index.php");
                exit;
            } else {
                $login_error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
                include 'view/login.php';
            }
        } else {
            include 'view/login.php';
        }
        break;

    case "logout":
        unset($_SESSION['admin']);
        setcookie('admin_username', '', time() - 3600, "/"); // Xóa cookie
        header("Location: index.php");
        exit;

    case "cate":
        include 'view/catalog.php';
        break;

    case "add_category":
        // Xử lý thêm danh mục
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
            
            if (empty($name)) {
                header("Location: index.php?act=cate&error=Vui lòng nhập tên danh mục");
                exit;
            }
            
            $DBH = connect();
            $stmt = $DBH->prepare("INSERT INTO categories (name, description, status) VALUES (:name, :description, :status)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':status', $status);
            
            if ($stmt->execute()) {
                header("Location: index.php?act=cate&success=Thêm danh mục thành công");
                exit;
            } else {
                header("Location: index.php?act=cate&error=Lỗi khi thêm danh mục");
                exit;
            }
        }
        break;

    case "product":
        include 'view/product.php';
        break;

    case "add_product":
        // Xử lý thêm sản phẩm
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
            
            if (empty($name) || !$category_id || !$price) {
                header("Location: index.php?act=product&error=Vui lòng điền đầy đủ thông tin bắt buộc");
                exit;
            }
            
            // Xử lý upload ảnh
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "uploads/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $image = time() . '_' . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $image;
                
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                // Kiểm tra các định dạng file hợp lệ
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    header("Location: index.php?act=product&error=Chỉ chấp nhận file JPG, JPEG, PNG & GIF");
                    exit;
                }
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // File uploaded successfully
                } else {
                    header("Location: index.php?act=product&error=Lỗi khi tải lên hình ảnh");
                    exit;
                }
            }
            
            $DBH = connect();
            $stmt = $DBH->prepare("INSERT INTO products (name, category_id, price, quantity, description, image, status, created_at) 
                                  VALUES (:name, :category_id, :price, :quantity, :description, :image, :status, NOW())");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':status', $status);
            
            if ($stmt->execute()) {
                header("Location: index.php?act=product&success=Thêm sản phẩm thành công");
                exit;
            } else {
                header("Location: index.php?act=product&error=Lỗi khi thêm sản phẩm");
                exit;
            }
        }
        break;

    case "order":
        include 'view/order.php';
        break;

    case "user":
        include 'view/user_manage.php';
        break;

    case "comment":
        include 'view/comment.php';
        break;

    case "profile":
        include 'view/profile.php';
        break;

    case "add_user":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
            $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
            
            $DBH = connect();
            
            // Kiểm tra email đã tồn tại
            $check = $DBH->prepare("SELECT id FROM users WHERE email = :email");
            $check->bindParam(':email', $email);
            $check->execute();
            
            if ($check->rowCount() > 0) {
                header("Location: index.php?act=user&error=Email đã tồn tại");
                exit;
            }
            
            $stmt = $DBH->prepare("INSERT INTO users (name, email, password, phone, role, status) 
                                VALUES (:name, :email, :password, :phone, :role, :status)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':status', $status);
            
            if ($stmt->execute()) {
                header("Location: index.php?act=user&success=Thêm người dùng thành công");
            } else {
                header("Location: index.php?act=user&error=Lỗi khi thêm người dùng");
            }
            exit;
        }
        break;

    case "delete_user":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $DBH = connect();
            $stmt = $DBH->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                header("Location: index.php?act=user&success=Xóa người dùng thành công");
            } else {
                header("Location: index.php?act=user&error=Lỗi khi xóa người dùng");
            }
            exit;
        }
        break;

    case "update_review_status":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);

        if ($id && in_array($status, ['approved', 'rejected'])) {
            $DBH = connect();
            $stmt = $DBH->prepare("UPDATE reviews SET status = :status WHERE id = :id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                header("Location: index.php?act=comment&success=Cập nhật trạng thái thành công");
            } else {
                header("Location: index.php?act=comment&error=Lỗi khi cập nhật trạng thái");
            }
            exit;
        }
        break;

    default:
        include 'view/home.php';
        break;
}

include 'view/footer.php';
?>