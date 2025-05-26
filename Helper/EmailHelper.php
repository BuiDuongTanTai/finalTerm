
<?php
require_once __DIR__ . '/../vendor/autoload.php'; // đường dẫn từ EmailHelper.php

class EmailHelper {
    private $mailer;
    private $fromEmail;
    private $fromName;

    public function __construct() {
        // Configure PHPMailer
        $this->mailer = new PHPMailer\PHPMailer\PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com'; // Replace with your SMTP host
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'luffyvina37@gmail.com'; // Replace with your email
        $this->mailer->Password = 'utgu cian huzy ywod'; // Replace with your app password
        $this->mailer->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
        $this->mailer->CharSet = 'UTF-8';
        
        $this->fromEmail = 'luffyvina37@gmail.com'; // Replace with your email
        $this->fromName = 'Camera Vỹ Tài Thương'; // Replace with your store name
    }

    public function sendOrderConfirmation($order, $user) {
        try {
            $this->mailer->setFrom($this->fromEmail, $this->fromName);
            $this->mailer->addAddress($user->email, $user->name);
            $this->mailer->Subject = 'Xác nhận đơn hàng #' . $order->id;
            
            // Create email body
            $body = "Xin chào {$user->name},\n\n";
            $body .= "Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi.\n\n";
            $body .= "Chi tiết đơn hàng #{$order->id}:\n";
            $body .= "Tổng tiền: " . number_format($order->total_amount, 0, ',', '.') . "đ\n";
            $body .= "Phương thức thanh toán: {$order->payment_method}\n\n";
            $body .= "Chúng tôi sẽ thông báo khi đơn hàng được xử lý.\n\n";
            $body .= "Trân trọng,\n";
            $body .= $this->fromName;
            
            $this->mailer->Body = $body;
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
    }

    public function sendRegistrationConfirmation($user) {
        try {
            $this->mailer->setFrom($this->fromEmail, $this->fromName);
            $this->mailer->addAddress($user->email, $user->name);
            $this->mailer->Subject = 'Chào mừng đến với ' . $this->fromName;
            
            // Create email body
            $body = "Xin chào {$user->name},\n\n";
            $body .= "Cảm ơn bạn đã đăng ký tài khoản tại cửa hàng của chúng tôi.\n\n";
            $body .= "Thông tin tài khoản của bạn:\n";
            $body .= "Email: {$user->email}\n";
            $body .= "Tên đăng nhập: {$user->username}\n\n";
            $body .= "Bạn có thể đăng nhập và bắt đầu mua sắm ngay bây giờ.\n\n";
            $body .= "Trân trọng,\n";
            $body .= $this->fromName;
            
            $this->mailer->Body = $body;
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
    }

    public function sendOrderCancellation($order, $user) {
        try {
            $this->mailer->setFrom($this->fromEmail, $this->fromName);
            $this->mailer->addAddress($user->email, $user->name);
            $this->mailer->Subject = 'Xác nhận hủy đơn hàng #' . $order->id;
            
            // Create email body
            $body = "Xin chào {$user->name},\n\n";
            $body .= "Đơn hàng #{$order->id} của bạn đã được hủy thành công.\n\n";
            $body .= "Chi tiết đơn hàng đã hủy:\n";
            $body .= "Tổng tiền: " . number_format($order->total_amount, 0, ',', '.') . "đ\n";
            $body .= "Ngày hủy: " . date('d/m/Y H:i:s') . "\n\n";
            $body .= "Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi.\n\n";
            $body .= "Trân trọng,\n";
            $body .= $this->fromName;
            
            $this->mailer->Body = $body;
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
    }
}