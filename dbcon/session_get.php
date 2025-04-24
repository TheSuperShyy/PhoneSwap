<?php
if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "error" => "User not authenticated."]);
    exit;
}

$userdetails = $_SESSION["user"];
$details = $db->users->findOne(["username" => $userdetails['username']]);

if (!$details) {
    echo json_encode(["success" => false, "error" => "User not found."]);
    exit;
}

// Common info
$userId = $details['_id'] ?? null;
$hfId = $details['hfId'] ?? null;
$userName = trim(($details['first_name'] ?? '') . ' ' . ($details['last_name'] ?? ''));
$userRole = $details['userType'] ?? '';
$userStatus = $details['status'] ?? '';
$phones = $details['assigned_phone'] ?? [];

$assignedPhones = [];
$teamMembers = []; // To store hfId values of the Team Members
if ($userRole === 'TL') {
    $teamMembers = $details['team_members'] ?? []; // Get the team_members from TL
    $phones = $details['assigned_phone'] ?? []; // Get the assigned phones from TL
    $assignedPhones = $phones; // It's already an array of serial numbers

}

// Fetch only Team Members assigned to this TL
if ($userRole === 'TL') {
    $teamMembersList = $db->users->find([
        'hfId' => ['$in' => $teamMembers], // Filter based on the hfId in the team_members array
        'userType' => 'TM' // Ensure only Team Members are shown
    ]);
} elseif ($userRole === 'admin') {
    $teamMembersList = $db->users->find(['userType' => 'TM']); // Admin sees all Team Members
}
?>
