<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["serial_number"])) {
    $serialNumber = $_POST["serial_number"];

    try {
        $phone = $db->phones->findOne(["serial_number" => $serialNumber]);

        if (!$phone) {
            echo json_encode(["success" => false, "error" => "Phone not found."]);
            exit;
        }
        $assignedTL = $db->users->findOne(["assigned_phone" => $serialNumber]);

        if ($assignedTL) {
            echo json_encode(["success" => false, "error" => "Phone is assigned to a TL and cannot be deleted."]);
            exit;
        }
        if (!isset($_SESSION['user'])) {
            echo json_encode(["success" => false, "error" => "User not authenticated."]);
            exit;
        }
        $adminId = $_SESSION['user']['hfId'] ?? 'Unknown ID';
        $adminName = ($_SESSION['user']['first_name'] ?? 'Unknown') . ' ' . ($_SESSION['user']['last_name'] ?? '');

        $deleteResult = $db->phones->deleteOne(["serial_number" => $serialNumber]);

        if ($deleteResult->getDeletedCount() > 0) {
            // ✅ Insert into audit log
            $auditData = [
                "timestamp" => date("Y-m-d H:i:s"), // Current timestamp
                "user" => [
                    "hfId" => $adminId,
                    "name" => $adminName,
                ],
                "serial_number" => $serialNumber,
                "model" => $phone["model"] ?? 'Unknown Model',
                "action" => "Deleted Phone"
            ];

            $db->phone_audit->insertOne($auditData);

            echo json_encode(["success" => true, "message" => "Phone deleted and logged."]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to delete phone."]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request."]);
}
?>
 