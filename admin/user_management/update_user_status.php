<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../dbcon/session_get.php';

use MongoDB\BSON\ObjectId;

header('Content-Type: application/json');

// Start the session (if not already started)
session_start();

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $collection = $db->users;
        $auditCollection = $db->user_audit;

        $data = json_decode(file_get_contents("php://input"), true);
        $userId = $data['userId'] ?? '';
        $newStatus = $data['status'] ?? '';

        // Validate the input
        if (empty($userId) || !in_array($newStatus, ['active', 'deactivated'])) {
            echo json_encode(["success" => false, "message" => "Invalid user ID or status."]);
            exit;
        }

        // Debugging: Log the userId received
        error_log("User ID received: " . $userId);

        // Validate ObjectId format
        try {
            $objectId = new ObjectId($userId);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Invalid User ID format."]);
            exit;
        }

        // Update user status dynamically
        $updateResult = $collection->updateOne(
            ["_id" => $objectId],
            ['$set' => ["status" => $newStatus]]
        );

        // Debugging: Log the result of the update operation
        error_log("Update Result: " . json_encode($updateResult));

        if ($updateResult->getModifiedCount() === 0) {
            echo json_encode(["success" => false, "message" => "No user found or status unchanged."]);
            exit;
        }

        // Get admin details from session
        $adminId = $_SESSION['user']['hfId'] ?? 'Unknown ID';
        $adminName = ($_SESSION['user']['first_name'] ?? 'Unknown') . ' ' . ($_SESSION['user']['last_name'] ?? '');

        // Debugging: Check session values
        error_log("Admin Session: hfId = $adminId, Name = $adminName");

        // Log the status change in the audit collection
        $insertResult = $auditCollection->insertOne([
            "timestamp" => date("Y-m-d H:i:s"),
            "user" => [
                "hfId" => $adminId,
                "name" => $adminName,
            ],
            "action" => $newStatus === "active" ? "Activated User" : "Deactivated User",
            "details" => ["hfId" => $userId]
        ]);

        // Debugging: Log the insertion result
        error_log("Audit Log Insert Result: " . json_encode($insertResult));

        echo json_encode(["success" => true, "message" => "User status updated to '$newStatus'."]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
