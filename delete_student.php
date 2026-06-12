<?php
session_start();
include 'config.php';
//  CHECK ID EXISTS
if(!isset($_GET['id'])){
header("Location: admin_dashboard.php");
exit();
}
$id = intval($_GET['id']); // safety
// DELETE LOGS FIRST
$conn->query("DELETE FROM logs WHERE student_id=$id");
// DELETE STUDENT
$conn->query("DELETE FROM students WHERE id=$id");
// REDIRECT
header("Location: admin_dashboard.php");
exit();
?>
