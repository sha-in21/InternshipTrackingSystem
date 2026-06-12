<?php
session_start();
// Destroy session
session_unset();
session_destroy();
// Redirect
header("Location: admin_login.php");
exit();
?>
