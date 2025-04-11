<?php
require __DIR__ . '/../../dbcon/dbcon.php';

header("Content-Type: application/json");

// Read JSON request
$data = json_decode(file_get_contents("php://input"), true);

// Check if request is received properly
if (!$data) {
    echo json_encode(["success" => false, "error" => "Invalid JSON data"]);
    exit;
}

// Validate input
if (!isset($data['serial_number']) || !isset($data['TM'])) {
    echo json_encode(["success" => false, "error" => "Missing required fields"]);
    exit;
} elseif ($data['serial_number'] == "Select Serial Number" || $data['TM'] == "Select Team Member") {
    echo json_encode(["success" => false, "error" => "Empty required fields"]);
    exit;
}

$serialNumber = $data['serial_number'];
$teamMember = $data['TM']; // This should be the hfId of the TM

try {
    // Fetch the team member's data
    $tmData = $db->users->findOne(["hfId" => $teamMember]);

    if (!$tmData) {
        echo json_encode(["success" => false, "error" => "Team Member not found."]);
        exit;
    }

    // Convert assigned_phone to PHP array
    $assignedPhones = isset($tmData['assigned_phone']) ? iterator_to_array($tmData['assigned_phone']) : [];

    // Check if the action is to unassign
    if ($serialNumber === "unassigned") {
        // Check if the phone is assigned
        if (!in_array($serialNumber, $assignedPhones)) {
            echo json_encode(["success" => false, "error" => "Phone not assigned to this user."]);
            exit;
        }

        // Remove the phone from the assigned_phone array (unassign)
        $updateResult = $db->users->updateOne(
            ["hfId" => $teamMember], 
            ['$pull' => ["assigned_phone" => $serialNumber]] // Pull the phone out of the array
        );

        if ($updateResult->getModifiedCount() > 0) {
            echo json_encode(["success" => true, "message" => "Phone successfully unassigned from team member."]);
        } else {
            echo json_encode(["success" => false, "error" => "Phone wasn't assigned to unassign."]);
        }
    } else {
        // Check if the phone is already assigned
        if (in_array($serialNumber, $assignedPhones)) {
            echo json_encode(["success" => false, "error" => "Phone is already assigned to this user."]);
            exit;
        }

        // Add the phone to the team member's assigned_phone array (assign)
        $updateResult = $db->users->updateOne(
            ["hfId" => $teamMember], 
            ['$push' => ["assigned_phone" => $serialNumber]] // Push the phone into the array
        );

        if ($updateResult->getModifiedCount() > 0) {
            echo json_encode(["success" => true, "message" => "Phone successfully assigned to team member."]);
        } else {
            echo json_encode(["success" => false, "error" => "No record updated."]);
        }
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
