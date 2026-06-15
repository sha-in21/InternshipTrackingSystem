<?php
$conn = new mysqli("localhost", "root", "", "internship_tracker");
if($conn->connect_error){
    die("Database Connection Failed: " . $conn->connect_error);
}
?>