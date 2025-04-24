<?php
require __DIR__ . '/../../dbcon/dbcon.php';
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$hfId = $data['hfId'] ?? '';
$firstName = $data['first_name'] ?? '';
$lastName = $data['last_name'] ?? '';
$email = $data['email'] ?? '';
$role = $data['role'] ?? 'TM';

if (!$hfId || !$firstName || !$lastName || !$email) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

// Update user
$updateResult = $db->users->updateOne(
    ['hfId' => $hfId],
    ['$set' => [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'username' => $email,
        'userType' => $role
    ]]
);

if ($updateResult->getModifiedCount() > 0) {
    echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'No changes made or user not found.']);
}
?>