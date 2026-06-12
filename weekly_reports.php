<?php
session_start();
include 'config.php';
// LOGIN CHECK
if(!isset($_SESSION['admin_id'])){
header("Location: admin_login.php");
exit();
}
// CHECK ID
if(!isset($_GET['id'])){
header("Location: admin_dashboard.php");
exit();
}
$id = $_GET['id'];
// TOTAL HOURS WORKED
$data = $conn->query("SELECT SUM(hours) as total FROM logs WHERE student_id=$id")
->fetch_assoc();
$total = $data['total'] ?? 0;
// WEEK TARGET (assume 40 hrs/week)
$target = 40;
// REMAINING
$remaining = max($target - $total, 0);
?>
<!DOCTYPE html>
<html>
<head>
<title>Weekly Progress</title>
<link href="https://fonts.googleapis.com/css2?
family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body{
    font-family:'Poppins', sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
    background:linear-gradient(135deg,#eef2ff,#e0e7ff);
}
/* CARD */
.box{
    width:420px;
    background:white;
    padding:25px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 15px 40px rgba(0,0,0,0.1);
}
/* TITLE */
h2{
    margin-bottom:20px;
    color:#4f46e5;
}
/* CHART SIZE FIX */
canvas{
    max-width:250px;
    margin:auto;
}
/* BACK BUTTON */
.back{
    display:inline-block;
    margin-top:20px;
    padding:8px 15px;
    background:#4f46e5;
    color:white;
    border-radius:8px;
    text-decoration:none;
}
</style>
</head>
<body>
<div class="box">
<h2>Weekly Progress</h2>
<canvas id="chart"></canvas>
<p><b><?= $total ?> hrs</b> completed out of <b><?= $target ?> hrs</b></p>
<a class="back" href="admin_dashboard.php">Back</a>
</div>
<script>
new Chart(document.getElementById("chart"),{
    type:'doughnut',
    data:{
        labels:['Worked','Remaining'],
        datasets:[{
            data:[<?= $total ?>, <?= $remaining ?>],
            backgroundColor:['#10b981','#e5e7eb'],
            borderWidth:0
        }]
    },
    options:{
        plugins:{
            legend:{
                position:'bottom'
            }
        }
    }
});
</script>
</body>
</html>
