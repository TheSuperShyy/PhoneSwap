<?php
require __DIR__ . '/../dbcon/dbcon.php';

// Debugging: Show errors if any
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Read JSON request
$data = json_decode(file_get_contents("php://input"), true);

// Check if request is received properly
if (!$data) {
    echo json_encode(["success" => false, "error" => "Invalid JSON data"]);
    exit;
}

// Validate input
if (!isset($data['serial_number']) || !isset($data['team_member'])) {
    echo json_encode(["success" => false, "error" => "Missing required fields"]);
    exit;
} elseif ($data['serial_number'] == "Select Serial Number" || $data['team_member'] == "Select Team Member") {
    echo json_encode(["success" => false, "error" => "Empty required fields"]);
    exit;
}

$serialNumber = $data['serial_number'];
$teamMember = $data['team_member'];

try {
    $collection = $db->phones; // Ensure 'phones' collection exists

    // Update phone record in MongoDB
    $updateResult = $collection->updateOne(
        ["serial_number" => $serialNumber], 
        ['$set' => ["assigned_to" => $teamMember]]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "No record updated."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
