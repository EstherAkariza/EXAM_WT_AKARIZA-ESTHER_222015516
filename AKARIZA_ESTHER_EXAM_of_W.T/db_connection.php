<?php
// Connection details
$host = "localhost";
$user = "ESTHER";
$pass = "ester";
$database = "auctionplatform";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>