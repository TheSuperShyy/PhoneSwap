<?php 
session_start();
require __DIR__ . '/dbcon.php';
if (!isset($_SESSION['user'])) {
  header("Location: ../../src/loginpage.php"); // Redirect to login page if not logged in
  exit();
}
?>