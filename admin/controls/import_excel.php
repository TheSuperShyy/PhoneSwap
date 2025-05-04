<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../queries/SimpleXLSX.php';

use Shuchkin\SimpleXLSX;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $fileTmpPath = $_FILES['excel_file']['tmp_name'];

    if ($xlsx = SimpleXLSX::parse($fileTmpPath)) {
        $rows = $xlsx->rows();
        $header = array_map('strtolower', array_map('trim', array_shift($rows))); // normalize header

        $modelIndex = array_search('model', $header);
        $serialIndex = array_search('serial number', $header);
        $statusIndex = array_search('status', $header);

        if ($modelIndex === false || $serialIndex === false || $statusIndex === false) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Missing required headers: model, serial number, or status.'
            ]);
            exit;
        }

        $inserted = 0;
        $fileSerials = [];

        foreach ($rows as $row) {
            $model = $row[$modelIndex] ?? '';
            $serial = $row[$serialIndex] ?? '';
            $status = $row[$statusIndex] ?? '';

            $serial = trim($serial);

            if (empty($serial)) continue;

            // Prevent duplicates within the same file
            if (in_array($serial, $fileSerials)) {
                continue;
            }

            // Prevent duplicates from existing MongoDB entries
            $exists = $phonesCollection->findOne(['serial_number' => $serial]);
            if ($exists) {
                continue;
            }

            // Insert into MongoDB
            $phonesCollection->insertOne([
                'model' => $model,
                'serial_number' => $serial,
                'status' => $status,
                'created_at' => new MongoDB\BSON\UTCDateTime()
            ]);
            $inserted++;
            $fileSerials[] = $serial; // Track inserted serials from file
        }

        if ($inserted > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => "Successfully imported $inserted phone(s)."
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No new phones were imported. All serial numbers may already exist or are duplicates.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to parse the Excel file.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No file uploaded.'
    ]);
}
?>
