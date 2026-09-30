<?php require_once __DIR__ . '/../contoler/db.php'; 
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit();
}
if ($_SESSION['role'] != 'student') {
    header("Location: ../public/home.php");
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>My Results - Student</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
    <style>
        .grid-container{background:white; border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05);padding:25px; margin-top:20px;border:1px solid #e0e0e0;} 
        .styled-grid{width:100%;border-collapse:collapse; margin-top:10px;} 
        .styled-grid th{background: linear-gradient(to right, #1d3160,#2557d6);color:white;padding: 15px;text-align:left;font-weight:600;font-size:14px;} 
        .styled-grid td{padding: 15px;border-bottom:1px solid #eaeaea;color:#495057;font-size: 14px;} 
        .styled-grid tr:hover{background-color:#f8f9fa;} 
        .page-header h1{color:#1d3160;margin-top:0;margin-bottom:5px;} 
        .page-header p{color:#666; font-size:14px;margin-bottom:20px;} 
        .status-badge{padding:6px 12px;border-radius: 20px;font-size:12px;font-weight:bold;display:inline-block;} 
        .status-completed{background-color:#d4edda;color:#155724;} 
        .status-progress{background-color:#fff3cd;color:#856404;} 
        .status-pending{background-color:#f8d7da;color:#721c24;} 
        .score-badge{padding:6px 12px;border-radius:4px;font-weight:bold;background-color:#e2e3e5;color:#383d41;} 
        .score-high{background-color:#cce5ff;color:#004085;}
    </style>
</head>
<body> 
<form id="form1">
<div>
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <div class="topbar-right">
            <span style="float: left; margin: 15px 20px 0 0; font-size: 16px; font-weight: bold; color: #17a2b8;">Student: [Username]</span>
            <a id="hldash" class="nav-link" href="dashboard.php">Dashboard</a>
            <a id="hlhome" class="nav-link" href="home.php">Home</a>
            <a id="hllout" class="nav-link" href="../public/logout.php">Log Out</a>
        </div>
    </div>
    <div id="pnsidebar" class="sidebar">
        <a id="lbtrndash" href="dashboard.php">Dashboard</a>
        <a id="Ibtnpro" href="profile.php">My Profile</a>
        <a id="Ibtnsubmit" href="submitproject.php">Submit Project</a>
        <a id="Ibtnresult" href=" results.php" style="font-weight:bold; color: #ffeb3b;">My Results</a>
        <a id="Ibtnupwd" href="pwdchange.php">Password Change</a>
        <a id="Ibtlout" href="../public/logout.php">Log Out</a>
    </div>
    <div id="pnicontant" class="contant">
        <div class="page-header">
            <h1>My Results</h1>
            <p>View the grading status and final scores for your submitted projects.</p>
        </div>
        <div class="grid-container">
            <h3 style="color: #1d3160; margin-bottom: 15px;">Project Scores</h3>
            <table id="gvMyResults" class="styled-grid">
                <thead>
                    <tr>
                        <th>Project Title</th>
                        <th>Subject</th>
                        <th>Project Status</th>
                        <th>Final Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[Title]</td>
                        <td>[Subject]</td>
                        <td><span class="status-badge status-completed">[Status]</span></td>
                        <td><span class="score-badge">[Score]</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</form>
</body>
</html>