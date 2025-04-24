<?php
session_start();
require '../../dbcon/dbcon.php';
require '../../dbcon/session_get.php';
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

// Find the TM user
$tmUser = $db->users->findOne([
    'userType' => 'TM',
    'first_name' => $firstName,
    'last_name' => $lastName
]);

if (!$tmUser) {
  echo json_encode(["success" => false, "message" => "TM user not found."]);
  exit;
}

// Find the TL user from session
$tlUser = $db->users->findOne([
    'hfId' => $hfId,
    'userType' => 'TL'
]);

if (!$tlUser) {
  echo json_encode(["success" => false, "message" => "TL user not found."]);
  exit;
}

// Remove old phone from TM
$db->users->updateOne(
  ['hfId' => $tmUser['hfId']],
  ['$pull' => ['assigned_phone' => $oldSerial]]
);

// Remove old phone from TL
$db->users->updateOne(
  ['hfId' => $tlUser['hfId']],
  ['$pull' => ['assigned_phone' => $oldSerial]]
);

// Add new phone to TM
$db->users->updateOne(
  ['hfId' => $tmUser['hfId']],
  ['$addToSet' => ['assigned_phone' => $newSerial]]
);

// Add new phone to TL
$db->users->updateOne(
  ['hfId' => $tlUser['hfId']],
  ['$addToSet' => ['assigned_phone' => $newSerial]]
);

// Format timestamp in PH time and 12-hour format
date_default_timezone_set('Asia/Manila');
$timestampPH = date('F j, Y g:i A');

// Insert audit log to 'phone_swap_audit'
$db->phone_swap_audit->insertOne([
  'action' => 'swap_phone',
  'timestamp' => $timestampPH,
  'performed_by' => '['. $hfId .'] '. $userName ?? 'Unknown',
  'details' => [
    'user' => $assignedTo,
    'old_serial' => $oldSerial,
    'new_serial' => $newSerial
  ]
]);

echo json_encode(["success" => true, "message" => "Phone swap successful!"]);
?>
