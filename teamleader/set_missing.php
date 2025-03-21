<?php
require __DIR__ . '/../dbcon/dbcon.php';

header('Content-Type: application/json'); // Ensure JSON response
error_reporting(E_ALL);
ini_set('display_errors', 1);

$response = ["status" => "error", "message" => "Something went wrong."];

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $serial = isset($_POST['serial_number']) ? strval($_POST['serial_number']) : null;

        if (!$serial) {
            throw new Exception("Error: Serial number is missing!");
        }

        // Debugging: Check if serial number exists in MongoDB
        $existingPhone = $phonesCollection->findOne(['serial_number' => $serial]);

        if (!$existingPhone) {
            throw new Exception("Error: Serial number not found in database!");
        }

        // Update phone status to 'Missing'
        $updateResult = $phonesCollection->updateOne(
            ['serial_number' => $serial],  
            ['$set' => ['status' => 'Missing']]
        );

        if ($updateResult->getModifiedCount() > 0) {
            $response = ["status" => "success", "message" => "Phone reported as missing."];
        } else {
            throw new Exception("Error: Update failed. No changes made.");
        }
    } else {
        throw new Exception("Invalid request method.");
    }
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

// Ensure JSON response even if an error occurs
echo json_encode($response);
exit;
?>
