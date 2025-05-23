<?php
// Model/Database.php - Lớp cơ sở dữ liệu

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'cameravn';
    private $conn;
    
    // Kết nối DB
    public function __construct() {
        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            echo 'Lỗi kết nối: ' . $e->getMessage();
            exit;
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    // Thực thi truy vấn có trả về kết quả (SELECT)
    public function query($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            echo 'Lỗi truy vấn: ' . $e->getMessage();
            return false;
        }
    }

    // Thực thi truy vấn không trả về kết quả (INSERT, UPDATE, DELETE)
    public function execute($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            echo 'Lỗi thực thi: ' . $e->getMessage();
            return false;
        }
    }

    // Lấy một bản ghi
    public function fetchOne($query, $params = []) {
        $stmt = $this->query($query, $params);
        return $stmt ? $stmt->fetch() : false;
    }

    // Lấy tất cả bản ghi
    public function fetchAll($query, $params = []) {
        $stmt = $this->query($query, $params);
        return $stmt ? $stmt->fetchAll() : false;
    }

    // Lấy ID của bản ghi vừa được thêm vào
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }

    // Bắt đầu transaction
    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    // Commit transaction
    public function commit() {
        return $this->conn->commit();
    }

    // Rollback transaction
    public function rollback() {
        return $this->conn->rollBack();
    }

    // Đếm số bản ghi
    public function count($query, $params = []) {
        $stmt = $this->query($query, $params);
        return $stmt ? $stmt->rowCount() : 0;
    }
}