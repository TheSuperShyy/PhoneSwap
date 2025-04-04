<?php
error_log("Started request processing...");

try {
    $data = json_decode(file_get_contents("php://input"), true);
    error_log("Received Data: " . print_r($data, true));

    if (empty($data['userId'])) {
        throw new Exception('User ID is required');
    }

    $userId = $data['userId'];
    $user = $db->users->findOne(["_id" => new MongoDB\BSON\ObjectId($userId)]);

    if (!$user) {
        throw new Exception("User not found.");
    }

    echo json_encode(["success" => true, "user" => $user]);

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
