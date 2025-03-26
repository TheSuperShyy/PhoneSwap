<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';


header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["serial_number"])) {
    $serialNumber = $_POST["serial_number"];

    try {
        // Check if phone exists
        $phone = $db->phones->findOne(["serial_number" => $serialNumber]);

        if (!$phone) {
            echo json_encode(["success" => false, "error" => "Phone not found."]);
            exit;
        }

        // ✅ Check if the phone is assigned to a Team Leader (TL)
        $assignedTL = $db->users->findOne(["assigned_phone" => $serialNumber]);

        if ($assignedTL) {
            echo json_encode(["success" => false, "error" => "Phone is assigned to a TL and cannot be deleted."]);
            exit;
        }

        // Get admin details from session
        if (!isset($_SESSION['user'])) {
            echo json_encode(["success" => false, "error" => "User not authenticated."]);
            exit;
        }

        $adminEmail = $_SESSION['user'];
        $admin = $db->users->findOne(["username" => $adminEmail]);

        if (!$admin) {
            echo json_encode(["success" => false, "error" => "Admin not found."]);
            exit;
        }

        // Extract admin details
        $adminId = $admin['hfId'] ?? 'Unknown ID';
        $adminName = ($admin['first_name'] ?? 'Unknown') . ' ' . ($admin['last_name'] ?? '');

        // Delete the phone from the database
        $deleteResult = $db->phones->deleteOne(["serial_number" => $serialNumber]);

        if ($deleteResult->getDeletedCount() > 0) {
            // ✅ Insert into audit log
            $auditData = [
                "timestamp" => date("Y-m-d H:i:s"), // Current date and time
                "user" => [
                    "hfId" => $adminId,
                    "name" => $adminName,
                ],
                "serial_number" => $serialNumber,
                "model" => $phone["model"],
                "action" => "Deleted Phone"
            ];

            $db->audit->insertOne($auditData);

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
