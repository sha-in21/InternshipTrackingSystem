<?php
session_start();
include 'config.php';
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    //  CORRECT CHECK (no \ before $)
    if($username == "Shain S" && $password == 'Alhamdhulill@h21!'){
        $_SESSION['admin_id'] = 1;
        $_SESSION['admin_name'] = "SHAIN S";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Wrong credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="style.css">
<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?
family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
<style>
body{
    font-family:'Poppins',sans-serif;
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#667eea,#764ba2);
}
.box{
    width:360px;
    background:rgba(255,255,255,0.95);
    backdrop-filter:blur(10px);
    padding:30px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}
h2{
    color:#4f46e5;
    margin-bottom:20px;
}
input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:10px;
    border:1px solid #ddd;
}
input:focus{
    border-color:#4f46e5;
    box-shadow:0 0 8px rgba(79,70,229,0.4);
    outline:none;
}
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
background:#4f46e5;
color:white;
cursor:pointer;
font-weight:bold;
}
button:hover{
background:#4338ca;
}
.error{
color:red;
font-size:14px;
}
</style>
</head>
<body>
<div class="box">
<h2>Admin Login</h2>
<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>
</div>
</body>
</html>
