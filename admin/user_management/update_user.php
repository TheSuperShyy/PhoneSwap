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
$adminId = $_SESSION['user']['hfId'] ?? 'Unknown ID';
$adminName = ($_SESSION['user']['first_name'] ?? 'Unknown') . ' ' . ($_SESSION['user']['last_name'] ?? '');

$hfId = trim($data['hfId']);
$firstName = trim($data['firstName']);
$lastName = trim($data['lastName']);
$email = trim($data['username']);
$role = trim($data['role']); // Ensure role is passed

if (!$usersCollection) {
    echo json_encode(["success" => false, "message" => "MongoDB connection failed"]);
    exit;
}

// ✅ Step 1: Find the _id using the old hfId
$user = $usersCollection->findOne(["hfId" => $hfId]);

if (!$user) {
    error_log("User with HFID '$hfId' not found.");
    echo json_encode(["success" => false, "message" => "User not found."]);
    exit;
}

// ✅ Ensure we extract a valid MongoDB ObjectId
try {
    $userId = new ($user['_id']);
} catch (Exception $e) {
    error_log("Invalid ObjectId conversion: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "Invalid user ID format."]);
    exit;
}

// ✅ Step 2: Prepare updated fields
$updateFields = [
    "first_name" => $firstName,
    "last_name" => $lastName,
    "username" => $email,
    "userType" => "TL",
    "hfId" => $hfId
];

error_log("Updating user with _id: " . $userId);

// ✅ Step 3: Perform update using _id
$result = $usersCollection->updateOne(
    ["_id" => $userId], // Update using _id
    ['$set' => $updateFields]
);

error_log("Modified Count: " . $result->getModifiedCount());

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

    echo json_encode(["success" => true, "message" => "User updated successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "No changes made."]);
}
?>
