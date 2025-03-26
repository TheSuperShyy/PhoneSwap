<?php
require __DIR__ . '/../../dbcon/dbcon.php';
session_start();

// Get login details
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo "<script>alert('Please fill in all fields'); window.location.href='../loginpage.php';</script>";
    exit();
}

// Find user in MongoDB
$user = $usersCollection->findOne(['username' => $email]);

if ($user && password_verify($password, $user['password'])) {
    // Set session for logged-in user
    $_SESSION['user'] = $email;

    // Redirect to dashboard
    header("Location: ../../admin/dashboard/dashboard.php");
    exit();
} else {
    echo "<script>alert('Invalid username or password'); window.location.href='../loginpage.php';</script>";
}
?>
