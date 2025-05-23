<?php
// Model/UserModel.php - Model xử lý người dùng

require_once 'Model/Database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Đăng ký người dùng mới
    public function register($name, $email, $password, $phone = null) {
        // Kiểm tra email đã tồn tại chưa
        $check_query = "SELECT id FROM users WHERE email = ?";
        $user = $this->db->fetchOne($check_query, [$email]);
        
        if ($user) {
            return false; // Email đã tồn tại
        }
        
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Thêm người dùng mới
        $query = "INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, 'customer')";
        return $this->db->execute($query, [$name, $email, $hashed_password, $phone]);
    }

    // Đăng nhập
    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ? AND status = 1";
        $user = $this->db->fetchOne($query, [$email]);
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        
        return false;
    }

    // Lấy thông tin người dùng theo ID
    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = ?";
        return $this->db->fetchOne($query, [$id]);
    }

    // Cập nhật thông tin người dùng
    public function updateUser($id, $name, $phone, $address, $city, $district, $ward) {
        $query = "UPDATE users SET name = ?, phone = ?, address = ?, city = ?, district = ?, ward = ?, updated_at = NOW() WHERE id = ?";
        return $this->db->execute($query, [$name, $phone, $address, $city, $district, $ward, $id]);
    }

    // Đổi mật khẩu
    public function changePassword($id, $current_password, $new_password) {
        // Kiểm tra mật khẩu hiện tại
        $user = $this->getUserById($id);
        
        if (!$user || !password_verify($current_password, $user->password)) {
            return false;
        }
        
        // Mã hóa mật khẩu mới
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Cập nhật mật khẩu
        $query = "UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?";
        return $this->db->execute($query, [$hashed_password, $id]);
    }

    // Lấy danh sách đơn hàng của người dùng
    public function getUserOrders($user_id) {
        $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        return $this->db->fetchAll($query, [$user_id]);
    }

    // Lấy chi tiết đơn hàng
    public function getOrderById($order_id, $user_id) {
        $query = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
        return $this->db->fetchOne($query, [$order_id, $user_id]);
    }

    // Lấy các sản phẩm trong đơn hàng
    public function getOrderItems($order_id) {
        $query = "SELECT oi.*, p.image_url, p.slug FROM order_items oi 
                  LEFT JOIN products p ON oi.product_id = p.id 
                  WHERE oi.order_id = ?";
        return $this->db->fetchAll($query, [$order_id]);
    }

    // Cập nhật avatar
    public function updateAvatar($user_id, $avatar) {
        $query = "UPDATE users SET avatar = ?, updated_at = NOW() WHERE id = ?";
        return $this->db->execute($query, [$avatar, $user_id]);
    }
}