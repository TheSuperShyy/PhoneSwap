<?php
require __DIR__ . '/../../dbcon/dbcon.php';
session_start();
require '../../dbcon/session_get.php';

$data = json_decode(file_get_contents("php://input"), true);

$hfId = $data['hfId'] ?? '';

if (!$hfId) {
    echo json_encode(['success' => false, 'message' => 'Missing user ID']);
    exit;
}

// Optional: Only allow TLs to delete TMs
$currentUser = $_SESSION['user'] ?? null;
if (!$currentUser || $currentUser['userType'] !== 'TL') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Delete the user
$deleteResult = $usersCollection->deleteOne(['hfId' => $hfId]);

if ($deleteResult->getDeletedCount() > 0) {
    // Optional: Remove TM from TL's `team_members` array if they were linked
    $usersCollection->updateOne(
        ['hfId' => $currentUser['hfId']],
        ['$pull' => ['team_members' => $hfId]]
    );

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not found or already deleted']);
}
