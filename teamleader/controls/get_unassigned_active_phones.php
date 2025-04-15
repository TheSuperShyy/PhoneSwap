<?php
require_once '../../dbcon/dbcon.php';

header('Content-Type: application/json');

// Get POST body
$input = json_decode(file_get_contents('php://input'), true);
$teamMembers = $input['teamMembers'] ?? [];

if (empty($teamMembers)) {
  echo json_encode([]);
  exit;
}

// Find assigned phones by those team members
$assignedPhones = $db->users->distinct('assigned_phone', [
  'hfId' => ['$in' => $teamMembers],
  'assigned_phone' => ['$ne' => null]
]);

// Get phones that are active AND not currently assigned to any TM under this TL
$unassignedPhones = $db->phones->find([
  'status' => 'Active',
  'serial_number' => ['$nin' => $assignedPhones]
]);

$response = [];
foreach ($unassignedPhones as $phone) {
  $response[] = [
    'serial_number' => $phone['serial_number'],
    'model' => $phone['model']
  ];
}

echo json_encode($response);
