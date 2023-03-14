<?php

$servername = "localhost";
$username = "id20139608_todo";
$password = "_*JRd0^6>g@[kfq8";
$database = "id20139608_todolist";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>