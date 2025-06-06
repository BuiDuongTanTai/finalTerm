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
        error_log('CartModel::addToCart - Product ID: ' . $product_id . ', Quantity: ' . $quantity . ', User ID: ' . $user_id . ', Session ID: ' . $session_id);
        
        // Validate input parameters
        if (!$product_id || $quantity <= 0) {
            error_log('CartModel::addToCart - Invalid input parameters');
            return false;
        }
        
        if (!$user_id && !$session_id) {
            error_log('CartModel::addToCart - No user_id or session_id provided');
            return false;
        }
        
        try {
            // Kiểm tra sản phẩm còn hàng không
            $product_query = "SELECT stock FROM products WHERE id = ?";
            $product = $this->db->fetchOne($product_query, [$product_id]);
            
            if (!$product) {
                error_log('CartModel::addToCart - Product not found: ' . $product_id);
                return false;
            }
            
            if ($product->stock < $quantity) {
                error_log('CartModel::addToCart - Insufficient stock for product ' . $product_id . ': requested ' . $quantity . ', available ' . $product->stock);
                return false;
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
                error_log('CartModel::addToCart - Updating existing cart item');
                // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
                $new_quantity = $cart_item->quantity + $quantity;
                
                if ($new_quantity > $product->stock) {
                    $new_quantity = $product->stock; // Giới hạn số lượng theo tồn kho
                }
                
                if ($user_id) {
                    $update_query = "UPDATE carts SET quantity = ?, options = ?, updated_at = NOW() WHERE user_id = ? AND product_id = ?";
                    $result = $this->db->execute($update_query, [$new_quantity, $options_json, $user_id, $product_id]);
                } else {
                    $update_query = "UPDATE carts SET quantity = ?, options = ?, updated_at = NOW() WHERE session_id = ? AND product_id = ?";
                    $result = $this->db->execute($update_query, [$new_quantity, $options_json, $session_id, $product_id]);
                }
                error_log('CartModel::addToCart - Update result: ' . ($result ? 'success' : 'failed'));
                return $result;
            } else {
                error_log('CartModel::addToCart - Adding new cart item');
                // Thêm sản phẩm mới vào giỏ hàng
                if ($user_id) {
                    $insert_query = "INSERT INTO carts (user_id, product_id, quantity, options) VALUES (?, ?, ?, ?)";
                    $result = $this->db->execute($insert_query, [$user_id, $product_id, $quantity, $options_json]);
                } else {
                    $insert_query = "INSERT INTO carts (session_id, product_id, quantity, options) VALUES (?, ?, ?, ?)";
                    $result = $this->db->execute($insert_query, [$session_id, $product_id, $quantity, $options_json]);
                }
                error_log('CartModel::addToCart - Insert result: ' . ($result ? 'success' : 'failed'));
                return $result;
            }
        } catch (Exception $e) {
            error_log('CartModel::addToCart - Exception: ' . $e->getMessage());
            return false;
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

    public function getCartItemWithStock($cart_id, $user_id = null, $session_id = null) {
        if ($user_id) {
            $query = "SELECT c.*, p.stock FROM carts c 
                      JOIN products p ON c.product_id = p.id 
                      WHERE c.id = ? AND c.user_id = ?";
            return $this->db->fetchOne($query, [$cart_id, $user_id]);
        } elseif ($session_id) {
            $query = "SELECT c.*, p.stock FROM carts c 
                      JOIN products p ON c.product_id = p.id 
                      WHERE c.id = ? AND c.session_id = ?";
            return $this->db->fetchOne($query, [$cart_id, $session_id]);
        }
        
        return null;
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCartQuantity($cart_id, $quantity) {
        $query = "UPDATE carts SET quantity = ?, updated_at = NOW() WHERE id = ?";
        return $this->db->execute($query, [$quantity, $cart_id]);
    }

    // Hủy đơn hàng
    public function cancelOrder($order_id, $cancel_reason, $other_reason = null) {
        // Cập nhật trạng thái đơn hàng
        $query = "UPDATE orders SET status = 'cancelled', notes = CONCAT(notes, '\nLý do hủy: ', ?) WHERE id = ?";
        $reason = $cancel_reason === 'other' ? $other_reason : $cancel_reason;
        $this->db->execute($query, [$reason, $order_id]);
        
        // Hoàn trả số lượng sản phẩm vào kho
        $items_query = "SELECT product_id, quantity FROM order_items WHERE order_id = ?";
        $items = $this->db->fetchAll($items_query, [$order_id]);
        
        foreach ($items as $item) {
            $update_query = "UPDATE products SET 
                            sold_count = sold_count - ?, 
                            stock = stock + ? 
                            WHERE id = ?";
            
            $this->db->execute($update_query, [$item->quantity, $item->quantity, $item->product_id]);
        }
        
        return true;
    }

    // Lấy thông tin đơn hàng theo ID
    public function getOrderById($order_id) {
        $query = "SELECT * FROM orders WHERE id = ?";
        return $this->db->fetchOne($query, [$order_id]);
    }
}