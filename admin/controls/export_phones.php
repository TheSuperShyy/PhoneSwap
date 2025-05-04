<?php
require __DIR__ . '/../../dbcon/dbcon.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="phones_export.csv"');

$output = fopen('php://output', 'w');

// Write the header row
fputcsv($output, ['Model', 'Serial Number', 'Status', 'Created At']);

// Fetch data from MongoDB
$cursor = $phonesCollection->find();

foreach ($cursor as $doc) {
    fputcsv($output, [
        $doc['model'] ?? '',
        $doc['serial_number'] ?? '',
        $doc['status'] ?? '',
        isset($doc['created_at']) ? $doc['created_at']->toDateTime()->format('Y-m-d H:i:s') : ''
    ]);
}

fclose($output);
exit;
?>