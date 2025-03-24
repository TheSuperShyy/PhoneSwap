<?php
require __DIR__ . '/../dbcon/dbcon.php';

header('Content-Type: application/json');

try {
    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    $collection = $db->users;

    $teamLeaders = $collection->find(["userType" => "TL"]);
    $result = [];

    foreach ($teamLeaders as $user) {
        $result[] = [
            "hfId" => $user["hfId"] ?? "UNKNOWN",
            "username" => ($user["first_name"] ?? "") . " " . ($user["last_name"] ?? ""),
            "userType" => $user["userType"] ?? "UNKNOWN"
        ];
    }

    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

?>
