<?php
require __DIR__ . '/../dbcon/dbcon.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['serial_number'], $data['hfId'])) {
    echo json_encode(["success" => false, "message" => "Invalid request data."]);
    exit;
}

$serialNumber = $data['serial_number'];
$hfId = $data['hfId']; // Use hfId as the Team Leader identifier

try {
    $collection = $db->users; // Access the 'users' collection

    // Find the user (Team Leader) and update the assigned_phone array
    $updateResult = $collection->updateOne(
        ["hfId" => $hfId], 
        ['$addToSet' => ["assigned_phone" => $serialNumber]]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["success" => true, "message" => "Phone assigned successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to assign phone."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>
