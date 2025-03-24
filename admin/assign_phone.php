<?php
require __DIR__ . '/../dbcon/dbcon.php';

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
    $phoneCollection = $db->phones;  // Access the 'phone' collection
    $userCollection = $db->users;   // Access the 'users' collection

    // ✅ Step 1: Check if the phone exists
    $phone = $phoneCollection->findOne(["serial_number" => $serialNumber]);

    if (!$phone) {
        echo json_encode(["success" => false, "message" => "Phone not found."]);
        exit;
    }

    // ✅ Step 2: Prevent assigning if the phone is missing
    if ($phone['status'] === 'Missing') {
        echo json_encode(["success" => false, "message" => "Cannot assign a missing phone."]);
        exit;
    }

    // ✅ Step 3: Find the previous TL who has this phone
    $previousOwner = $userCollection->findOne(["assigned_phone" => $serialNumber]);

    if ($previousOwner) {
        // ✅ Step 4: Remove the phone from the previous TL's assigned_phone array
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

    // ✅ Step 5: Assign the phone to the new TL
    $updateResult = $userCollection->updateOne(
        ["hfId" => $hfId], 
        ['$addToSet' => ["assigned_phone" => $serialNumber]]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["success" => true, "message" => "Phone successfully reassigned."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to assign phone."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>
