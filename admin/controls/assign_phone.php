<?php
require __DIR__ . '/../../dbcon/dbcon.php';

header("Content-Type: application/json");

// Read JSON request
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "error" => "Invalid JSON data"]);
    exit;
}

if (!isset($data['serial_number']) || !isset($data['TM'])) {
    echo json_encode(["success" => false, "error" => "Missing required fields"]);
    exit;
} elseif ($data['serial_number'] == "Select Serial Number" || $data['TM'] == "Select Team Member") {
    echo json_encode(["success" => false, "error" => "Empty required fields"]);
    exit;
}

$serialNumber = $data['serial_number'];
$teamMember = $data['TM'];

try {
    // Fetch the team member's data
    $tmData = $db->users->findOne(["hfId" => $teamMember]);

    if (!$tmData) {
        echo json_encode(["success" => false, "error" => "Team Member not found."]);
        exit;
    }

    // Get the assigned phones (convert BSONArray to regular array)
    $assignedPhones = isset($tmData['assigned_phone']) ? $tmData['assigned_phone']->getArrayCopy() : [];

    if ($serialNumber === "unassigned") {
        if (!in_array($serialNumber, $assignedPhones)) {
            echo json_encode(["success" => false, "error" => "Phone not assigned to this user."]);
            exit;
        }

        $updateResult = $db->users->updateOne(
            ["hfId" => $teamMember], 
            ['$pull' => ["assigned_phone" => $serialNumber]]
        );

        if ($updateResult->getModifiedCount() > 0) {
            echo json_encode(["success" => true, "message" => "Phone successfully unassigned from team member."]);
        } else {
            echo json_encode(["success" => false, "error" => "Phone wasn't assigned to unassign."]);
        }
    } else {
        if (in_array($serialNumber, $assignedPhones)) {
            echo json_encode(["success" => false, "error" => "Phone is already assigned to this user."]);
            exit;
        }

        $updateResult = $db->users->updateOne(
            ["hfId" => $teamMember], 
            ['$push' => ["assigned_phone" => $serialNumber]]
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
