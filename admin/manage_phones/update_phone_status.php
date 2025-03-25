<?php
require __DIR__ . '/../../dbcon/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["serial_number"]) || !isset($_POST["status"])) {
        header("Location: managephones.php?error=Missing required fields.");
        exit;
    }

    $serialNumber = $_POST["serial_number"];
    $newStatus = $_POST["status"];

    try {
        // ✅ Fetch current status of the phone
        $phone = $db->phones->findOne(["serial_number" => $serialNumber]);

        if (!$phone) {
            header("Location: ../dashboard/managephones.php?error=Phone not found.");
            exit;
        }

        // ✅ Prevent update if the current status is "Missing"
        if ($phone["status"] === "Missing") {
            header("Location: ../dashboard/managephones.php?error=Cannot update. Phone is marked as Missing.");
            exit;
        }

        // ✅ Update phone status in MongoDB
        $updateResult = $db->phones->updateOne(
            ["serial_number" => $serialNumber],
            ['$set' => ["status" => $newStatus]]
        );

        if ($updateResult->getModifiedCount() > 0) {
            // ✅ Redirect with success message
            header("Location: ../dashboard/managephones.php?success=Status updated successfully!");
            exit;
        } else {
            header("Location: ../dashboard/managephones.php?error=No changes made.");
            exit;
        }
    } catch (Exception $e) {
        header("Location: ../dashboard/managephones.php?error=Database error: " . urlencode($e->getMessage()));
        exit;
    }
}
?>
