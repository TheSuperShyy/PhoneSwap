<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/mail_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');
session_start();

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $collection = $db->users;
        $auditCollection = $db->user_audit;

        $data = json_decode(file_get_contents("php://input"), true);

        $firstName = $data['first_name'] ?? '';
        $lastName = $data['last_name'] ?? '';
        $username = $data['username'] ?? '';
        $hfId = $data['hfId'] ?? '';
        $role = $data['userType'] ?? '';

        if (empty($firstName) || empty($lastName) || empty($username) || empty($hfId) || empty($role)) {
            echo json_encode(["success" => false, "message" => "All fields are required."]);
            exit;
        }

        // Check if HFID or username already exists
        $existingUser = $collection->findOne([
            '$or' => [
                ["hfId" => $hfId],
                ["username" => $username]
            ]
        ]);

        if ($existingUser) {
            echo json_encode(["success" => false, "message" => "HFID or username already exists."]);
            exit;
        }

        // Generate a unique token for password setup
        $token = bin2hex(random_bytes(32));

        // Insert new user
        $newUser = [
            "hfId" => $hfId,
            "username" => $username,
            "first_name" => $firstName,
            "last_name" => $lastName,
            "userType" => $role,
            "assigned_phone" => [],
            "status" => null,
            "created_at" => date("Y-m-d h:i:s A"),
            "reset_token" => $token,
            "reset_expires" => time() + 3600
        ];

        if ($role === "TL") {
            $newUser["team_members"] = [];
        }

        $collection->insertOne($newUser);

        // Get admin details from session
        $adminId = $_SESSION['user']['hfId'] ?? 'Unknown ID';
        $adminName = ($_SESSION['user']['first_name'] ?? 'Unknown') . ' ' . ($_SESSION['user']['last_name'] ?? '');

        // Insert audit log
        $auditCollection->insertOne([
            "timestamp" => date("Y-m-d H:i:s"),
            "user" => [
                "hfId" => $adminId,
                "name" => $adminName,
            ],
            "action" => "Added User",
            "details" => [
                "hfId" => $hfId,
                "username" => $username,
                "first_name" => $firstName,
                "last_name" => $lastName,
                "userType" => $role
            ]
        ]);

        $mail = new PHPMailer(true);
        try {
            // Use Gmail's SMTP server settings
            $mail->isSMTP();
            $mail->Host = SMTP_HOST; // SMTP server (e.g., 'smtp.gmail.com')
            $mail->SMTPAuth = true;  // Enable authentication
            $mail->Username = SMTP_USER; // Your Gmail email address
            $mail->Password = SMTP_PASS; // Your app-specific password or Gmail password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // StartTLS for secure connection
            $mail->Port = SMTP_PORT;  // Use port 587 for TLS

            $mail->setFrom(SMTP_FROM, 'Admin');
            $mail->addAddress($username, $firstName . ' ' . $lastName); // Add recipient email

            $mail->isHTML(true);
            $mail->Subject = "Set Your Password";
            $mail->Body = "
        <div style='background-color:#f4f4f4;padding:20px;'>
            <div style='max-width:600px;margin:0 auto;background:white;padding:20px;border-radius:10px;'>
                <h2 style='color:#333;'>Welcome, $firstName!</h2>
                <p>You have been added as a <strong>$role</strong> in our system.</p>
                <p>Click the button below to set your password:</p>
                <a href='http://localhost/phoneswap/PhoneSwap/src/set-password.php?token=$token' 
                    style='display:inline-block;padding:10px 20px;background-color:#007bff;color:#fff;text-decoration:none;border-radius:5px;'>
                    Set Password
                </a>
                <p style='margin-top:15px;'>This link will expire in 1 hour.</p>
            </div>
        </div>
    ";

            // Disable debugging for production
            $mail->SMTPDebug = 0; // No debugging output

            $mail->send();
            echo json_encode(["success" => true, "message" => "User added successfully and email sent."]);
        } catch (Exception $e) {
            // If the mail fails, return the error in the response
            echo json_encode(["success" => false, "message" => "User added, but email not sent: " . $mail->ErrorInfo]);
            exit;
        }

    } else {
        echo json_encode(["success" => false, "message" => "Invalid request."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>
