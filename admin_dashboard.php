<?php
session_start();
include 'config.php';
// LOGIN CHECK
if(!isset($_SESSION['admin_id'])){
header("Location: admin_login.php");
exit();
}
// ADD STUDENT
if(isset($_POST['add_student'])){
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$company = $_POST['company'];
$start = $_POST['start_date'];
$end = $_POST['end_date'];
    if($name && $email && $phone && $company && $start && $end){
        $conn->query("INSERT INTO students(name,email,phone,company,start_date,end_date)
        VALUES('$name','$email','$phone','$company','$start','$end')");
        
        //  refresh avoid duplicate submit
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Fill all fields!');</script>";
    }
}
// ADMIN DATA
$admin_name = $_SESSION['admin_name'];
$first_letter = strtoupper(substr($admin_name,0,1));
// FETCH STUDENTS
$students = $conn->query("SELECT * FROM students");
$total = $conn->query("SELECT COUNT(*) as c FROM students")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?
family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
<style>
body{
    font-family: 'Poppins', sans-serif;
    margin:0;
    background: linear-gradient(135deg,#eef2ff,#e0e7ff);
}
.header{
    background:#4f46e5;
    color:white;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.avatar{
    background:white;
    color:#4f46e5;
    border-radius:50%;
    width:40px;
    height:40px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    cursor:pointer;
}
.dropdown{
    position:absolute;
    right:0;
    top:50px;
    background:white;
    padding:10px;
    border-radius:10px;
    display:none;
}
.dropdown.show{
    display:block;
}
.container{padding:30px;}
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-bottom:30px;
}
.card{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}
.form{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}
.form input{
    width:180px;
}
.btn{
    background:#10b981;
    color:white;
    padding:10px 15px;
    border:none;
    border-radius:8px;
}
table{
    width:100%;
    background:white;
    border-radius:10px;
    margin-top:20px;
}
th,td{
    padding:12px;
    border-bottom:1px solid #eee;
}
th{background:#f3f4f6;}
.action a{
    margin:3px;
    padding:6px 10px;
    border-radius:6px;
    color:white;
    text-decoration:none;
}
.logs{background:#3b82f6;}
.weekly{background:#8b5cf6;}
.report{background:#10b981;}
.delete{background:#ef4444;}
</style>
</head>
<body>
<div class="header" style="background:#1f2937;">
    <h2 style="color:white;">Internship Tracker</h2>
    
    <div style="display:flex;align-items:center;gap:20px;">
        <!--  SARANYA AVATAR + NAME -->
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:45px;height:45px;background:#10b981;border
radius:50%;display:flex;align-items:center;justify-content:center;color:white;font
weight:bold;font-size:20px;">
                <?= $first_letter ?>  <!-- S for SARANYA -->
            </div>
            <div>
                <div style="font-weight:600;font-size:16px;color:#10b981;">Howdy, <?= 
$admin_name ?></div>
                <div style="font-size:14px;color:#9ca3af;">Admin</div>
            </div>
        </div>
        
        <!--  LOGOUT BUTTON -->
        <a href="logout.php" 
           style="background:#ef4446;color:white;padding:12px 24px;border-radius:25px;font
weight:600;text-decoration:none;font-size:14px;"
           onclick="return confirm('Are you sure you want to logout?')">
           Logout
        </a>
    </div>
</div>
</div>
<div class="container">
<!-- CARDS -->
<div class="cards">
<div class="card">
    <h2><?= $total ?></h2>
    <p>Total Students</p>
</div>
<div class="card">
<h2>Active</h2>
<p>Internships Running</p>
</div>
<div class="card">
<h2>Reports</h2>
<p>Certificates Ready</p>
</div>
</div>
<!-- ADD STUDENT -->
<div class="card">
<h3>Add Student</h3>
<form class="form" method="POST" onsubmit="return validateForm()">
<input name="name" placeholder="Name">
<input name="email" placeholder="Email">
<input name="phone" placeholder="Phone">
<input name="company" placeholder="Company">
<input type="date" name="start_date">
<input type="date" name="end_date">
<button class="btn" name="add_student">Add</button>
</form>
</div>
<!-- TABLE -->
<table>
<tr>
<th>Name</th>
<th>Company</th>
<th>Actions</th>
</tr>
<?php while($s=$students->fetch_assoc()): ?>
<tr>
<td><?= $s['name']; ?></td>
<td><?= $s['company']; ?></td>
<td class="action">
<a class="logs" href="logs.php?student_id=<?= $s['id']; ?>">Logs</a>
<a class="weekly" href="weekly_reports.php?id=<?= $s['id']; ?>">Weekly</a>
<a class="report" href="reports.php?id=<?= $s['id']; ?>">Report</a>
<a class="delete" 
href="delete_student.php?id=<?= $s['id']; ?>" 
onclick="return confirm('Are you sure to delete this student?')">
Delete
</a>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>
<script>
}
function validateForm(){
    let inputs = document.querySelectorAll(".form input");
    for(let i=0;i<inputs.length;i++){
        if(inputs[i].value==""){
            alert("All fields required!");
            return false;
        }
    }
    return true;
}
</script>
</body>
</html>
