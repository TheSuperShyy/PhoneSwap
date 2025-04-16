<?php
session_start();
require '../../dbcon/dbcon.php';
require '../../dbcon/session_get.php'; // 👈 This gives us $userName or $userdetails['username']
header('Content-Type: application/json');

// Get the POST data
$data = json_decode(file_get_contents("php://input"), true);
$oldSerial = $data['old_serial'] ?? null;
$newSerial = $data['new_serial'] ?? null;
$assignedTo = $data['assigned_to'] ?? null;

if (!$oldSerial || !$newSerial || !$assignedTo) {
  echo json_encode(["success" => false, "message" => "Missing swap details."]);
  exit;
}

// Split full name
$nameParts = explode(' ', $assignedTo);
$firstName = $nameParts[0] ?? '';
$lastName = isset($nameParts[1]) ? $nameParts[1] : '';

// Find the user
$user = $db->users->findOne([
    'userType' => 'TM',
    'first_name' => $firstName,
    'last_name' => $lastName
]);

if (!$user) {
  echo json_encode(["success" => false, "message" => "User not found."]);
  exit;
}

// Remove old phone
$result = $db->users->updateOne(
  ['hfId' => $user['hfId']],
  ['$pull' => ['assigned_phone' => $oldSerial]]
);

if ($result->getModifiedCount() === 0) {
  echo json_encode(["success" => false, "message" => "Failed to remove the old phone."]);
  exit;
}

// Add new phone
$result = $db->users->updateOne(
  ['hfId' => $user['hfId']],
  ['$addToSet' => ['assigned_phone' => $newSerial]]
);

// Format timestamp in PH time and 12-hour format
date_default_timezone_set('Asia/Manila');
$timestampPH = date('F j, Y g:i A');

// Insert audit log to 'phone_swap_audit'
if ($result->getModifiedCount() > 0) {
  $db->phone_swap_audit->insertOne([
    'action' => 'swap_phone',
    'timestamp' => $timestampPH,
    'performed_by' => '['. $hfId .'] '. $userName  ?? 'Unknown', // 👈 now this should work
    'details' => [
      'user' => $assignedTo,
      'old_serial' => $oldSerial,
      'new_serial' => $newSerial
    ]
  ]);

  echo json_encode(["success" => true, "message" => "Phone swap successful!"]);
} else {
  echo json_encode(["success" => false, "message" => "Phone swap failed."]);
}
?>
