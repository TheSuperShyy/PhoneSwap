<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';
header("Content-Type: application/json"); // ✅ Ensure JSON response

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if required fields are present
    if (!isset($_POST["serial_number"]) || !isset($_POST["status"])) {
        echo json_encode(["success" => false, "error" => "Missing required fields."]);
        exit;
    }

    $serialNumber = $_POST["serial_number"];
    $newStatus = $_POST["status"];

    try {
        // ✅ Fetch current status of the phone
        $phone = $db->phones->findOne(["serial_number" => $serialNumber]);

        if (!$phone) {
            echo json_encode(["success" => false, "error" => "Phone not found."]);
            exit;
        }

        // ✅ Prevent update if the current status is "Missing"
        if ($phone["status"] === "Missing") {
            echo json_encode(["success" => false, "error" => "Cannot update. Phone is marked as Missing."]);
            exit;
        }

        // ✅ Get admin details from session
        if (!isset($_SESSION['user'])) {
            echo json_encode(["success" => false, "error" => "User not authenticated."]);
            exit;
        }

        $adminEmail = $_SESSION['user'];
        $admin = $db->users->findOne(["username" => $adminEmail['username']]);

        if (!$admin) {
            echo json_encode(["success" => false, "error" => "Admin not found."]);
            exit;
        }

        // Extract admin details
        $adminId = $admin['hfId'] ?? 'Unknown ID';
        $adminName = ($admin['first_name'] ?? 'Unknown') . ' ' . ($admin['last_name'] ?? '');

        // ✅ Update phone status in MongoDB
        $updateResult = $db->phones->updateOne(
            ["serial_number" => $serialNumber],
            ['$set' => ["status" => $newStatus]]
        );

        if ($updateResult->getModifiedCount() > 0) {
            // ✅ Insert into audit log for edits
            $auditData = [
                "timestamp" => date("Y-m-d H:i:s"), // Current date and time
                "user" => [
                    "hfId" => $adminId,
                    "name" => $adminName,
                ],
                "serial_number" => $serialNumber,
                "model" => $phone["model"],
                "action" => "Edited Status to: " . $newStatus
            ];

            $db->audit->insertOne($auditData);

            // ✅ Redirect with success message
            header("Location: ../dashboard/dashboard.php?success=Status updated successfully!");
            exit;
        } else {
            // ✅ Redirect with error message
            header("Location: ../dashboard/dashboard.php?error=No changes made.");
            exit;
        }

    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
        exit;
    }
}
?>