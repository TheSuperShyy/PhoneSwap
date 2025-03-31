<?php
require __DIR__ . '/../../dbcon/dbcon.php';
header("Content-Type: application/json");

try {
    $auditCollection = $db->user_audit;
    
    // ✅ Sort by latest timestamp first
    $auditLogs = $auditCollection->find([], ['sort' => ['timestamp' => -1]]);

    $logs = [];
    foreach ($auditLogs as $log) {
        $logs[] = [
            'date' => isset($log['timestamp']) ? date("Y-m-d h:i:s A", strtotime($log['timestamp'])) : "N/A",
            'user' => isset($log['user']['hfId'], $log['user']['name'])
                ? "(" . $log['user']['hfId'] . ") " . $log['user']['name']
                : "Unknown",
            'action' => $log['action'] ?? "Unknown",
            'details' => isset($log['details'])
                ? json_encode($log['details'])
                : "No details"
        ];
    }

    echo json_encode(["success" => true, "data" => $logs]);
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage()); // ✅ Logs error instead of breaking JSON
    echo json_encode(["success" => false, "message" => "Database error occurred."]);
}
?>
