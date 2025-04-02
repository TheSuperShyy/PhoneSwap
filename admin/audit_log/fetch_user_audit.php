<?php
require __DIR__ . '/../../dbcon/dbcon.php';
header("Content-Type: application/json");

try {
    $auditCollection = $db->user_audit;

    // ✅ Sort by latest timestamp first
    $auditLogs = $auditCollection->find([], ['sort' => ['timestamp' => -1]]);

    $logs = [];
    foreach ($auditLogs as $log) {
        // Format the date
        $formattedDate = isset($log['timestamp']) ? date("Y-m-d h:i:s A", strtotime($log['timestamp'])) : "N/A";

        // Format the user field (hfId and name)
        $userDetails = isset($log['user']['hfId'], $log['user']['name'])
            ? "(" . $log['user']['hfId'] . ") " . $log['user']['name']
            : "Unknown";

        // Format the action (if available)
        $action = $log['action'] ?? "Unknown";

        // Format the details field
        $details = isset($log['details'])
            ? "(" . $log['details']['hfId'] . ") " . $log['details']['first_name'] . " " . $log['details']['last_name'] . " - " . $log['details']['userType']
            : "No details";

        // Append the formatted log
        $logs[] = [
            'date' => $formattedDate,
            'user' => "Updated by: " . $userDetails,
            'action' => $action,
            'details' => $details
        ];
    }

    echo json_encode(["success" => true, "data" => $logs]);
}
catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

?>
