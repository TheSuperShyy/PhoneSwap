<?php
require __DIR__ . '/../../dbcon/dbcon.php'; // Include DB connection

header("Content-Type: application/json"); // JSON response

// Fetch all users who are Team Leaders (TL)
$teamLeadersCursor = $db->users->find([
    'userType' => 'TL'
]);

$teamLeaders = iterator_to_array($teamLeadersCursor);

if ($teamLeaders) {
    // Format and return relevant fields
    $data = array_map(function($tl) {
        return [
            'hfId' => $tl['hfId'],
            'first_name' => $tl['first_name'] ?? '',
            'last_name' => $tl['last_name'] ?? '',
        ];
    }, $teamLeaders);

    echo json_encode(["success" => true, "data" => $data]);
} else {
    echo json_encode(["success" => false, "message" => "No team leaders found."]);
}
?>
