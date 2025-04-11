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

$assignedPhones = [];
$teamMembers = []; // To store hfId values of the Team Members
if ($userRole === 'TL') {
    $assignedPhones = $details['assigned_phone'] ?? [];
    $teamMembers = $details['team_members'] ?? []; // Fetch team members (TMs under TL)
}

// Fetch the phones from the database
$phones = $db->phones->find(["serial_number" => ['$in' => $assignedPhones]]);


?>