<?php
require __DIR__ . '/../../dbcon/dbcon.php'; // Include DB connection

// Start session and check authentication
session_start();
header("Content-Type: application/json"); // Ensure the response is in JSON format

// Check if the user is authenticated
if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "User not authenticated."]);
    exit;
}

$userdetails = $_SESSION["user"];
$hfId = $userdetails['hfId'] ?? null; // Get the hfId of the logged-in TL

// Check if hfId is available
if (!$hfId) {
    echo json_encode(["success" => false, "message" => "Invalid user."]);
    exit;
}

// Fetch Team Leader details
$teamLeader = $db->users->findOne(["hfId" => $hfId, "userType" => "TL"]);

if (!$teamLeader || !isset($teamLeader['team_members'])) {
    echo json_encode(["success" => false, "message" => "No team members found for this Team Leader."]);
    exit;
}

// Extract team members' hfId from the `team_members` array field
$teamMemberHfIds = $teamLeader['team_members'] ?? [];

// If there are no team members, return an empty response
if (empty($teamMemberHfIds)) {
    echo json_encode(["success" => false, "message" => "No team members found."]);
    exit;
}

// Fetch details of all team members using their hfIds
$teamMembers = $db->users->find([
    'hfId' => ['$in' => $teamMemberHfIds],
    'userType' => 'TM'  // Ensure these are only Team Members (TM)
]);

// Check if we have team members
if ($teamMembers) {
    $data = iterator_to_array($teamMembers); // Convert MongoDB result to an array
    echo json_encode(["success" => true, "data" => $data]); // Return success and the team members
} else {
    echo json_encode(["success" => false, "message" => "No team members found."]);
}
?>
