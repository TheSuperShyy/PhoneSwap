<?php
require __DIR__ . '/../../dbcon/dbcon.php';

header('Content-Type: application/json');

session_start(); // Ensure session is started to track admin details

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $collection = $db->users;
        $auditCollection = $db->user_audit;

        // Read JSON input
        $data = json_decode(file_get_contents("php://input"), true);

        $firstName = $data['first_name'] ?? '';
        $lastName = $data['last_name'] ?? '';
        $username = $data['username'] ?? ''; 
        $hfId = $data['hfId'] ?? '';
        $role = $data['userType'] ?? 'TL';

        if (empty($firstName) || empty($lastName) || empty($username) || empty($hfId)) {
            echo json_encode(["success" => false, "message" => "All fields are required."]);
            exit;
        }

        // Check if HFID or username already exists
        $existingUser = $collection->findOne([
            '$or' => [
                ["hfId" => $hfId],
                ["username" => $username]
            ]
        ]);

        if ($existingUser) {
            echo json_encode(["success" => false, "message" => "HFID or username already exists."]);
            exit;
        }

        // Insert new user
        $newUser = [
            "hfId" => $hfId,
            "username" => $username,
            "first_name" => $firstName,
            "last_name" => $lastName,
            "userType" => $role,
            "assigned_phone" => [],
            "status" => null,
            "created_at" => date("Y-m-d h:i:s A"),
        ];

        // Only add 'team_members' field if the user is a TL
        if ($role === "TL") {
            $newUser["team_members"] = [];
        }

        $collection->insertOne($newUser);

        // Get admin details from session
        $adminId = $_SESSION['user']['hfId'] ?? 'Unknown ID';
        $adminName = ($_SESSION['user']['first_name'] ?? 'Unknown') . ' ' . ($_SESSION['user']['last_name'] ?? '');

        // Insert audit log
        $auditData = [
            "timestamp" => date("Y-m-d H:i:s"),
            "user" => [
                "hfId" => $adminId,
                "name" => $adminName,
            ],
            "action" => "Added User",
            "details" => [
                "hfId" => $hfId,
                "username" => $username,
                "first_name" => $firstName,
                "last_name" => $lastName,
                "userType" => $role
            ]
        ];

        $auditCollection->insertOne($auditData);

        echo json_encode(["success" => true, "message" => "User added successfully and logged in audit."]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>
