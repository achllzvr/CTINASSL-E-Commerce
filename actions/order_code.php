<?php
session_start();
require_once '../classes/database.php';
$db = new Database();

// Role Verification
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin_sec' && $_SESSION['role'] !== 'staff_user')) {
    header("Location: ../index.php");
    exit();
}

// Approval Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'approve') {
    $orderId = $_POST['order_id'];
    $staffId = $_SESSION['user_id'];

    if ($db->approveOrder($orderId, $staffId)) {
        $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Approved', 'text' => 'Order processed and email sent.'];
    } else {
        $_SESSION['swal'] = ['icon' => 'error', 'title' => 'Error', 'text' => 'Failed to approve order.'];
    }
}

header("Location: ../dashboard.php");
exit();
?>