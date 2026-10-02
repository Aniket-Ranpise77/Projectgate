<?php require_once __DIR__ . '/../contoler/db.php'; 
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit();
}
if ($_SESSION['role'] != 'student') {
    header("Location: ../public/home.php");
    exit();
}
$user=mysqli_query($conn, "SELECT * FROM `tblstud` WHERE uid = '{$_SESSION['uid']}'");
$stud = mysqli_fetch_assoc($user);
$project=mysqli_query($conn, "SELECT * FROM `tblproject` WHERE uid = '$stud[sid]'");
$myproject = mysqli_fetch_assoc($project);
$score=mysqli_query($conn, "SELECT AVG(score) AS average_score  FROM tblscore WHERE sid = '$stud[sid]'");
$average_score = mysqli_fetch_assoc($score);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Student Dashboard - Project-Gate</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
    <style>
        .page-header h1{color:#1d3160;margin-top:0;margin-bottom:5px;} 
        .page-header p{color:#666; font-size:14px; margin-bottom:30px;} 
        .statusbar{display:grid; grid-template-columns:repeat(4, 1fr); gap:20px;margin-bottom:30px;} 
        .card{background:white;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05); padding:20px;border:1px solid #e0e0e0; border-top:4px solid #2b5add;} 
        .card h3{margin-top:0;font-size: 14px;color:#6c757d;text-transform:uppercase; letter-spacing:0.5px; margin-bottom:10px;} 
        .card.metric{font-size:18px;font-weight:bold;color:#1d3160;} 
        .card.profile-card{border-top-color:#17a2b8;} 
        .card.project-card{border-top-color:#ffc107;} 
        .card.result-card{border-top-color:#28a745;}
    </style>
</head>
<body> 
<form id="form1">
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <div class="topbar-right">
            <span style="float: left; margin: 15px 20px 0 0; font-size: 16px; font-weight: bold; color: #17a2b8;">Student: [Username]</span>
            <a id="hidash" class="nav-link" href="dashboard.php" style="font-weight:bold; color:#ffeb3b;">Dashboard</a>
            <a id="hlhome" class="nav-link" href="home.php">Home</a>
            <a id="hllout" class="nav-link" href="../public/logout.php">Log Out</a>
        </div>
    </div>
    <div id="pnsidebar" class="sidebar">
        <a id="Ibtnpro" href="profile.php">My Profile</a>
        <a id="Ibtnproject" href="project.php">Submit Project</a>
        <a id="lbtnresult" href="result.php">My Results</a>
        <a id="lbtnupwd" href="pwdchange.php">Password Change</a>
        <a id="Ibtlout" href="../public/logout.php">Log Out</a>
    </div>
    <div class="contant">
        <div class="page-header">
            <h1>Student Dashboard</h1>
            <p>Welcome back! Here is an overview of your academic profile and project submissions.</p>
        </div>
        
        <h3 style="color: #1d3160; margin-bottom: 15px;">Profile Overview</h3>
        <div class="statusbar">
            <div class="card profile-card"><h3>Student Name</h3><span id="lblStudentName" class="metric"><?php echo htmlspecialchars($stud['sname']) ?></span></div>
            <div class="card profile-card"><h3>Student ID</h3><span id="IbISID" class="metric"><?php echo htmlspecialchars($stud['sid']) ?></span></div>
            <div class="card profile-card"><h3>Class</h3><span id="IbIClass" class="metric"><?php echo htmlspecialchars($stud['class']) ?></span></div>
            <div class="card profile-card"><h3>Academic Year</h3><span id="lblAcademicYear" class="metric"><?php echo htmlspecialchars($stud['year']) ?></span></div>
        </div>
        
        <h3 style="color:#1d3160; margin-bottom: 15px;">Latest Project Status</h3>
        <div class="statusbar">
            <div class="card project-card"><h3>My Project</h3><span id="lbiProject" class="metric"><?php echo htmlspecialchars(mysqli_num_rows($project)); ?></span></div>
            <div class="card project-card"><h3>Status</h3><span id="lblProjectStatus" class="metric">N/A</span></div>
            <div class="card result-card"><h3>My Result</h3><span id="lblResult" class="metric"><?php echo htmlspecialchars($average_score['average_score']); ?></span></div>
            <div class="card result-card"><h3>Assigned Faculty</h3><span id="lblFaculty" class="metric">Not Assigned</span></div>
        </div>
    </div>
</form>
</body>
</html>