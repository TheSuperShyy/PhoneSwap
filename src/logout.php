<?php
session_start();
session_unset(); // Clear session variables
session_destroy(); // Destroy the session

// Redirect to login page
header("Location: ../src/loginpage.php");
exit();
?>
