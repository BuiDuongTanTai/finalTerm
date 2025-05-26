<?php
session_start();
include_once 'model/config.php';
include_once 'model/user.php';

$action = isset($_GET['act']) ? $_GET['act'] : 'home';

// Kiểm tra đăng nhập
if (!isset($_SESSION['admin']) && $action != 'login') {
    $action = 'login';
}

// XỬ LÝ LOGIC TRƯỚC KHI CÓ OUTPUT

switch ($action) {
    // ========== XỬ LÝ ĐĂNG NHẬP/ĐĂNG XUẤT ==========
    case "login":
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_submit'])) {
            $email = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
            $pass = $_POST['password'];

            if (CheckLogin($email, $pass)) {
                $DBH = connect();
                $stmt = $DBH->prepare("SELECT id, name, email, role, avatar FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $_SESSION['admin'] = $user;
                
                if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
                    setcookie('admin_username', $email, time() + (86400 * 30), "/");
                }
                
                header("Location: index.php");
                exit;
            } else {
                $login_error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
            }
        }
        break;

    case "logout":
        unset($_SESSION['admin']);
        setcookie('admin_username', '', time() - 3600, "/");
        header("Location: index.php");
        exit;

    // ========== QUẢN LÝ DANH MỤC ==========
    case "add_category":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
            // Xử lý badges
            $badges = isset($_POST['badges']) ? $_POST['badges'] : [];
            $badges_json = !empty($badges) ? json_encode($badges) : null;
            // Xử lý section flags
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $is_new = isset($_POST['is_new']) ? 1 : 0;
            $is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;
            $is_discount = isset($_POST['is_discount']) ? 1 : 0;
            $is_promotion = isset($_POST['is_promotion']) ? 1 : 0;
            $promotion_url = isset($_POST['promotion_url']) ? trim($_POST['promotion_url']) : null;

            // Nếu là promotion nhưng không có custom URL, dùng link mặc định
            if ($is_promotion && empty($promotion_url)) {
                $promotion_url = null; // Sẽ được set sau khi có product ID
            }
            
            if (empty($name)) {
                header("Location: index.php?act=cate&error=" . urlencode("Vui lòng nhập tên danh mục"));
                exit;
            }
            
            $slug = createSlug($name);
            
            $DBH = connect();
            
            // Kiểm tra slug trùng lặp
            $checkSlug = $DBH->prepare("SELECT id FROM categories WHERE slug = :slug");
            $checkSlug->bindParam(':slug', $slug);
            $checkSlug->execute();
            
            if ($checkSlug->rowCount() > 0) {
                $slug = $slug . '-' . time();
            }
            
            $stmt = $DBH->prepare("INSERT INTO categories (name, slug, description, status) VALUES (:name, :slug, :description, :status)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':status', $status);
            
            if ($stmt->execute()) {
                header("Location: index.php?act=cate&success=" . urlencode("Thêm danh mục thành công"));
            } else {
                header("Location: index.php?act=cate&error=" . urlencode("Lỗi khi thêm danh mục"));
            }
            exit;
        }
        header("Location: index.php?act=cate");
        exit;

    case "update_category":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
            
            if (empty($name) || !$id) {
                header("Location: index.php?act=cate&error=" . urlencode("Dữ liệu không hợp lệ"));
                exit;
            }
            
            $slug = createSlug($name);
            
            $DBH = connect();
            
            // Kiểm tra slug trùng lặp (ngoại trừ chính nó)
            $checkSlug = $DBH->prepare("SELECT id FROM categories WHERE slug = :slug AND id != :id");
            $checkSlug->bindParam(':slug', $slug);
            $checkSlug->bindParam(':id', $id);
            $checkSlug->execute();
            
            if ($checkSlug->rowCount() > 0) {
                $slug = $slug . '-' . time();
            }
            
            $stmt = $DBH->prepare("UPDATE categories SET name = :name, slug = :slug, description = :description, status = :status WHERE id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                header("Location: index.php?act=cate&success=" . urlencode("Cập nhật danh mục thành công"));
            } else {
                header("Location: index.php?act=cate&error=" . urlencode("Lỗi khi cập nhật danh mục"));
            }
            exit;
        }
        header("Location: index.php?act=cate");
        exit;

    case "delete_category":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $DBH = connect();
            
            $check = $DBH->prepare("SELECT COUNT(*) FROM products WHERE category_id = :id");
            $check->bindParam(':id', $id);
            $check->execute();
            
            if ($check->fetchColumn() > 0) {
                header("Location: index.php?act=cate&error=" . urlencode("Không thể xóa danh mục đang có sản phẩm"));
                exit;
            }
            
            $stmt = $DBH->prepare("DELETE FROM categories WHERE id = :id");
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                header("Location: index.php?act=cate&success=" . urlencode("Xóa danh mục thành công"));
            } else {
                header("Location: index.php?act=cate&error=" . urlencode("Lỗi khi xóa danh mục"));
            }
        }
        header("Location: index.php?act=cate");
        exit;

    // ========== QUẢN LÝ SẢN PHẨM ==========
    case "add_product":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $old_price = filter_input(INPUT_POST, 'old_price', FILTER_VALIDATE_FLOAT) ?: 0;
            $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $status = isset($_POST['status']) ? 1 : 0;
            
            // Xử lý section flags
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $is_new = isset($_POST['is_new']) ? 1 : 0;
            $is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;
            $is_discount = isset($_POST['is_discount']) ? 1 : 0;
            $is_promotion = isset($_POST['is_promotion']) ? 1 : 0;
            $promotion_url = isset($_POST['promotion_url']) ? trim($_POST['promotion_url']) : null;

            // Xử lý badges với thứ tự ưu tiên
            $badges = [];
            
            // Thêm badge dựa trên section
            if ($is_featured) $badges[] = 'hot';
            if ($is_new) $badges[] = 'new';
            if ($is_bestseller) $badges[] = 'bestseller';
            if ($is_discount) $badges[] = 'discount';
            
            // Thêm các badge khác nếu có
            if (isset($_POST['badges']) && is_array($_POST['badges'])) {
                foreach ($_POST['badges'] as $badge) {
                    if (!in_array($badge, $badges)) {
                        $badges[] = $badge;
                    }
                }
            }
            
            // Sắp xếp badge theo thứ tự ưu tiên
            $priority = ['hot', 'new', 'bestseller', 'discount'];
            usort($badges, function($a, $b) use ($priority) {
                $pos_a = array_search($a, $priority);
                $pos_b = array_search($b, $priority);
                return $pos_a - $pos_b;
            });
            
            $badges_json = !empty($badges) ? json_encode($badges) : null;
            
            if ($is_promotion && empty($promotion_url)) {
                $promotion_url = null; // Sẽ được set sau khi có product ID
            }
            
            if (empty($name) || !$category_id || !$price) {
                header("Location: index.php?act=product&error=" . urlencode("Vui lòng điền đầy đủ thông tin bắt buộc"));
                exit;
            }
            
            $slug = createSlug($name);
            
            $DBH = connect();
            
            // Kiểm tra slug trùng lặp
            $checkSlug = $DBH->prepare("SELECT id FROM products WHERE slug = :slug");
            $checkSlug->bindParam(':slug', $slug);
            $checkSlug->execute();
            
            if ($checkSlug->rowCount() > 0) {
                $slug = $slug . '-' . time();
            }
            
            // Lấy brand_id từ category
            $brand_stmt = $DBH->prepare("SELECT brand_id FROM products WHERE category_id = :category_id LIMIT 1");
            $brand_stmt->bindParam(':category_id', $category_id);
            $brand_stmt->execute();
            $brand_result = $brand_stmt->fetch(PDO::FETCH_ASSOC);
            $brand_id = $brand_result ? $brand_result['brand_id'] : 1;
            
            // Xử lý upload ảnh
            $image_url = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "../View/assets/images/products/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $image_url = uniqid() . '_' . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $image_url;
                
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    header("Location: index.php?act=product&error=" . urlencode("Chỉ chấp nhận file JPG, JPEG, PNG & GIF"));
                    exit;
                }
                
                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    header("Location: index.php?act=product&error=" . urlencode("Lỗi khi tải lên hình ảnh"));
                    exit;
                }
                
                // Lưu đường dẫn bắt đầu từ View/
                $image_url = "View/assets/images/products/" . $image_url;
            }
            
            $stmt = $DBH->prepare("INSERT INTO products (name, slug, short_description, description, price, old_price, stock, image_url, category_id, brand_id, badges, is_featured, is_new, is_bestseller, is_discount, is_promotion, promotion_url, status) 
                VALUES (:name, :slug, :short_description, :description, :price, :old_price, :stock, :image_url, :category_id, :brand_id, :badges, :is_featured, :is_new, :is_bestseller, :is_discount, :is_promotion, :promotion_url, :status)");
            
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':short_description', $description);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':old_price', $old_price);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':brand_id', $brand_id);
            $stmt->bindParam(':badges', $badges_json);
            $stmt->bindParam(':is_featured', $is_featured);
            $stmt->bindParam(':is_new', $is_new);
            $stmt->bindParam(':is_bestseller', $is_bestseller);
            $stmt->bindParam(':is_discount', $is_discount);
            $stmt->bindParam(':is_promotion', $is_promotion);
            $stmt->bindParam(':promotion_url', $promotion_url);
            $stmt->bindParam(':status', $status);
            
            if ($stmt->execute()) {
                $product_id = $DBH->lastInsertId();
                
                // Nếu là promotion mà chưa có URL, set URL mặc định
                if ($is_promotion && empty($promotion_url)) {
                    $default_url = "index.php?page=product_detail&id=" . $product_id;
                    $update_stmt = $DBH->prepare("UPDATE products SET promotion_url = :promotion_url WHERE id = :id");
                    $update_stmt->bindParam(':promotion_url', $default_url);
                    $update_stmt->bindParam(':id', $product_id);
                    $update_stmt->execute();
                }
                
                header("Location: index.php?act=product&success=" . urlencode("Thêm sản phẩm thành công"));
            } else {
                header("Location: index.php?act=product&error=" . urlencode("Lỗi khi thêm sản phẩm"));
            }
            exit;
        }
        header("Location: index.php?act=product");
        exit;
    
    case "update_product":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $old_price = filter_input(INPUT_POST, 'old_price', FILTER_VALIDATE_FLOAT) ?: 0;
            $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $status = isset($_POST['status']) ? 1 : 0;
            
            // Xử lý section flags
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $is_new = isset($_POST['is_new']) ? 1 : 0;
            $is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;
            $is_discount = isset($_POST['is_discount']) ? 1 : 0;
            $is_promotion = isset($_POST['is_promotion']) ? 1 : 0;
            $promotion_url = isset($_POST['promotion_url']) ? trim($_POST['promotion_url']) : null;

            // Xử lý badges với thứ tự ưu tiên
            $badges = [];
            
            // Thêm badge dựa trên section
            if ($is_featured) $badges[] = 'hot';
            if ($is_new) $badges[] = 'new';
            if ($is_bestseller) $badges[] = 'bestseller';
            if ($is_discount) $badges[] = 'discount';
            
            // Thêm các badge khác nếu có
            if (isset($_POST['badges']) && is_array($_POST['badges'])) {
                foreach ($_POST['badges'] as $badge) {
                    if (!in_array($badge, $badges)) {
                        $badges[] = $badge;
                    }
                }
            }
            
            // Sắp xếp badge theo thứ tự ưu tiên
            $priority = ['hot', 'new', 'bestseller', 'discount'];
            usort($badges, function($a, $b) use ($priority) {
                $pos_a = array_search($a, $priority);
                $pos_b = array_search($b, $priority);
                return $pos_a - $pos_b;
            });
            
            $badges_json = !empty($badges) ? json_encode($badges) : null;
            
            // Nếu là promotion nhưng không có custom URL, dùng link mặc định
            if ($is_promotion && empty($promotion_url)) {
                $promotion_url = "index.php?page=product_detail&id=" . $id;
            }
        
            if (empty($name) || !$category_id || !$price || !$id) {
                header("Location: index.php?act=product&error=" . urlencode("Dữ liệu không hợp lệ"));
                exit;
            }
            
            $slug = createSlug($name);
            
            $DBH = connect();
            
            // Kiểm tra slug trùng lặp (ngoại trừ chính nó)
            $checkSlug = $DBH->prepare("SELECT id FROM products WHERE slug = :slug AND id != :id");
            $checkSlug->bindParam(':slug', $slug);
            $checkSlug->bindParam(':id', $id);
            $checkSlug->execute();
            
            if ($checkSlug->rowCount() > 0) {
                $slug = $slug . '-' . time();
            }
            
            // Xử lý upload ảnh mới nếu có
            $image_sql = "";
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "../View/assets/images/products/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $image_url = uniqid() . '_' . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $image_url;
                
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    header("Location: index.php?act=product&error=" . urlencode("Chỉ chấp nhận file JPG, JPEG, PNG & GIF"));
                    exit;
                }
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // Xóa ảnh cũ
                    $old_image_stmt = $DBH->prepare("SELECT image_url FROM products WHERE id = :id");
                    $old_image_stmt->bindParam(':id', $id);
                    $old_image_stmt->execute();
                    $old_image = $old_image_stmt->fetchColumn();
                    
                    if ($old_image && file_exists($target_dir . $old_image)) {
                        unlink($target_dir . $old_image);
                    }
                    
                    // Lưu đường dẫn bắt đầu từ View/
                    $image_url = "View/assets/images/products/" . $image_url;
                    
                    $image_sql = ", image_url = :image_url";
                } else {
                    header("Location: index.php?act=product&error=" . urlencode("Lỗi khi tải lên hình ảnh"));
                    exit;
                }
            }
            
            $sql = "UPDATE products SET name = :name, slug = :slug, short_description = :short_description, description = :description, 
                price = :price, old_price = :old_price, stock = :stock, category_id = :category_id, badges = :badges, 
                is_featured = :is_featured, is_new = :is_new, is_bestseller = :is_bestseller, is_discount = :is_discount, 
                is_promotion = :is_promotion, promotion_url = :promotion_url, status = :status" . $image_sql . " WHERE id = :id";
            
            $stmt = $DBH->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':short_description', $description);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':old_price', $old_price);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':badges', $badges_json);
            $stmt->bindParam(':is_featured', $is_featured);
            $stmt->bindParam(':is_new', $is_new);
            $stmt->bindParam(':is_bestseller', $is_bestseller);
            $stmt->bindParam(':is_discount', $is_discount);
            $stmt->bindParam(':is_promotion', $is_promotion);
            $stmt->bindParam(':promotion_url', $promotion_url);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            
            if (!empty($image_sql)) {
                $stmt->bindParam(':image_url', $image_url);
            }
            
            if ($stmt->execute()) {
                header("Location: index.php?act=product&success=" . urlencode("Cập nhật sản phẩm thành công"));
            } else {
                header("Location: index.php?act=product&error=" . urlencode("Lỗi khi cập nhật sản phẩm"));
            }
            exit;
        }
        header("Location: index.php?act=product");
        exit;

    case "delete_product":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $DBH = connect();
            
            // Xóa ảnh sản phẩm
            $image_stmt = $DBH->prepare("SELECT image_url FROM products WHERE id = :id");
            $image_stmt->bindParam(':id', $id);
            $image_stmt->execute();
            $image = $image_stmt->fetchColumn();
            
            if ($image && file_exists("../View/assets/images/products/" . $image)) {
                unlink("../View/assets/images/products/" . $image);
            }
            
            $stmt = $DBH->prepare("DELETE FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                header("Location: index.php?act=product&success=" . urlencode("Xóa sản phẩm thành công"));
            } else {
                header("Location: index.php?act=product&error=" . urlencode("Lỗi khi xóa sản phẩm"));
            }
        }
        header("Location: index.php?act=product");
        exit;

    // ========== QUẢN LÝ ĐƠN HÀNG ==========
    case "update_order":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
            $tracking_number = filter_input(INPUT_POST, 'tracking_number', FILTER_SANITIZE_STRING);
            
            if (!$id || !in_array($status, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])) {
                header("Location: index.php?act=order&error=" . urlencode("Dữ liệu không hợp lệ"));
                exit;
            }
            
            $DBH = connect();
            $stmt = $DBH->prepare("UPDATE orders SET status = :status, tracking_number = :tracking_number WHERE id = :id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':tracking_number', $tracking_number);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                header("Location: index.php?act=order&success=" . urlencode("Cập nhật đơn hàng thành công"));
            } else {
                header("Location: index.php?act=order&error=" . urlencode("Lỗi khi cập nhật đơn hàng"));
            }
            exit;
        }
        header("Location: index.php?act=order");
        exit;

    // ========== QUẢN LÝ NGƯỜI DÙNG ==========
    case "add_user":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
            $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
            
            if (empty($name) || empty($email) || empty($_POST['password'])) {
                header("Location: index.php?act=user&error=" . urlencode("Vui lòng điền đầy đủ thông tin bắt buộc"));
                exit;
            }
            
            $DBH = connect();
            
            // Kiểm tra email đã tồn tại
            $check = $DBH->prepare("SELECT id FROM users WHERE email = :email");
            $check->bindParam(':email', $email);
            $check->execute();
            
            if ($check->rowCount() > 0) {
                header("Location: index.php?act=user&error=" . urlencode("Email đã tồn tại"));
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
                header("Location: index.php?act=user&success=" . urlencode("Thêm người dùng thành công"));
            } else {
                header("Location: index.php?act=user&error=" . urlencode("Lỗi khi thêm người dùng"));
            }
            exit;
        }
        header("Location: index.php?act=user");
        exit;

    case "update_user":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
            $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
            
            if (empty($name) || !$id) {
                header("Location: index.php?act=user&error=" . urlencode("Dữ liệu không hợp lệ"));
                exit;
            }
            
            $DBH = connect();
            
            // Cập nhật mật khẩu nếu có nhập mới
            $password_sql = "";
            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $password_sql = ", password = :password";
            }
            
            $sql = "UPDATE users SET name = :name, phone = :phone, role = :role, status = :status" . $password_sql . " WHERE id = :id";
            $stmt = $DBH->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            
            if (!empty($password_sql)) {
                $stmt->bindParam(':password', $password);
            }
            
            if ($stmt->execute()) {
                header("Location: index.php?act=user&success=" . urlencode("Cập nhật người dùng thành công"));
            } else {
                header("Location: index.php?act=user&error=" . urlencode("Lỗi khi cập nhật người dùng"));
            }
            exit;
        }
        header("Location: index.php?act=user");
        exit;

    case "delete_user":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            // Không cho phép xóa chính mình
            if (isset($_SESSION['admin']['id']) && $id == $_SESSION['admin']['id']) {
                header("Location: index.php?act=user&error=" . urlencode("Không thể xóa tài khoản đang đăng nhập"));
                exit;
            }
            
            $DBH = connect();
            $stmt = $DBH->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                header("Location: index.php?act=user&success=" . urlencode("Xóa người dùng thành công"));
            } else {
                header("Location: index.php?act=user&error=" . urlencode("Lỗi khi xóa người dùng"));
            }
        }
        header("Location: index.php?act=user");
        exit;

    // ========== QUẢN LÝ ĐÁNH GIÁ ==========
    case "update_review_status":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);

        if ($id && in_array($status, ['approved', 'rejected'])) {
            $DBH = connect();
            $stmt = $DBH->prepare("UPDATE reviews SET status = :status WHERE id = :id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                // Cập nhật số lượng đánh giá và rating trung bình cho sản phẩm
                if ($status == 'approved') {
                    $product_stmt = $DBH->prepare("SELECT product_id, rating FROM reviews WHERE id = :id");
                    $product_stmt->bindParam(':id', $id);
                    $product_stmt->execute();
                    $review = $product_stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($review) {
                        updateProductRating($review['product_id']);
                    }
                }
                
                header("Location: index.php?act=comment&success=" . urlencode("Cập nhật trạng thái thành công"));
            } else {
                header("Location: index.php?act=comment&error=" . urlencode("Lỗi khi cập nhật trạng thái"));
            }
        } else {
            header("Location: index.php?act=comment&error=" . urlencode("Dữ liệu không hợp lệ"));
        }
        exit;

    case "delete_review":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $DBH = connect();
            
            // Lấy product_id trước khi xóa để cập nhật rating
            $product_stmt = $DBH->prepare("SELECT product_id FROM reviews WHERE id = :id");
            $product_stmt->bindParam(':id', $id);
            $product_stmt->execute();
            $product_id = $product_stmt->fetchColumn();
            
            $stmt = $DBH->prepare("DELETE FROM reviews WHERE id = :id");
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                // Cập nhật rating cho sản phẩm
                if ($product_id) {
                    updateProductRating($product_id);
                }
                
                header("Location: index.php?act=comment&success=" . urlencode("Xóa đánh giá thành công"));
            } else {
                header("Location: index.php?act=comment&error=" . urlencode("Lỗi khi xóa đánh giá"));
            }
        }
        header("Location: index.php?act=comment");
        exit;

    // ========== QUẢN LÝ THÔNG TIN CÁ NHÂN ==========
    case "update_profile":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['admin']['id'];
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
            
            if (empty($name)) {
                header("Location: index.php?act=profile&error=" . urlencode("Vui lòng nhập họ tên"));
                exit;
            }
            
            $DBH = connect();
            
            // Xử lý upload avatar nếu có
            $avatar_sql = "";
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                $target_dir = "../View/assets/images/uploads/users/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $avatar = uniqid() . '_' . basename($_FILES["avatar"]["name"]);
                $target_file = $target_dir . $avatar;
                
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    header("Location: index.php?act=profile&error=" . urlencode("Chỉ chấp nhận file JPG, JPEG, PNG & GIF"));
                    exit;
                }
                
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                    // Xóa avatar cũ
                    $old_avatar_stmt = $DBH->prepare("SELECT avatar FROM users WHERE id = :id");
                    $old_avatar_stmt->bindParam(':id', $id);
                    $old_avatar_stmt->execute();
                    $old_avatar = $old_avatar_stmt->fetchColumn();
                    
                    if ($old_avatar && file_exists($old_avatar)) {
                        unlink($old_avatar);
                    }
                    
                    $avatar_sql = ", avatar = :avatar";
                } else {
                    header("Location: index.php?act=profile&error=" . urlencode("Lỗi khi tải lên avatar"));
                    exit;
                }
            }
            
            // Cập nhật mật khẩu nếu có nhập mới
            $password_sql = "";
            if (!empty($_POST['new_password']) && !empty($_POST['current_password'])) {
                // Kiểm tra mật khẩu hiện tại
                $check_pass = $DBH->prepare("SELECT password FROM users WHERE id = :id");
                $check_pass->bindParam(':id', $id);
                $check_pass->execute();
                $current_hashed_password = $check_pass->fetchColumn();
                
                if (password_verify($_POST['current_password'], $current_hashed_password)) {
                    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    $password_sql = ", password = :password";
                } else {
                    header("Location: index.php?act=profile&error=" . urlencode("Mật khẩu hiện tại không đúng"));
                    exit;
                }
            }
            
            $sql = "UPDATE users SET name = :name, phone = :phone" . $avatar_sql . $password_sql . " WHERE id = :id";
            $stmt = $DBH->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':id', $id);
            
            if (!empty($avatar_sql)) {
                $stmt->bindParam(':avatar', $target_file);
            }
            
            if (!empty($password_sql)) {
                $stmt->bindParam(':password', $new_password);
            }
            
            if ($stmt->execute()) {
                // Cập nhật thông tin trong session
                $_SESSION['admin']['name'] = $name;
                
                header("Location: index.php?act=profile&success=" . urlencode("Cập nhật thông tin thành công"));
            } else {
                header("Location: index.php?act=profile&error=" . urlencode("Lỗi khi cập nhật thông tin"));
            }
            exit;
        }
        header("Location: index.php?act=profile");
        exit;

    // ========== QUẢN LÝ BLOG ==========
    case "add_blog":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'model/blog.php';
            $blogModel = new Blog();
            
            $data = [
                'title' => $_POST['title'],
                'summary' => $_POST['summary'],
                'content' => $_POST['content'],
                'category_id' => $_POST['category_id'],
                'author_id' => $_SESSION['admin']['id'] ?? 1,
                'author_name' => $_SESSION['admin']['name'] ?? 'Admin',
                'status' => $_POST['status'],
                'published_at' => $_POST['status'] == 'published' ? date('Y-m-d H:i:s') : null,
                'featured' => isset($_POST['featured']) ? 1 : 0,
                'image' => ''
            ];
            
            // Xử lý upload ảnh
            if (!empty($_FILES['image']['name'])) {
                $uploadDir = '../uploads/blog/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $data['image'] = 'uploads/blog/' . $fileName;
                }
            }
            
            $blogId = $blogModel->createBlog($data);
            
            if ($blogId && !empty($_POST['tags'])) {
                $blogModel->addTagsToBlog($blogId, $_POST['tags']);
            }
            
            header('Location: index.php?act=blog_manage&success=' . urlencode('Thêm bài viết thành công'));
            exit;
        }
        
        require_once 'model/blog.php';
        $blogModel = new Blog();
        
        $categories = $blogModel->getAllCategories();
        $tags = $blogModel->getAllTags();
        
        include 'view/add_blog.php';
        break;

    case "update_blog":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'model/blog.php';
            $blogModel = new Blog();
            
            $id = $_POST['id'] ?? 0;
            $data = [
                'title' => $_POST['title'],
                'summary' => $_POST['summary'],
                'content' => $_POST['content'],
                'category_id' => $_POST['category_id'],
                'status' => $_POST['status'],
                'featured' => isset($_POST['featured']) ? 1 : 0
            ];
            
            // Xử lý upload ảnh mới
            if (!empty($_FILES['image']['name'])) {
                $uploadDir = '../uploads/blog/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $data['image'] = 'uploads/blog/' . $fileName;
                    
                    // Xóa ảnh cũ nếu có
                    $blog = $blogModel->getBlogById($id);
                    if ($blog && $blog['image'] && file_exists('../' . $blog['image'])) {
                        unlink('../' . $blog['image']);
                    }
                }
            }
            
            if ($blogModel->updateBlog($id, $data)) {
                // Cập nhật tags
                $tags = $_POST['tags'] ?? [];
                $blogModel->addTagsToBlog($id, $tags);
                
                header('Location: index.php?act=blog_manage&success=' . urlencode('Cập nhật bài viết thành công'));
                exit;
            }
        }
        break;

    case "delete_blog":
        $id = $_GET['id'] ?? 0;
        
        if ($id) {
            require_once 'model/blog.php';
            $blogModel = new Blog();
            $blogModel->deleteBlog($id);
        }
        
        header('Location: index.php?act=blog_manage');
        exit;
}


