<?php require_once __DIR__ . '/../contoler/db.php'; 
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit();
}
if ($_SESSION['role'] != 'faculty') {
    header("Location: ../public/home.php");
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Score Modification - Faculty</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
    <style>
        .grid-container{background:white; border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05);padding:20px; border:1px solid #e0e0e0;margin-top:20px;} 
        .styled-grid{width:100%;border-collapse:collapse; margin-top: 10px;} 
        .styled-grid th{background:linear-gradient(to right, #1d3160,#2557d6);color:white;padding: 15px;text-align:left;font-weight:600;font-size:14px;} 
        .styled-grid td{padding: 15px;border-bottom:1px solid #eaeaea;color:#495057; font-size:14px;} 
        .styled-grid tr:hover{background-color:#f8f9fa;} 
        .page-header h1{color:#1d3160;margin-top:0;margin-bottom:5px;} 
        .page-header p{color:#666; font-size:14px;margin-bottom:20px;} 
        .btn-action{background-color:#2b5add;color:white;border:none; padding: 8px 15px;border-radius:4px;cursor:pointer;font-weight:bold;} 
        .btn-action:hover{background-color:#1c45b5;} 
        .form-input{padding:8px;border:1px solid #ccc;border-radius:4px;width:80px;}
    </style>
</head>
<body> 
<form id="form1" method="post">
<div>
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <div class="topbar-right">
            <span style="float: left; margin: 15px 20px 0 0; font-size: 16px; font-weight: bold; color: green;">Faculty: [Username]</span>
            <a id="hldash" class="nav-link" href="dashboard.php">Dashboard</a>
            <a id="hlhome" class="nav-link" href="home.php">Home</a>
            <a id="hllout" class="nav-link" href="../public/logout.php">Log Out</a>
        </div>
    </div>
    <div id="pnsidebar" class="sidebar">
        <a id="Ibtndash" href="dashboard.php">Dashboard</a>
        <a id="Ibtnpro" href="profile.php">My Profile</a>
        <a id="Ibtnproject" href="reviewproject.php">Student Projects</a>
        <a id="Ibtnresult" href="grad.php" style="font-weight:bold; color:#ffeb3b;">Student Results</a>
        <a id="Ibtnupwd" href="pwdchange.php">Password Change</a>
        <a id="Ibtlout" href="../public/logout. php">Log Out</a>
    </div>
    <div id="pnicontant" class="contant">
        <div class="page-header">
            <h1>Score Modification</h1>
            <p>Review completed projects and assign or modify student scores.</p>
        </div>
        <div class="grid-container">
            <h3 style="color: #1d3160; margin-bottom: 15px;">Assign Grades</h3>
            <table id="gvResults" class="styled-grid">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Project Title</th>
                        <th>Status</th>
                        <th>Score</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[ID]</td>
                        <td>[Title]</td>
                        <td>[Status]</td>
                        <td><input type="number" id="txtScore" class="form-input" placeholder="0-100" min="0" max="100" /></td>
                        <td><button type="button" class="btn-action">Save Score</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</form>
</body>
</html>