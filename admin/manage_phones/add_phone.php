<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';

header("Content-Type: application/json"); // Return JSON response

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $deviceModel = trim($_POST["deviceModel"]);
    $serialNumber = trim($_POST["serialNumber"]);
    $status = trim($_POST["status"]);

    try {
        // ✅ Check if serial number already exists
        $existingPhone = $db->phones->findOne(["serial_number" => $serialNumber]);
        if ($existingPhone) {
            echo json_encode(["success" => false, "error" => "Serial number already exists."]);
            exit;
        }

        // ✅ Validate user session
        if (!isset($_SESSION['user'])) {
            echo json_encode(["success" => false, "error" => "User not authenticated."]);
            exit;
        }

        // ✅ Extract admin details from session
        $adminId = $_SESSION['user']['hfId'] ?? 'Unknown ID';
        $adminName = ($_SESSION['user']['first_name'] ?? 'Unknown') . ' ' . ($_SESSION['user']['last_name'] ?? '');

        // ✅ Insert new phone into MongoDB
        $insertResult = $db->phones->insertOne([
            "model" => $deviceModel,
            "serial_number" => $serialNumber,
            "status" => $status
        ]);

        if ($insertResult->getInsertedCount() > 0) {
            // ✅ Insert audit log
            $auditData = [
                "timestamp" => date("Y-m-d H:i:s"), // Current timestamp
                "user" => [
                    "hfId" => $adminId,
                    "name" => $adminName,
                ],
                "serial_number" => $serialNumber,
                "model" => $deviceModel,
                "action" => "Added New Phone"
            ];

            $db->phone_audit->insertOne($auditData);

            echo json_encode(["success" => true, "message" => "Phone added and logged."]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to add phone."]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request."]);
}
?>
