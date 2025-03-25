<?php
require __DIR__ . '/../dbcon/dbcon.php';


header("Content-Type: application/json"); // Return JSON response

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["serial_number"])) {
    $serialNumber = $_POST["serial_number"];

    try {
        // Check if phone exists
        $phone = $db->phones->findOne(["serial_number" => $serialNumber]);

        if (!$phone) {
            echo json_encode(["success" => false, "error" => "Phone not found."]);
            exit;
        }

        // Delete the phone from the database
        $deleteResult = $db->phones->deleteOne(["serial_number" => $serialNumber]);

        if ($deleteResult->getDeletedCount() > 0) {
            echo json_encode(["success" => true]);
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
