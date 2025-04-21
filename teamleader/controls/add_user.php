<?php
require __DIR__ . '/../../dbcon/dbcon.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $firstName = trim($data['first_name'] ?? '');
    $lastName = trim($data['last_name'] ?? '');
    $hfId = trim($data['hf_id'] ?? '');
    $role = trim($data['role'] ?? '');

    if ($firstName && $lastName && $hfId && $role) {
        $userData = [
            'hfId' => $hfId,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $firstName . ' ' . $lastName, // Optional: full name
            'userType' => $role,
            'assigned_phone' => [],
        ];

        if ($role !== 'TM') {
            $userData['password'] = null;
            $userData['status'] = null;
        }

        $insertResult = $usersCollection->insertOne($userData);

        if ($role === 'TM' && isset($_SESSION['hfId'])) {
            $creatorHfId = $_SESSION['hfId'];
            $updateResult = $usersCollection->updateOne(
                ['hfId' => $creatorHfId, 'userType' => 'TL'],
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
