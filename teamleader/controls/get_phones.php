<?php
require_once '../../dbcon/dbcon.php';

header('Content-Type: application/json');

$phones = $db->phones->find(); // Fetch all phones

$phoneData = [];
foreach ($phones as $phone) {
    $phoneData[] = [
        'serial_number' => $phone['serial_number'],
        'model' => $phone['model'],
    ];
}

echo json_encode(['success' => true, 'data' => $phoneData]);
?>
