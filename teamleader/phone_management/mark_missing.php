<?php
ob_start(); // Start output buffering
session_start();
header('Content-Type: application/json');

require_once '../../dbcon/dbcon.php';
require_once '../../dbcon/mail_config.php';
require '../../vendor/autoload.php';
require __DIR__ . '/../../dbcon/session_get.php';

// OPTIONAL: Include your SMTP config file if constants are not defined in autoload
// require_once '../../config/smtp_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    // Read and parse JSON input
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if (!isset($data['serial_number'])) {
        ob_end_clean();
        echo json_encode(['success' => false, 'error' => 'Serial number is missing.']);
        exit;
    }

    $serial = $data['serial_number'];
    $currentUser = isset($hfId, $userName) ? "{$hfId} - {$userName}" : 'Unknown';


    // Fetch phone from database
    $phone = $db->phones->findOne(['serial_number' => $serial]);

    if (!$phone) {
        ob_end_clean();
        echo json_encode(['success' => false, 'error' => 'Phone not found.']);
        exit;
    }

    // Update phone status
    $db->phones->updateOne(
        ['serial_number' => $serial],
        ['$set' => ['status' => 'Missing']]
    );

    // Add to audit log
    $db->audit->insertOne([
        'action' => 'Marked as Missing',
        'serial_number' => $serial,
        'performed_by' => $currentUser,
        'timestamp' => new MongoDB\BSON\UTCDateTime()
    ]);

    // Ensure SMTP constants are defined
    if (!defined('SMTP_HOST') || !defined('SMTP_USER') || !defined('SMTP_PASS') || !defined('SMTP_PORT') || !defined('SMTP_FROM')) {
        throw new Exception("SMTP configuration is missing.");
    }

    // Email content
    $message = "<strong>A phone has been marked as MISSING!</strong><br><br>";
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
        $mail->addAddress('johngilbertabella08@gmail.com', 'Admin');

        $mail->isHTML(true);
        $mail->Subject = '📢 Phone Marked as Missing';
        $mail->Body = $message;

        $mail->send();
    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $mail->ErrorInfo);
        // Optional: file_put_contents('mail_debug.log', $mail->ErrorInfo);
    }

    ob_end_clean();
    echo json_encode(['success' => true, 'message' => 'Phone marked as missing.']);

} catch (Exception $e) {
    ob_end_clean();
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error: ' . $e->getMessage()]);
}
