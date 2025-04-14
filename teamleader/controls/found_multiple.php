<?php
require_once '../../dbcon/dbcon.php'; // Include database connection
session_start();

$response = [
    'success' => false,
    'updatedCount' => 0,
    'message' => 'No phones were updated.'
];

if (!empty($_POST['serials'])) {
    // Get the serial numbers from the POST request
    $serials = $_POST['serials'];
    $currentUser = $_SESSION['hfId'] ?? 'Unknown'; // Get the user who is performing the action

    // Update the status of the phones in the database
    try {
        $result = $db->phones->updateMany(
            ['serial_number' => ['$in' => $serials]], // Match serial numbers in the given list
            ['$set' => ['status' => 'Active']] // Change the status to 'Active' (or 'Found')
        );

        // If the update is successful, set success status and count of updated phones
        if ($result->getModifiedCount() > 0) {
            $response['success'] = true;
            $response['updatedCount'] = $result->getModifiedCount();
            
            // Log this action to the audit collection
            foreach ($serials as $serial) {
                $db->audit->insertOne([
                    'action' => 'Marked as Found',
                    'serial_number' => $serial,
                    'performed_by' => $currentUser,
                    'timestamp' => new MongoDB\BSON\UTCDateTime() // Capture the current timestamp
                ]);
            }
        } else {
            $response['message'] = 'No changes were made to the phones.';
        }
    } catch (Exception $e) {
        // In case of any errors, return an error message
        $response['message'] = 'Error occurred: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'No phones selected.';
}

// Return the response as JSON
echo json_encode($response);
?>
