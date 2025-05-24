<?php
// Kiểm tra đăng nhập cho tài khoản admin/staff
function CheckLogin($email, $pass)
{
    $DBH = connect();
    $query = "
    SELECT * FROM users
    WHERE email = :email AND (role = 'admin' OR role = 'staff') AND status = 1
    ";

    $STH = $DBH->prepare($query);
    $STH->bindParam(':email', $email);
    $STH->execute();
    
    // Lấy thông tin người dùng
    $user = $STH->fetch(PDO::FETCH_ASSOC);
    
    // Kiểm tra xem người dùng tồn tại và so sánh mật khẩu
    if ($user && password_verify($pass, $user['password'])) {
        return true; // Đăng nhập thành công
    }
    
    return false; // Đăng nhập thất bại
}

// Lấy danh sách người dùng
function getUsers($limit = null, $offset = 0, $search = null)
{
    $DBH = connect();
    
    $sql = "SELECT * FROM users";
    $params = [];
    
    if ($search) {
        $sql .= " WHERE name LIKE :search OR email LIKE :search OR phone LIKE :search";
        $params[':search'] = "%$search%";
    }
    
    $sql .= " ORDER BY id DESC";
    
    if ($limit) {
        $sql .= " LIMIT :offset, :limit";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;
    }
    
    $stmt = $DBH->prepare($sql);
    
    // Bind các tham số
    foreach ($params as $key => $value) {
        if ($key == ':limit' || $key == ':offset') {
            $stmt->bindValue($key, $value, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($key, $value);
        }
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Đếm tổng số người dùng
function countUsers($search = null)
{
    $DBH = connect();
    
    $sql = "SELECT COUNT(*) FROM users";
    $params = [];
    
    if ($search) {
        $sql .= " WHERE name LIKE :search OR email LIKE :search OR phone LIKE :search";
        $params[':search'] = "%$search%";
    }
    
    $stmt = $DBH->prepare($sql);
    
    // Bind các tham số
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Lấy thông tin người dùng theo ID
function getUserById($id)
{
    $DBH = connect();
    $stmt = $DBH->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Thêm người dùng mới
function addUser($data)
{
    $DBH = connect();
    
    // Kiểm tra email đã tồn tại
    $check = $DBH->prepare("SELECT id FROM users WHERE email = :email");
    $check->bindParam(':email', $data['email']);
    $check->execute();
    
    if ($check->rowCount() > 0) {
        return [
            'success' => false,
            'message' => 'Email đã tồn tại'
        ];
    }
    
    $stmt = $DBH->prepare("INSERT INTO users (name, email, password, phone, role, status) 
                          VALUES (:name, :email, :password, :phone, :role, :status)");
    
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':phone', $data['phone']);
    $stmt->bindParam(':role', $data['role']);
    $stmt->bindParam(':status', $data['status']);
    
    if ($stmt->execute()) {
        return [
            'success' => true,
            'message' => 'Thêm người dùng thành công',
            'user_id' => $DBH->lastInsertId()
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Lỗi khi thêm người dùng'
        ];
    }
}

// Cập nhật thông tin người dùng
function updateUser($id, $data, $password = null)
{
    $DBH = connect();
    
    $sql = "UPDATE users SET name = :name, phone = :phone, role = :role, status = :status";
    $params = [
        ':id' => $id,
        ':name' => $data['name'],
        ':phone' => $data['phone'],
        ':role' => $data['role'],
        ':status' => $data['status']
    ];
    
    // Nếu có cập nhật mật khẩu
    if ($password) {
        $sql .= ", password = :password";
        $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
    }
    
    $sql .= " WHERE id = :id";
    
    $stmt = $DBH->prepare($sql);
    
    // Bind các tham số
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    
    if ($stmt->execute()) {
        return [
            'success' => true,
            'message' => 'Cập nhật người dùng thành công'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Lỗi khi cập nhật người dùng'
        ];
    }
}

// Xóa người dùng
function deleteUser($id)
{
    $DBH = connect();
    $stmt = $DBH->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        return [
            'success' => true,
            'message' => 'Xóa người dùng thành công'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Lỗi khi xóa người dùng'
        ];
    }
}
?>