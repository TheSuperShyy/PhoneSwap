<?php
require __DIR__ . '/../../dbcon/dbcon.php';
header("Content-Type: application/json");

try {
    $auditCollection = $db->phone_audit;
    $auditLogs = $auditCollection->find([], ['sort' => ['timestamp' => -1]]); // Sort by latest first

    $logs = [];
    foreach ($auditLogs as $log) {
        $logs[] = [
            'date' => isset($log['timestamp']) ? date("Y-m-d h:i:s A", strtotime($log['timestamp'])) : "N/A",
            'user' => isset($log['user']['hfId'], $log['user']['name'])
                ? "(" . $log['user']['hfId'] . ") " . $log['user']['name']
                : "Unknown",
            'serial_number' => isset($log['serial_number']) ? $log['serial_number'] : "Unknown",
            'model' => isset($log['model']) ? $log['model'] : "Unknown",
            'action' => isset($log['action']) ? $log['action'] : "Unknown"
        ];
    }

    echo json_encode(["success" => true, "data" => $logs]);
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage()); // ✅ Logs error instead of breaking JSON
    echo json_encode(["success" => false, "message" => "Database error occurred."]);
}
?>