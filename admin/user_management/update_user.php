<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

// Debugging logs
error_log("Received Data: " . print_r($data, true));

if (!$data || !isset($data['hfId']) || empty($data['hfId'])) {
    echo json_encode(["success" => false, "message" => "Missing HFID or invalid data"]);
    exit;
}

if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "error" => "User not authenticated."]);
    exit;
}

// ✅ Extract admin details from session
$userdetails = $_SESSION["user"];
$details = $db->users->findOne(["username" => $userdetails['username']]);

if (!$details) {
    echo json_encode(["success" => false, "error" => "Admin not found."]);
    exit;
}

// Extract user details from session
$adminId = $details['hfId'] ?? 'Unknown ID';
$adminName = ($details['first_name'] ?? 'Unknown') . ' ' . ($details['last_name'] ?? '');
$adminRole = $details['userType'] ?? '';

// Ensure all required fields are present and valid
$hfId = trim($data['hfId']);
$firstName = trim($data['firstName']);
$lastName = trim($data['lastName']);
$email = trim($data['username']);
$role = trim($data['role']); // Ensure role is passed

// Check if required fields are empty
if (empty($hfId) || empty($firstName) || empty($lastName) || empty($email)) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

// Ensure that no extra output is sent before the JSON response
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email format"]);
    exit;
}

// ✅ Step 1: Find the user by userId (_id), not hfId
$user = $usersCollection->findOne(["_id" => new MongoDB\BSON\ObjectId($data['userId'])]);

if (!$user) {
    echo json_encode(["success" => false, "message" => "User not found."]);
    exit;
}

// ✅ Step 2: Prepare updated fields
$updateFields = [
    "first_name" => $firstName,
    "last_name" => $lastName,
    "username" => $email,
    "userType" => 'TL', // Assuming role needs to be updated as well
    "hfId" => $hfId // Keep hfId as part of the update
];

// ✅ Step 3: Perform update using _id directly
$result = $usersCollection->updateOne(
    ["_id" => new MongoDB\BSON\ObjectId($data['userId'])], // Use _id from the found user
    ['$set' => $updateFields]
);

if ($result->getModifiedCount() > 0) {
    // ✅ Log audit entry
    $auditData = [
        "timestamp" => date("Y-m-d H:i:s"),
        "user" => [
            "hfId" => $adminId,
            "name" => $adminName,
        ],
        "action" => "Updated User",
        "details" => $updateFields
    ];
    $db->user_audit->insertOne($auditData);

    // Send success response after update
    echo json_encode(["success" => true, "message" => "User updated successfully!"]);
} else {
    // If no changes were made, send the corresponding response
    echo json_encode(["success" => false, "message" => "No changes made."]);
}
?>
