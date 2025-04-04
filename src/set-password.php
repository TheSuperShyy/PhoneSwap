<?php
require __DIR__ . '/../dbcon/dbcon.php';
session_start();

$response = []; // Array to store the response for AJAX

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Sanitize input
    $password = trim($password);
    $confirm_password = trim($confirm_password);

    if (empty($password) || empty($confirm_password)) {
        $response['status'] = 'error';
        $response['message'] = 'Both fields are required.';
    } elseif ($password !== $confirm_password) {
        $response['status'] = 'error';
        $response['message'] = 'Passwords do not match.';
    } else {
        // Validate the token
        $user = $db->users->findOne([
            'reset_token' => $token,
            'reset_expires' => ['$gt' => time()]  // Check if token is still valid
        ]);

        if (!$user) {
            $response['status'] = 'error';
            $response['message'] = 'Invalid or expired token. Please check your email for a new link.';
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Update the user's password and status
            $updateResult = $db->users->updateOne(
                ['_id' => $user['_id']],
                [
                    '$set' => [
                        'password' => $hashedPassword,
                        'status' => 'active',
                        'reset_token' => null,  // Clear the reset token after use
                        'reset_expires' => null  // Clear the reset expiry time
                    ]
                ]
            );

            if ($updateResult->getModifiedCount() > 0) {
                $response['status'] = 'success';
                $response['message'] = 'Password set successfully. You can now log in.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to set the password. Please try again.';
            }
        }
    }

    // Return the response as JSON
    echo json_encode($response);
    exit; // Exit to prevent further processing
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Management</title>
    <link rel="icon" href="assets/images/icon1.svg" type="image/svg+xml" />
    <link rel="stylesheet" href="output.css" />
    <script src="https://kit.fontawesome.com/10d593c5dc.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-500 flex items-center justify-center h-screen flex-col">
    <div class="bg-white border border-gray-600 rounded-lg px-6 py-6 shadow-lg relative h-fit w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-4">Set Your Password</h2>

        <form id="setPasswordForm" class="space-y-4">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

            <div class="flex flex-col">
                <label for="password" class="text-gray-700">Password:</label>
                <input type="password" name="password" id="password" required
                    class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="flex flex-col">
                <label for="confirm_password" class="text-gray-700">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required
                    class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Submit
            </button>
        </form>
    </div>

    <script>
        document.getElementById('setPasswordForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            const formData = new FormData(this);
            
            fetch('set-password.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        confirmButtonText: 'Okay',
                        preConfirm: () => {
                            window.location.href = 'loginpage.php'; // Redirect to login page
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong. Please try again.',
                });
            });
        });
    </script>
</body>

</html>
