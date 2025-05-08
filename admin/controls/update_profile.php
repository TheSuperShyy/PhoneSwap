<?php

require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';
header('Content-Type: application/json');

// ✅ Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "error" => "User not authenticated."]);
    exit;
}

$userSession = $_SESSION['user'];
$username = $userSession['username'];

// ✅ Retrieve posted data
$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$email = $_POST['username'] ?? '';

// ✅ Basic validation (optional)
if (empty($firstName) || empty($lastName) || empty($email)) {
    echo json_encode(["success" => false, "error" => "All fields are required."]);
    exit;
}

// ✅ Find user in database
$collection = $db->users;
$existingUser = $collection->findOne(['username' => $username]);

if (!$existingUser) {
    echo json_encode(["success" => false, "error" => "User not found in database."]);
    exit;
}

// ✅ Update user document
$updateResult = $collection->updateOne(
    ['username' => $username],
    ['$set' => [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'username' => $email
    ]]
);

if ($updateResult->getModifiedCount() > 0) {
    echo json_encode(["success" => true, "message" => "Profile updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "No changes were made."]);
}
?>
