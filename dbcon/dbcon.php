<?php
require __DIR__ . '/../vendor/autoload.php';


use MongoDB\Client;

// Connect to MongoDB
$client = new Client("mongodb://localhost:27017");
$db = $client->selectDatabase('phoneSwap');
$usersCollection = $db->selectCollection('users');
$phonesCollection = $db->selectCollection('phones');
?>