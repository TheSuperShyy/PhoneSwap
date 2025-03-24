<?php
require __DIR__ . '/../dbcon/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $serial_number = $_POST['serial_number'] ?? '';
    $status = $_POST['status'] ?? '';

    if (!empty($serial_number) && !empty($status)) {
        $db->phones->updateOne(
            ['serial_number' => $serial_number],
            ['$set' => ['status' => $status]]
        );
        header("Location: dashboard.php?success=Phone status updated");
        exit();
    } else {
        header("Location: dashboard.php?error=Please select a phone and status");
        exit();
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>
