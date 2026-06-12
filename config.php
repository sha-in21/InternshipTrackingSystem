<?php
$conn = new mysqli("localhost", "root", "Alhamdhulill@h21!", "internship_tracker");
if($conn->connect_error){
    die("Database Connection Failed: " . $conn->connect_error);
}
?>