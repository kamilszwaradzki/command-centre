<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->test->users;
$collection->insertOne(['name' => 'Test']);

echo "Działa!";

