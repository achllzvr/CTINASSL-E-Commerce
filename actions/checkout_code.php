<?php
session_start();
require_once '../classes/database.php';
$db = new Database();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Logic: Process Checkout
// Changes order status from 'Cart' to 'Pending' so it becomes visible to Staff
$result = $db->checkoutOrder($_SESSION['user_id']);

if ($result) {
    $_SESSION['swal'] = [
        'icon' => 'success',
        'title' => 'Order Placed!',
        'text' => 'Your contribution is pending approval. You will be notified via email once processed.'
    ];
} else {
    $_SESSION['swal'] = [
        'icon' => 'info',
        'title' => 'Cart Empty',
        'text' => 'You have no items to checkout.'
    ];
}

header("Location: ../index.php");
exit();
?>