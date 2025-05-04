<?php
session_start();
require __DIR__ . '/../../dbcon/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // ✅ Find user by email instead of username
    $user = $db->users->findOne(["username" => $email]);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            "hfId" => $user['hfId'],
            "username" => $user['username'],
            "userType" => $user['userType'],
            "email" => $user['email'] ?? '',
            "first_name" => $user['first_name'] ?? '',
            "last_name" => $user['last_name'] ?? '',
        ];

        // Send userType in the response to handle redirection on the frontend
        echo json_encode([
            "success" => true,
            "message" => "Login successful!",
            "userType" => $user['userType'],
            "session" => $_SESSION
        ]);
        exit();
    } else {
        echo json_encode(["success" => false, "error" => "Invalid email or password."]);
        exit();
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request."]);
    exit();
}
