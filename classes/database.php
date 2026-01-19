<?php
// Dependencies
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../vendor/autoload.php';

class Database {

    // Database Connection
    function opencon() {
        return new PDO('mysql:host=localhost;dbname=karbono_db', 'root', '');
    }

    // Audit Logging
    function logAudit($userId, $action, $details = null) {
        $con = $this->opencon();
        $ip = $_SERVER['REMOTE_ADDR'];
        $stmt = $con->prepare("INSERT INTO audit_logs (user_id, action, details, ip_address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $action, $details, $ip]);
    }

    // Email Service
    function sendEmail($to, $subject, $body) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = 'your-email@gmail.com'; 
            $mail->Password   = 'your-app-password';    
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('no-reply@karbono.com', 'Karbono Security');
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // Authentication Logic
    function loginUser($email, $password) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['lockout_until'] && new DateTime() < new DateTime($user['lockout_until'])) {
                return ['status' => 'error', 'message' => 'Account locked. Try again in 15 minutes.'];
            }

            if (password_verify($password, $user['password_hash'])) {
                $con->prepare("UPDATE users SET failed_attempts = 0, lockout_until = NULL WHERE id = ?")->execute([$user['id']]);
                
                $this->logAudit($user['id'], "Login Successful", "Role: " . $user['role']);
                return ['status' => 'success', 'data' => $user];
            } else {
                $attempts = $user['failed_attempts'] + 1;
                $lockout = ($attempts >= 3) ? date('Y-m-d H:i:s', strtotime('+15 minutes')) : null;
                
                $con->prepare("UPDATE users SET failed_attempts = ?, lockout_until = ? WHERE id = ?")
                    ->execute([$attempts, $lockout, $user['id']]);
                
                $this->logAudit($user['id'], "Login Failed", "Attempts: $attempts");
                
                $msg = ($attempts >= 3) ? "Account locked for 15 minutes." : "Invalid credentials. Attempts left: " . (3 - $attempts);
                return ['status' => 'error', 'message' => $msg];
            }
        }
        return ['status' => 'error', 'message' => 'User not found.'];
    }

    function registerUser($email, $password) {
        $con = $this->opencon();
        try {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $con->prepare("INSERT INTO users (email, password_hash, role, is_verified) VALUES (?, ?, 'regular_user', 0)");
            $stmt->execute([$email, $hash]);
            return true;
        } catch (PDOException $e) {
            return false; 
        }
    }

    // Marketplace Functions
    function getAllProducts() {
        $con = $this->opencon();
        $stmt = $con->query("SELECT * FROM products ORDER BY price ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function addToCart($userId, $productId) {
        $con = $this->opencon();
        try {
            $con->beginTransaction();

            $stmt = $con->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $price = $stmt->fetchColumn();

            // Check for active Cart (not Pending order)
            $stmt = $con->prepare("SELECT id FROM orders WHERE user_id = ? AND status = 'Cart'");
            $stmt->execute([$userId]);
            $orderId = $stmt->fetchColumn();

            if (!$orderId) {
                $con->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, 0, 'Cart')")->execute([$userId]);
                $orderId = $con->lastInsertId();
            }

            $con->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, 1, ?)")
                ->execute([$orderId, $productId, $price]);

            $con->prepare("UPDATE orders SET total_amount = total_amount + ? WHERE id = ?")->execute([$price, $orderId]);

            $con->commit();
            return true;
        } catch (Exception $e) {
            $con->rollBack();
            return false;
        }
    }

    function getUserCart($userId) {
        $con = $this->opencon();
        $stmt = $con->prepare("
            SELECT oi.id, p.name, p.price, oi.quantity, (p.price * oi.quantity) as subtotal 
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            JOIN products p ON oi.product_id = p.id
            WHERE o.user_id = ? AND o.status = 'Cart'
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getCartTotal($userId) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT total_amount FROM orders WHERE user_id = ? AND status = 'Cart'");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn() ?: 0;
    }

    function getCartCount($userId) {
        $con = $this->opencon();
        $stmt = $con->prepare("
            SELECT SUM(oi.quantity) 
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            WHERE o.user_id = ? AND o.status = 'Cart'
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn() ?: 0;
    }

    function checkoutOrder($userId) {
        $con = $this->opencon();
        // Update status from Cart to Pending so Admin can see it
        $stmt = $con->prepare("UPDATE orders SET status = 'Pending' WHERE user_id = ? AND status = 'Cart'");
        return $stmt->execute([$userId]);
    }

    // Admin Functions
    function getPendingOrders() {
        $con = $this->opencon();
        $stmt = $con->query("SELECT o.id, u.email, o.total_amount, o.status FROM orders o JOIN users u ON o.user_id = u.id WHERE o.status = 'Pending'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAuditLogs() {
        $con = $this->opencon();
        $stmt = $con->query("SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT 50");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function approveOrder($orderId, $staffId) {
        $con = $this->opencon();
        
        $con->prepare("UPDATE orders SET status = 'Shipped' WHERE id = ?")->execute([$orderId]);
        
        $this->logAudit($staffId, "Approved Order", "Order #$orderId");

        $stmt = $con->prepare("SELECT u.email FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = ?");
        $stmt->execute([$orderId]);
        $email = $stmt->fetchColumn();

        if ($email) {
            $this->sendEmail($email, "Order Approved", "Your order #$orderId has been processed.");
        }
        return true;
    }
}
?>