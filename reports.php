<?php
session_start();
include 'config.php';
// CHECK LOGIN
if(!isset($_SESSION['admin_id'])){
header("Location: admin_login.php");
exit();
}
// GET ID
if(!isset($_GET['id'])){
header("Location: admin_dashboard.php");
exit();
}
$id = $_GET['id'];
// FETCH STUDENT
$s = $conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();
// DATE FORMAT
$start = date("d M Y", strtotime($s['start_date']));
$end = date("d M Y", strtotime($s['end_date']));
?>
<!DOCTYPE html>
<html>
<head>
<title>Certificate</title>
<link href="https://fonts.googleapis.com/css2?
family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
<style>
body{
    font-family:'Poppins', sans-serif;
    background:linear-gradient(135deg,#eef2ff,#e0e7ff);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
}
/* CERTIFICATE */
.cert{
    width:800px;
    background:white;
    padding:50px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 20px 50px rgba(0,0,0,0.15);
    position:relative;
}
/* BORDER DESIGN */
.cert::before{
    content:"";
    position:absolute;
    inset:15px;
    border:3px solid #4f46e5;
    border-radius:15px;
}
/* TEXT */
h1{
    font-size:38px;
    margin-bottom:10px;
}
h2{
    color:#4f46e5;
    font-size:30px;
    margin:15px 0;
}
h3{
    margin:10px 0;
}
p{
    color:#555;
    font-size:16px;
}
/* FOOTER */
.footer{
    margin-top:40px;
    display:flex;
    justify-content:space-between;
}
.sign{
    text-align:center;
}
.line{
    width:150px;
    border-top:2px solid #000;
    margin:10px auto;
}
/* PRINT BUTTON */
.print-btn{
    position:absolute;
    top:20px;
    right:20px;
    background:#4f46e5;
    color:white;
    padding:8px 12px;
    border:none;
    border-radius:8px;
    cursor:pointer;
}
</style>
</head>
<body>
<div class="cert">
<button class="print-btn" onclick="window.print()">Print</button>
<h1>Certificate of Completion</h1>
<p>This certifies that</p>
<h2><?= $s['name']; ?></h2>
<p>has successfully completed an internship at</p>
<h3><b><?= $s['company']; ?></b></h3>
<p>from <b><?= $start ?></b> to <b><?= $end ?></b></p>
<div class="footer">
    <div class="sign">
        <div class="line"></div>
        <p>Supervisor</p>
    </div>
    <div class="sign">
        <div class="line"></div>
        <p>Admin</p>
    </div>
</div>
</div>
</body>
</html>
