<?php
require __DIR__ . '/../../dbcon/dbcon.php';

header("Content-Type: application/json"); // Return JSON response

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $deviceModel = trim($_POST["deviceModel"]);
    $serialNumber = trim($_POST["serialNumber"]);
    $status = trim($_POST["status"]);

    try {
        // Check if serial number already exists
        $existingPhone = $db->phones->findOne(["serial_number" => $serialNumber]);
        if ($existingPhone) {
            echo json_encode(["success" => false, "error" => "Serial number already exists."]);
            exit;
        }

        // Insert new phone into MongoDB
        $insertResult = $db->phones->insertOne([
            "model" => $deviceModel,
            "serial_number" => $serialNumber,
            "status" => $status
        ]);

        if ($insertResult->getInsertedCount() > 0) {
            echo json_encode(["success" => true]);
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
