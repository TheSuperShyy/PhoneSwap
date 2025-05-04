<?php
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../dbcon/dbcon.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="assigned_phones.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Model', 'Serial Number', 'Status', 'Assigned To']);

// Check if the user is authenticated and is a TL
$loggedInUser = $_SESSION['user'] ?? null;

if (!$loggedInUser || $loggedInUser['userType'] !== 'TL') {
    fputcsv($output, ['Error: Not authenticated or not a Team Lead']);
    fclose($output);
    exit;
}

// Fetch full TL user document from the database
$tlDetails = $db->users->findOne(["username" => $loggedInUser['username']]);
if (!$tlDetails) {
    fputcsv($output, ['Error: TL user record not found']);
    fclose($output);
    exit;
}

// Get assigned phone serial numbers and team members from TL document
$assignedPhones = $tlDetails['assigned_phone'] ?? [];
$teamMembers = $tlDetails['team_members'] ?? [];

if (empty($assignedPhones)) {
    fputcsv($output, ['Error: No assigned phones found']);
    fclose($output);
    exit;
}

foreach ($assignedPhones as $serial) {
    $phone = $db->phones->findOne(['serial_number' => $serial]);
    if (!$phone) continue;

    // Check if the phone is assigned to a TM under this TL
    $assignedUser = $db->users->findOne([
        "assigned_phone" => $serial,
        "userType" => "TM",
        "hfId" => ['$in' => $teamMembers]
    ]);

    $assignedTo = $assignedUser
        ? '[' . $assignedUser['hfId'] . '] ' . $assignedUser['first_name'] . ' ' . $assignedUser['last_name']
        : 'Unassigned';

    fputcsv($output, [
        $phone['model'] ?? '',
        $serial,
        $phone['status'] ?? '',
        $assignedTo
    ]);
}

fclose($output);
exit;
?>
