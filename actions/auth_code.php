<?php
session_start();
require_once '../classes/database.php';
$db = new Database();

// Logout Logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit();
}

// Login Logic
if ($_POST['action'] === 'login') {
    $result = $db->loginUser($_POST['email'], $_POST['password']);
    
    if ($result['status'] === 'success') {
        // Session Initialization
        $_SESSION['user_id'] = $result['data']['id'];
        $_SESSION['role'] = $result['data']['role'];
        $_SESSION['email'] = $result['data']['email'];
        $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Welcome Back!'];
        
        // Role Redirection
        $redirect = ($result['data']['role'] === 'regular_user' || $result['data']['role'] === 'guest_user') ? '../index.php' : '../dashboard.php';
        header("Location: $redirect");
    } else {
        // Error Handling
        $_SESSION['swal'] = ['icon' => 'error', 'title' => 'Error', 'text' => $result['message']];
        header("Location: ../index.php");
    }
}

// Register Logic
if ($_POST['action'] === 'register') {
    $result = $db->registerUser($_POST['email'], $_POST['password']);

    if ($result) {
        $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Registered', 'text' => 'Account created. Please login.'];
    } else {
        $_SESSION['swal'] = ['icon' => 'error', 'title' => 'Error', 'text' => 'Email already exists.'];
    }
    header("Location: ../index.php");
}
?>