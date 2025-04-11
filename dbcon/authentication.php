<?php 
session_start();
date_default_timezone_set("Asia/Manila");
require __DIR__ . '/dbcon.php';
if (!isset($_SESSION['user'])) {
  header("Location: ../../src/loginpage.php");
  exit();
}
?>