<?php
require __DIR__ . '/../../dbcon/dbcon.php';
session_start();

// Get login details
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["serial_number"])) {
    if (!isset($_SESSION['user'])) {
        echo json_encode(["success" => false, "error" => "User not logged in."]);
        exit();
    }

    $serialNumber = $_POST["serial_number"];
    $adminHfId = $_SESSION['user']['hfId']; // Get from session
    $adminName = $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name']; // Get full name from session

    try {
        // Check if phone exists
        $phone = $db->phones->findOne(["serial_number" => $serialNumber]);

        if (!$phone) {
            echo json_encode(["success" => false, "error" => "Phone not found."]);
            exit();
        }

        // Delete the phone from the database
        $deleteResult = $db->phones->deleteOne(["serial_number" => $serialNumber]);

        if ($deleteResult->getDeletedCount() > 0) {
            // ✅ Insert audit log with admin details
            $dateTime = (new DateTime())->format(DateTime::ATOM); // ISO-8601 timestamp

            $auditEntry = [
                "action" => "Phone Deleted",
                "serial_number" => $serialNumber,
                "deleted_by" => [
                    "hfId" => $adminHfId,
                    "name" => $adminName
                ],
                "timestamp" => $dateTime
            ];

            $db->audit->insertOne($auditEntry);

            echo json_encode(["success" => true, "message" => "Phone deleted successfully."]);
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
