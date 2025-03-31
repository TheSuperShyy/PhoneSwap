<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);


if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "error" => "User not authenticated."]);
    exit;
}

$adminId = $_SESSION['user']['hfId'] ?? 'Unknown ID';
$adminName = ($_SESSION['user']['first_name'] ?? 'Unknown') . ' ' . ($_SESSION['user']['last_name'] ?? '');

if (!$data || !isset($data['hfId']) || empty($data['hfId'])) {
    echo json_encode(["success" => false, "message" => "Missing HFID or invalid data"]);
    exit;
}

$hfId = $data['hfId'];


error_log("Deleting user with HFID: $hfId");


$user = $db->users->findOne(["hfId" => $hfId]);
if (!$user) {
    echo json_encode(["success" => false, "message" => "User not found or already deleted."]);
    exit;
}

$result = $db->users->deleteOne(["hfId" => $hfId]);

if ($result->getDeletedCount() > 0) {
    // ✅ Fetch deleted user details before deleting (Prevents undefined variables)
    $auditData = [
        "timestamp" => date("Y-m-d h:i:s A"), // ✅ 12-hour format with AM/PM
        "user" => [
            "hfId" => $adminId,
            "name" => $adminName,
        ],
        "action" => "Deleted User",
        "details" => [
            "hfId" => $user['hfId'], // ✅ Use fetched user data
            "username" => $user['username'] ?? 'Unknown',
            "first_name" => $user['first_name'] ?? 'Unknown',
            "last_name" => $user['last_name'] ?? 'Unknown',
            "userType" => $user['userType'] ?? 'Unknown'
        ]
    ];

    // ✅ Insert audit log
    $db->user_audit->insertOne($auditData);

    echo json_encode(["success" => true, "message" => "User deleted and logged."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to delete user."]);
}

?>