// HIỂN THỊ VIEW SAU KHI XỬ LÝ LOGIC


// Không load header/footer cho trang login
if ($action != 'login') {
    include 'view/header.php';
}

switch ($action) {
    case "home":
        include 'view/home.php';
        break;

    case "login":
        include 'view/login.php';
        break;

    // Quản lý danh mục
    case "cate":
        include 'view/catalog.php';
        break;

    case "edit_category":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $DBH = connect();
            $stmt = $DBH->prepare("SELECT * FROM categories WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($category) {
                include 'view/edit_category.php';
            } else {
                header("Location: index.php?act=cate&error=" . urlencode("Danh mục không tồn tại"));
                exit;
            }
        } else {
            header("Location: index.php?act=cate");
            exit;
        }
        break;

    // Quản lý sản phẩm
    case "product":
        include 'view/product.php';
        break;

    case "edit_product":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $DBH = connect();
            $stmt = $DBH->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                include 'view/edit_product.php';
            } else {
                header("Location: index.php?act=product&error=" . urlencode("Sản phẩm không tồn tại"));
                exit;
            }
        } else {
            header("Location: index.php?act=product");
            exit;
        }
        break;

    // Quản lý đơn hàng
    case "order":
        include 'view/order.php';
        break;

    case "order_detail":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $DBH = connect();
            
            // Lấy thông tin đơn hàng
            $order_stmt = $DBH->prepare("SELECT * FROM orders WHERE id = :id");
            $order_stmt->bindParam(':id', $id);
            $order_stmt->execute();
            $order = $order_stmt->fetch(PDO::FETCH_ASSOC);
            
            // Lấy các sản phẩm trong đơn hàng
            $items_stmt = $DBH->prepare("SELECT oi.*, p.image_url FROM order_items oi 
                                        LEFT JOIN products p ON oi.product_id = p.id 
                                        WHERE oi.order_id = :order_id");
            $items_stmt->bindParam(':order_id', $id);
            $items_stmt->execute();
            $order_items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if ($order) {
                include 'view/order_detail.php';
            } else {
                header("Location: index.php?act=order&error=" . urlencode("Đơn hàng không tồn tại"));
                exit;
            }
        } else {
            header("Location: index.php?act=order");
            exit;
        }
        break;

    // Quản lý người dùng
    case "user":
        include 'view/user_manage.php';
        break;

    case "edit_user":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $DBH = connect();
            $stmt = $DBH->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                include 'view/edit_user.php';
            } else {
                header("Location: index.php?act=user&error=" . urlencode("Người dùng không tồn tại"));
                exit;
            }
        } else {
            header("Location: index.php?act=user");
            exit;
        }
        break;

    // Quản lý đánh giá
    case "comment":
        include 'view/comment.php';
        break;

    // Quản lý thông tin cá nhân
    case "profile":
        include 'view/profile.php';
        break;

    // Quản lý blog
    case "blog_manage":
        require_once 'model/blog.php';
        $blogModel = new Blog();
        
        // Lấy tham số filter
        $search = $_GET['search'] ?? null;
        $category = $_GET['category'] ?? null;
        $status = $_GET['status'] ?? null;
        
        $blogs = $blogModel->getAllBlogs($status, $search, $category);
        $categories = $blogModel->getAllCategories();
        
        include 'view/blog_manage.php';
        break;

    case "edit_blog":
        $id = $_GET['id'] ?? 0;
        
        require_once 'model/blog.php';
        $blogModel = new Blog();
        
        $blog = $blogModel->getBlogById($id);
        
        if (!$blog) {
            header('Location: index.php?act=blog_manage');
            exit;
        }
        
        $categories = $blogModel->getAllCategories();
        $tags = $blogModel->getAllTags();
        
        include 'view/edit_blog.php';
        break;

    default:
        include 'view/home.php';
        break;
}

