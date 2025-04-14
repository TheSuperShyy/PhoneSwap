<?php
require_once '../../dbcon/dbcon.php';
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if (!empty($_POST['serials'])) {
  $serials = $_POST['serials'];
  $currentUser = $_SESSION['hfId'] ?? 'Unknown';

  $missingPhones = $db->phone->find([
    'serial_number' => ['$in' => $serials]
  ]);

  $db->phone->updateMany(
    ['serial_number' => ['$in' => $serials]],
    ['$set' => ['status' => 'Missing']]
  );

  foreach ($serials as $serial) {
    $db->audit->insertOne([
      'action' => 'Marked as Missing',
      'serial_number' => $serial,
      'performed_by' => $currentUser,
      'timestamp' => new MongoDB\BSON\UTCDateTime()
    ]);
  }

  // Compose the email message
  $message = "<strong>🚨 A phone has been marked as MISSING!</strong><br><br>";
  foreach ($missingPhones as $phone) {
    $message .= "📱 <strong>Serial:</strong> {$phone['serial_number']}<br>";
    $message .= "📱 <strong>Model:</strong> {$phone['model']}<br>";
    $message .= "🧑 <strong>Handler:</strong> {$currentUser}<br><br>";
  }

  // Send email via SMTP
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

    // You can send to multiple recipients
    $mail->addAddress('admin@example.com', 'Admin');

    $mail->isHTML(true);
    $mail->Subject = '📢 Phone(s) Marked as Missing';
    $mail->Body = $message;

    $mail->send();
  } catch (Exception $e) {
    error_log('Email Error: ' . $mail->ErrorInfo);
  }

  echo json_encode(['success' => true, 'updatedCount' => count($serials)]);
  exit;
} else {
  echo json_encode(['success' => false, 'message' => 'No phones selected.']);
  exit;
}
