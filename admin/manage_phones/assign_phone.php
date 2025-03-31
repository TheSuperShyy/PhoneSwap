<?php
require __DIR__ . '/../../dbcon/dbcon.php';

header('Content-Type: application/json');

// Decode JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate input fields
if (!isset($data['serial_number'], $data['hfId'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields."]);
    exit;
}

$serialNumber = strval($data['serial_number']); // Ensure it's a string
$hfId = strval($data['hfId']);

try {
    $phoneCollection = $db->phones;
    $userCollection = $db->users;
    $phone = $phoneCollection->findOne(["serial_number" => $serialNumber]);

    if (!$phone) {
        echo json_encode(["success" => false, "message" => "Phone not found."]);
        exit;
    }
    if ($phone['status'] === 'Missing') {
        echo json_encode(["success" => false, "message" => "Cannot assign a missing phone."]);
        exit;
    }
    $previousOwner = $userCollection->findOne(["assigned_phone" => $serialNumber]);

    if ($previousOwner) {
        $removeResult = $userCollection->updateOne(
            ["hfId" => $previousOwner['hfId']],
            ['$pull' => ["assigned_phone" => $serialNumber]]
        );

        if ($removeResult->getModifiedCount() > 0) {
            error_log("Phone $serialNumber removed from previous owner " . $previousOwner['hfId']);
        } else {
            error_log("Failed to remove phone $serialNumber from previous owner.");
        }
    }
    if ($hfId === "unassigned") {
        echo json_encode(["success" => true, "message" => "Phone successfully unassigned."]);
        exit;
    }
    $updateResult = $userCollection->updateOne(
        ["hfId" => $hfId],
        ['$addToSet' => ["assigned_phone" => $serialNumber]]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["success" => true, "message" => "Phone successfully assigned."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to assign phone."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
    
?>