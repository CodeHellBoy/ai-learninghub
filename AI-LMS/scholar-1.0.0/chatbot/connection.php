<?php
$servername = "localhost";
$username = "root";
$password = "12";
$dbname = "db_chatbot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>