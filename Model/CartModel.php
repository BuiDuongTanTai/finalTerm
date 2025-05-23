<?php
// Model/CartModel.php - Model xử lý giỏ hàng

require_once 'Model/Database.php';

class CartModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Lấy giỏ hàng theo user_id hoặc session_id
    public function getCart($user_id = null, $session_id = null) {
        if ($user_id) {
            $query = "SELECT c.*, p.name, p.price, p.old_price, p.image_url, p.stock, p.slug FROM carts c 
                      JOIN products p ON c.product_id = p.id 
                      WHERE c.user_id = ?";
            return $this->db->fetchAll($query, [$user_id]);
        } elseif ($session_id) {
            $query = "SELECT c.*, p.name, p.price, p.old_price, p.image_url, p.stock, p.slug FROM carts c 
                      JOIN products p ON c.product_id = p.id 
                      WHERE c.session_id = ?";
            return $this->db->fetchAll($query, [$session_id]);
        }
        
        return [];
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($product_id, $quantity, $options = null, $user_id = null, $session_id = null) {
        // Kiểm tra sản phẩm còn hàng không
        $product_query = "SELECT stock FROM products WHERE id = ?";
        $product = $this->db->fetchOne($product_query, [$product_id]);
        
        if (!$product || $product->stock < $quantity) {
            return false; // Sản phẩm không tồn tại hoặc không đủ hàng
        }
        
        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        if ($user_id) {
            $check_query = "SELECT * FROM carts WHERE user_id = ? AND product_id = ?";
            $cart_item = $this->db->fetchOne($check_query, [$user_id, $product_id]);
        } else {
            $check_query = "SELECT * FROM carts WHERE session_id = ? AND product_id = ?";
            $cart_item = $this->db->fetchOne($check_query, [$session_id, $product_id]);
        }
        
        $options_json = $options ? json_encode($options) : null;
        
        if ($cart_item) {
            // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
            $new_quantity = $cart_item->quantity + $quantity;
            
            if ($new_quantity > $product->stock) {
                $new_quantity = $product->stock; // Giới hạn số lượng theo tồn kho
            }
            
            if ($user_id) {
                $update_query = "UPDATE carts SET quantity = ?, options = ?, updated_at = NOW() WHERE user_id = ? AND product_id = ?";
                return $this->db->execute($update_query, [$new_quantity, $options_json, $user_id, $product_id]);
            } else {
                $update_query = "UPDATE carts SET quantity = ?, options = ?, updated_at = NOW() WHERE session_id = ? AND product_id = ?";
                return $this->db->execute($update_query, [$new_quantity, $options_json, $session_id, $product_id]);
            }
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            if ($user_id) {
                $insert_query = "INSERT INTO carts (user_id, product_id, quantity, options) VALUES (?, ?, ?, ?)";
                return $this->db->execute($insert_query, [$user_id, $product_id, $quantity, $options_json]);
            } else {
                $insert_query = "INSERT INTO carts (session_id, product_id, quantity, options) VALUES (?, ?, ?, ?)";
                return $this->db->execute($insert_query, [$session_id, $product_id, $quantity, $options_json]);
            }
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart($cart_id, $quantity, $user_id = null, $session_id = null) {
        // Kiểm tra giỏ hàng thuộc về người dùng
        if ($user_id) {
            $check_query = "SELECT c.*, p.stock FROM carts c 
                           JOIN products p ON c.product_id = p.id 
                           WHERE c.id = ? AND c.user_id = ?";
            $cart_item = $this->db->fetchOne($check_query, [$cart_id, $user_id]);
        } else {
            $check_query = "SELECT c.*, p.stock FROM carts c 
                           JOIN products p ON c.product_id = p.id 
                           WHERE c.id = ? AND c.session_id = ?";
            $cart_item = $this->db->fetchOne($check_query, [$cart_id, $session_id]);
        }
        
        if (!$cart_item) {
            return false; // Không tìm thấy sản phẩm trong giỏ hàng
        }
        
        // Tính toán số lượng mới
        $new_quantity = $cart_item->quantity + $quantity;
        
        // Điều chỉnh số lượng
        if ($new_quantity <= 0) {
            return $this->removeFromCart($cart_id, $user_id, $session_id);
        }
        
        // Giới hạn số lượng theo tồn kho
        if ($new_quantity > $cart_item->stock) {
            $new_quantity = $cart_item->stock;
        }
        
        // Cập nhật số lượng
        $update_query = "UPDATE carts SET quantity = ?, updated_at = NOW() WHERE id = ?";
        return $this->db->execute($update_query, [$new_quantity, $cart_id]);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($cart_id, $user_id = null, $session_id = null) {
        if ($user_id) {
            $query = "DELETE FROM carts WHERE id = ? AND user_id = ?";
            return $this->db->execute($query, [$cart_id, $user_id]);
        } else {
            $query = "DELETE FROM carts WHERE id = ? AND session_id = ?";
            return $this->db->execute($query, [$cart_id, $session_id]);
        }
    }

    // Xóa toàn bộ giỏ hàng
    public function clearCart($user_id = null, $session_id = null) {
        if ($user_id) {
            $query = "DELETE FROM carts WHERE user_id = ?";
            return $this->db->execute($query, [$user_id]);
        } else {
            $query = "DELETE FROM carts WHERE session_id = ?";
            return $this->db->execute($query, [$session_id]);
        }
    }

    // Chuyển giỏ hàng từ session sang user khi đăng nhập
    public function mergeCart($user_id, $session_id) {
        // Lấy giỏ hàng từ session
        $session_cart = $this->getCart(null, $session_id);
        
        if (!$session_cart) {
            return true; // Không có gì để merge
        }
        
        // Lặp qua từng sản phẩm trong giỏ hàng session
        foreach ($session_cart as $item) {
            // Thêm vào giỏ hàng user (sẽ tự động cộng số lượng nếu sản phẩm đã tồn tại)
            $this->addToCart($item->product_id, $item->quantity, json_decode($item->options), $user_id);
        }
        
        // Xóa giỏ hàng session
        return $this->clearCart(null, $session_id);
    }

    // Đếm số sản phẩm trong giỏ hàng
    public function countCartItems($user_id = null, $session_id = null) {
        if ($user_id) {
            $query = "SELECT SUM(quantity) as total FROM carts WHERE user_id = ?";
            $result = $this->db->fetchOne($query, [$user_id]);
        } else {
            $query = "SELECT SUM(quantity) as total FROM carts WHERE session_id = ?";
            $result = $this->db->fetchOne($query, [$session_id]);
        }
        
        return $result && $result->total ? $result->total : 0;
    }

    // Tính tổng tiền giỏ hàng
    public function calculateCartTotal($user_id = null, $session_id = null) {
        if ($user_id) {
            $query = "SELECT SUM(c.quantity * p.price) as total FROM carts c 
                      JOIN products p ON c.product_id = p.id 
                      WHERE c.user_id = ?";
            $result = $this->db->fetchOne($query, [$user_id]);
        } else {
            $query = "SELECT SUM(c.quantity * p.price) as total FROM carts c 
                      JOIN products p ON c.product_id = p.id 
                      WHERE c.session_id = ?";
            $result = $this->db->fetchOne($query, [$session_id]);
        }
        
        return $result && $result->total ? $result->total : 0;
    }

    // Tạo đơn hàng mới
    public function createOrder($user_id, $name, $email, $phone, $address, $city, $district, $ward, $total_amount, $shipping_fee, $discount_amount, $tax_amount, $payment_method, $shipping_method, $notes = null) {
        $query = "INSERT INTO orders (user_id, name, email, phone, address, city, district, ward, total_amount, shipping_fee, discount_amount, tax_amount, payment_method, shipping_method, notes) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->db->execute($query, [
            $user_id, $name, $email, $phone, $address, $city, $district, $ward, 
            $total_amount, $shipping_fee, $discount_amount, $tax_amount, 
            $payment_method, $shipping_method, $notes
        ]);
        
        return $this->db->lastInsertId();
    }

    // Thêm sản phẩm vào đơn hàng
    public function addOrderItems($order_id, $cart_items) {
        foreach ($cart_items as $item) {
            $query = "INSERT INTO order_items (order_id, product_id, name, price, quantity, options) 
                     VALUES (?, ?, ?, ?, ?, ?)";
            
            $this->db->execute($query, [
                $order_id, $item->product_id, $item->name, $item->price, 
                $item->quantity, $item->options
            ]);
            
            // Cập nhật số lượng đã bán và tồn kho
            $update_query = "UPDATE products SET 
                            sold_count = sold_count + ?, 
                            stock = stock - ? 
                            WHERE id = ?";
            
            $this->db->execute($update_query, [$item->quantity, $item->quantity, $item->product_id]);
        }
        
        return true;
    }
}