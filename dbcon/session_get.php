<?php
if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "error" => "User not authenticated."]);
    exit;
}

$userdetails = $_SESSION["user"];
$details = $db->users->findOne(["username" => $userdetails['username']]);

if (!$details) {
    echo json_encode(["success" => false, "error" => "Admin not found."]);
    exit;
}

// Extract user details
$userId = $details['hfId'] ?? 'Unknown ID';
$userName = ($details['first_name'] ?? 'Unknown') . ' ' . ($details['last_name'] ?? '');
$userRole = $details['userType'] ??'';
?>