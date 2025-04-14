<?php
require '../../dbcon/dbcon.php'; 
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['phones']) || !is_array($data['phones'])) {
  echo json_encode(['success' => false, 'message' => 'No phones provided.']);
  exit;
}

$phonesToReturn = $data['phones'];
$errors = [];

foreach ($phonesToReturn as $serial) {
  // Find the Team Member who currently has this phone
  $user = $db->users->findOne([
    "userType" => "TM",
    "assigned_phone" => $serial
  ]);

  if (!$user) {
    $errors[] = "No TM found with phone: $serial";
    continue;
  }

  // Remove the phone from the assigned_phone array
  $updateResult = $db->users->updateOne(
    ["hfId" => $user['hfId']],
    ['$pull' => ["assigned_phone" => $serial]]
  );

  // Log return in audit (optional)
  $db->audit->insertOne([
    "action" => "Return Phone",
    "serial_number" => $serial,
    "returned_from" => $user['hfId'],
    "timestamp" => new MongoDB\BSON\UTCDateTime()
  ]);

  if ($updateResult->getModifiedCount() === 0) {
    $errors[] = "Failed to return phone: $serial";
  }
}

if (!empty($errors)) {
  echo json_encode(['success' => false, 'message' => implode(", ", $errors)]);
} else {
  echo json_encode(['success' => true]);
}