// Không load header/footer cho trang login
if ($action != 'login') {
    include 'view/footer.php';
}


// HÀM HỖ TRỢ


// Hàm tạo slug
function createSlug($string) {
    $search = array(
        '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#u',
        '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#u',
        '#(ì|í|ị|ỉ|ĩ)#u',
        '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#u',
        '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#u',
        '#(ỳ|ý|ỵ|ỷ|ỹ)#u',
        '#(đ)#u',
        '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#u',
        '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#u',
        '#(Ì|Í|Ị|Ỉ|Ĩ)#u',
        '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#u',
        '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#u',
        '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#u',
        '#(Đ)#u',
    );
    
    $replace = array(
        'a', 'e', 'i', 'o', 'u', 'y', 'd',
        'A', 'E', 'I', 'O', 'U', 'Y', 'D',
    );
    
    $string = preg_replace($search, $replace, $string);
    $string = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    $string = strtolower($string);
    $string = preg_replace('/-+/', '-', $string);
    $string = trim($string, '-');
    
    return $string;
}

// Hàm cập nhật đánh giá cho sản phẩm
function updateProductRating($product_id) {
    $DBH = connect();
    
    // Đếm số lượng đánh giá đã duyệt
    $count_stmt = $DBH->prepare("SELECT COUNT(*) FROM reviews WHERE product_id = :product_id AND status = 'approved'");
    $count_stmt->bindParam(':product_id', $product_id);
    $count_stmt->execute();
    $reviews_count = $count_stmt->fetchColumn();
    
    // Tính rating trung bình
    $rating_stmt = $DBH->prepare("SELECT AVG(rating) FROM reviews WHERE product_id = :product_id AND status = 'approved'");
    $rating_stmt->bindParam(':product_id', $product_id);
    $rating_stmt->execute();
    $rating = $rating_stmt->fetchColumn();
    
    // Làm tròn rating đến 1 chữ số thập phân
    $rating = round($rating, 1);
    
    // Cập nhật sản phẩm
    $update_stmt = $DBH->prepare("UPDATE products SET rating = :rating, reviews_count = :reviews_count WHERE id = :product_id");
    $update_stmt->bindParam(':rating', $rating);
    $update_stmt->bindParam(':reviews_count', $reviews_count);
    $update_stmt->bindParam(':product_id', $product_id);
    $update_stmt->execute();
}
?>