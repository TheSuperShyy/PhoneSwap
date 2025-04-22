<?php
require __DIR__ . '/../../dbcon/dbcon.php';
session_start();
require '../../dbcon/session_get.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $firstName = trim($data['first_name'] ?? '');
    $lastName = trim($data['last_name'] ?? '');
    $hfId = trim($data['hf_id'] ?? '');
    $role = trim($data['role'] ?? '');
    $email = trim($data['username'] ?? '');

    if ($firstName && $lastName && $hfId && $role && $email) {
        $userData = [
            'hfId' => $hfId,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $email,
            'userType' => $role,
            'assigned_phone' => [],
        ];

        // Insert the new user
        $insertResult = $usersCollection->insertOne($userData);

        // If the new user is a TM, link them to the TL
        if ($role === 'TM' && isset($_SESSION['user']['hfId'])) {
            $creatorHfId = $_SESSION['user']['hfId'];

            $tlAccount = $usersCollection->findOne(['hfId' => $creatorHfId, 'userType' => 'TL']);
            if (!$tlAccount) {
                echo json_encode(['success' => false, 'message' => 'TL not found in database.']);
                exit;
            }

            // Link TM to the TL
            $updateResult = $usersCollection->updateOne(
                ['hfId' => $creatorHfId],
                ['$push' => ['team_members' => $hfId]]
            );

            if ($updateResult->getModifiedCount() === 0) {
                echo json_encode(['success' => false, 'message' => 'TM created but not linked to TL.']);
                exit;
            }
        }

        echo json_encode(['success' => true, 'message' => 'User added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>