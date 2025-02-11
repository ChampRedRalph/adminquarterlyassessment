<?php
$conn = new mysqli("30.30.30.5", "admin", "r00t", "roxsystem");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
?>