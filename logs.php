<?php
session_start();
include 'config.php';
if(!isset($_SESSION['admin_id'])){
header("Location: admin_login.php");
exit();
}
if(!isset($_GET['student_id'])){
header("Location: admin_dashboard.php");
exit();
}
$student_id = $_GET['student_id'];
$student_name = $conn->query("SELECT name FROM students WHERE id=$student_id")
->fetch_assoc()['name'];
// TODAY'S DATE AUTO
$today = date('d/m/Y');
// ADD LOG
if(isset($_POST['add_log'])){
$log_date = $_POST['log_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$hours = $_POST['hours'];
$task = $_POST['task'];
$status = $_POST['status'];
    $feedback = $_POST['feedback']; // Completed/Complexity both use this
    $stmt = $conn->prepare("INSERT INTO 
logs(student_id,log_date,start_time,end_time,hours,task,status,feedback) 
VALUES(?,?,?,?,?,?,?,?)");
    $stmt->bind_param("isssdsss", $student_id, $log_date, $start_time, $end_time, $hours, $task, 
$status, $feedback);
    $stmt->execute();
    
    header("Location: logs.php?student_id=$student_id");
    exit();
}
// DELETE
if(isset($_GET['delete'])){
    $log_id = $_GET['delete'];
    $conn->query("DELETE FROM logs WHERE id=$log_id");
    header("Location: logs.php?student_id=$student_id");
    exit();
}
// FETCH LOGS
$logs = $conn->query("SELECT * FROM logs WHERE student_id=$student_id ORDER BY 
id DESC");
$total_hours = $conn->query("SELECT SUM(hours) as total FROM logs WHERE 
student_id=$student_id")->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
<title><?= $student_name ?> - Daily Logs</title>
<link href="https://fonts.googleapis.com/css2?
family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
<style>
body{font-family:'Poppins',sans-serif;background:linear
gradient(135deg,#eef2ff,#e0e7ff);margin:0;padding:20px;}
.card{background:rgba(255,255,255,0.95);backdrop-filter:blur(12px);border
radius:20px;padding:30px;box-shadow:0 15px 40px rgba(0,0,0,0.1);}
h1{text-align:center;color:#1f2937;margin-bottom:10px;}
h2{margin-bottom:20px;color:#374151;}
form{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;margin
bottom:30px;}
input,select,textarea{padding:12px;border:2px solid #e5e7eb;border-radius:10px;font
size:16px;transition:border-color 0.3s;}
input:focus,select:focus,textarea:focus{outline:none;border-color:#10b981;box-shadow:0 0 0 
3px rgba(16,185,129,0.1);}
button{background:linear-gradient(135deg,#10b981,#059669);color:white;border:none;border
radius:10px;padding:15px 30px;font-weight:600;cursor:pointer;font-size:16px;}
button:hover{transform:translateY(-2px);}
table{width:100%;border-collapse:collapse;margin-top:25px;border
radius:15px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,0.1);}
th{padding:15px;background:linear-gradient(135deg,#f8fafc,#f1f5f9);color:#374151;font
weight:600;text-align:center;}
td{padding:12px;border-bottom:1px solid #f1f5f9;text-align:center;}
tr:hover{background:#f8fafc;}
.status-completed{background:#d1fae5;color:#065f46;padding:6px 12px;border
radius:20px;font-weight:600;}
.status-pending{background:#fef3c7;color:#d97706;padding:6px 12px;border-radius:20px;font
weight:600;}
.time-range{font-size:14px;color:#6b7280;}
.feedback{max-width:250px;white-space:normal;text-align:left;}
.total-row{background:#10b981;color:white;font-weight:600;font-size:18px;}
.back{display:inline-block;margin-top:20px;background:#4f46e5;color:white;padding:12px 
24px;border-radius:10px;text-decoration:none;}
@media(max-width:768px){form{grid-template-columns:1fr;}}
</style>
</head>
<body>
<div class="card">
    <h1>📋 <?= $student_name ?> - Daily Logs</h1>
    <h2>Total Hours: <span style="color:#10b981;font-size:24px;font-weight:700;"><?= 
number_format($total_hours,1) ?> hrs</span></h2>
    <!-- NEW PROFESSIONAL LOG FORM -->
    <form method="POST">
        <input type="date" name="log_date" value="<?= date('Y-m-d') ?>" required>
        <input type="time" name="start_time" value="09:00" required>
        <input type="time" name="end_time" value="17:00" required>
        <input type="number" name="hours" step="0.5" placeholder="Hours" required>
        <input type="text" name="task" placeholder="Task (eg: UI/UX Design)" required>
        
        <select name="status" id="status" onchange="toggleFeedback()" required>
            <option value="">Status</option>
            <option value="Completed"> Completed</option>
            <option value="Pending"> Not Completed</option>
        </select>
        
        <textarea name="feedback" id="feedback" placeholder="Feedback / Challenges..." 
rows="3" style="display:none;"></textarea>
        <button name="add_log">Save Log</button>
    </form>
    <!-- PROFESSIONAL LOGS TABLE -->
    <table>
        <tr>
            <th>Date</th>
            <th>Hours</th>
            <th>Time</th>
            <th>Task</th>
            <th>Status</th>
            <th>Feedback/Challenges</th>
            <th>Action</th>
        </tr>
        <?php while($log = $logs->fetch_assoc()): ?>
        <tr>
            <td><?= date('d/m/Y', strtotime($log['log_date'])) ?></td>
            <td style="font-weight:600;color:#10b981;"><?= $log['hours'] ?> hrs</td>
            <td class="time-range">[<?= $log['start_time'] ?> - <?= $log['end_time'] ?>]</td>
            <td style="font-weight:500;"><?= htmlspecialchars($log['task']) ?></td>
            <td><span class="status-<?= $log['status']=='Completed' ? 'completed' : 'pending' ?>">
<?= $log['status'] ?></span></td>
            <td class="feedback"><?= htmlspecialchars($log['feedback']) ?></td>
            <td>
                <a href="?student_id=<?= $student_id ?>&delete=<?= $log['id'] ?>" 
                   class="delete-btn" style="background:#ef4444;color:white;padding:8px 
12px;border-radius:6px;text-decoration:none;font-size:12px;"
                   onclick="return confirm('Delete this log?')">🗑 </a>
            </td>
        </tr>
        <?php endwhile; ?>
        <tr class="total-row">
            <td colspan="1"><strong>TOTAL</strong></td>
            <td colspan="6"><strong><?= number_format($total_hours,1) ?> HOURS</strong>
</td>
        </tr>
    </table>
    <a href="admin_dashboard.php" class="back"> Back to Dashboard</a>
</div>
<script>
function toggleFeedback() {
    const status = document.getElementById('status').value;
    const feedback = document.getElementById('feedback');
    
    if(status === 'Completed') {
        feedback.placeholder = 'What did you learn? How was the experience?';
        feedback.style.display = 'block';
    } else if(status === 'Pending') {
        feedback.placeholder = 'What challenges did you face? What complexity?';
        feedback.style.display = 'block';
    } else {
        feedback.style.display = 'none';
    }
}
</script>
</body>
</html>
