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

            // ✅ Insert new phone into MongoDB
            $insertResult = $phonesCollection->insertOne([
                'model' => $model,
                'serial_number' => $serial,
                'status' => $status,
                'created_at' => new MongoDB\BSON\UTCDateTime()
            ]);

            if ($insertResult->getInsertedCount() > 0) {
                // ✅ Insert audit log
                $adminId = $_SESSION['user']['hfId']; // Assuming the admin's hfId is stored in the session
                $adminName = $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'];

                $auditData = [
                    "timestamp" => date("Y-m-d H:i:s"), // Current timestamp
                    'user' => [
                        'hfId' => $adminId,
                        'name' => $adminName,
                    ],
                    'serial_number' => $serial,
                    'model' => $model,
                    'action' => 'Added New Phone'
                ];

                // Insert audit record
                $db->phone_audit->insertOne($auditData);

                $inserted++;
                $fileSerials[] = $serial; // Track inserted serials from file
            }
        }

        if ($inserted > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => "Successfully imported $inserted phone(s) and logged audit."
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
