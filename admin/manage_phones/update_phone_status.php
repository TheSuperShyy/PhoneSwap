<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';
header("Content-Type: application/json"); // ✅ Ensure JSON response

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ✅ Check if required fields exist
    if (!isset($_POST["serial_number"]) || !isset($_POST["status"])) {
        echo json_encode(["success" => false, "error" => "Missing required fields."]);
        exit;
    }

    $serialNumber = $_POST["serial_number"];
    $newStatus = $_POST["status"];

    try {
        // ✅ Fetch the phone record
        $phone = $db->phones->findOne(["serial_number" => $serialNumber]);

        if (!$phone) {
            echo json_encode(["success" => false, "error" => "Phone not found."]);
            exit;
        }

        // ✅ Prevent updates if phone is marked as "Missing"
        if ($phone["status"] === "Missing") {
            echo json_encode(["success" => false, "error" => "Cannot update. Phone is marked as Missing."]);
            exit;
        }

        // ✅ Validate user session
        if (!isset($_SESSION['user'])) {
            echo json_encode(["success" => false, "error" => "User not authenticated."]);
            exit;
        }

        // ✅ Fetch admin details
        $adminDetails = $_SESSION['user'];
        $admin = $db->users->findOne(["username" => $adminDetails['username']]);

        if (!$admin) {
            echo json_encode(["success" => false, "error" => "Admin not found."]);
            exit;
        }

        // ✅ Extract admin details
        $adminId = $admin['hfId'] ?? 'Unknown ID';
        $adminName = ($admin['first_name'] ?? 'Unknown') . ' ' . ($admin['last_name'] ?? '');

        // ✅ Update phone status
        $updateResult = $db->phones->updateOne(
            ["serial_number" => $serialNumber],
            ['$set' => ["status" => $newStatus]]
        );

        if ($updateResult->getModifiedCount() > 0) {
            // ✅ Insert into audit log
            $auditData = [
                "timestamp" => date("Y-m-d H:i:s"), // Current timestamp
                "user" => [
                    "hfId" => $adminId,
                    "name" => $adminName,
                ],
                "serial_number" => $serialNumber,
                "model" => $phone["model"] ?? 'Unknown Model',
                "action" => "Edited Status to: " . $newStatus
            ];

            $insertAudit = $db->audit->insertOne($auditData);

            if ($insertAudit->getInsertedId()) {
                echo json_encode(["success" => true, "message" => "Status updated successfully."]);
                exit;
            } else {
                echo json_encode(["success" => false, "error" => "Audit log insert failed."]);
                exit;
            }
        } else {
            echo json_encode(["success" => false, "error" => "No changes made."]);
            exit;
        }

    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
        exit;
    }
}
?>
