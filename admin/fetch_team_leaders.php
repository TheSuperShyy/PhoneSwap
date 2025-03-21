<?php
require __DIR__ . '/../dbcon/dbcon.php';
require __DIR__ . '/../queries/phone_query.php';

header('Content-Type: application/json');

try {
    $teamLeaders = $db->users->find(['userType' => 'TL']);

    if (!$teamLeaders) {
        echo json_encode(['success' => false, 'message' => 'No Team Leaders found']);
        exit;
    }

    $tlArray = [];
    foreach ($teamLeaders as $tl) {
        $formattedName = "({$tl['hfId']}) {$tl['first_name']} {$tl['last_name']}";
        $tlArray[] = ['hfId' => $tl['hfId'], 'formattedName' => $formattedName];
    }

    echo json_encode($tlArray);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
