<?php
require_once '../../dbcon/dbcon.php';
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
header('Content-Type: application/json');

try {
    // Read raw JSON from body
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if (!isset($data['serial_number'])) {
        echo json_encode(['success' => false, 'error' => 'Serial number is missing.']);
        exit;
    }

    $serial = $data['serial_number'];
    $currentUser = $_SESSION['hfId'] ?? 'Unknown';

    // Find the phone
    $phone = $db->phones->findOne(['serial_number' => $serial]);

    if (!$phone) {
        echo json_encode(['success' => false, 'error' => 'Phone not found.']);
        exit;
    }

    // Update status
    $db->phones->updateOne(
        ['serial_number' => $serial],
        ['$set' => ['status' => 'Missing']]
    );

    // Add to audit trail
    $db->audit->insertOne([
        'action' => 'Marked as Missing',
        'serial_number' => $serial,
        'performed_by' => $currentUser,
        'timestamp' => new MongoDB\BSON\UTCDateTime()
    ]);

    // Compose the email
    $message = "<strong>🚨 A phone has been marked as MISSING!</strong><br><br>";
    $message .= "📱 <strong>Serial:</strong> {$phone['serial_number']}<br>";
    $message .= "📱 <strong>Model:</strong> {$phone['model']}<br>";
    $message .= "🧑 <strong>Handler:</strong> {$currentUser}<br><br>";

    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;

        $mail->setFrom(SMTP_FROM, 'Missing Phone Notifier');
        $mail->addAddress('2021307932@dhvsu.edu.ph', 'Admin');

        $mail->isHTML(true);
        $mail->Subject = '📢 Phone Marked as Missing';
        $mail->Body = $message;

        $mail->send();
    } catch (Exception $e) {
        error_log("Email Error: " . $mail->ErrorInfo);
        // Don't fail the whole process if email fails — just log it
    }

    echo json_encode(['success' => true, 'message' => 'Phone marked as missing.']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error: ' . $e->getMessage()]);
}
