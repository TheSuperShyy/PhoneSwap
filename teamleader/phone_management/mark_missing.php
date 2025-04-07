<?php
require __DIR__ . '/../../dbcon/dbcon.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$serial_number = $data['serial_number'] ?? '';

if ($serial_number) {
    $updateResult = $db->phones->updateOne(
        ['serial_number' => $serial_number],
        ['$set' => ['status' => 'Missing']]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["success" => true, "message" => "Phone marked as missing."]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to update phone status."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid serial number."]);
}
