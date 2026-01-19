<?php
session_start();
require_once '../classes/database.php';
$db = new Database();

// POST Validation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    
    // Auth Check
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['swal'] = ['icon' => 'error', 'title' => 'Oops...', 'text' => 'Please login to add items.'];
        header("Location: ../index.php");
        exit();
    }

    // Role Validation
    if ($_SESSION['role'] === 'guest_user') {
        $_SESSION['swal'] = ['icon' => 'warning', 'title' => 'Guest Account', 'text' => 'Guests cannot purchase items. Please register a full account.'];
        header("Location: ../index.php");
        exit();
    }

    // Add Item Logic
    $result = $db->addToCart($_SESSION['user_id'], $_POST['product_id']);

    if ($result) {
        $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Added!', 'text' => 'Item added to your offset list.'];
    } else {
        $_SESSION['swal'] = ['icon' => 'error', 'title' => 'Error', 'text' => 'Could not add item.'];
    }
}

header("Location: ../index.php");
exit();
?>