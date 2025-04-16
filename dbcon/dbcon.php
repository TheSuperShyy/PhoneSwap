<?php
require __DIR__ . '/../vendor/autoload.php';
date_default_timezone_set('Asia/Manila');

use MongoDB\Client;

// Connect to MongoDB
$client = new Client("mongodb://localhost:27017");
$db = $client->selectDatabase('phoneSwap');

// Collections
$usersCollection = $db->selectCollection('users');
$phonesCollection = $db->selectCollection('phones');
$phoneauditCollection = $db->selectCollection('phone_audit');
$phoneswapauditCollection = $db->selectCollection('phone_swap_audit');
?>
