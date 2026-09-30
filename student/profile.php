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
    <title>Student Profile - Project-Gate</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
    <style>
        .form-card{background:white;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05);padding:25px; border:1px solid #e0e0e0;margin-bottom:30px;max-width:800px;margin-top:20px;} 
        .form-header h2{color: #1d3160;margin-top:0;margin-bottom:20px;} 
        .form-grid{display:grid; grid-template-columns: 1fr 1fr;gap:15px;} 
        .form-group.full-width{grid-column:span 2;} 
        .form-group{margin-bottom:10px;} 
        .form-label{display:block;font-weight:600; margin-bottom:5px;color:#333;font-size:14px;} 
        .form-input{width:100%;padding:10px; border:1px solid #ccc;border-radius:4px;box-sizing: border-box;font-size:14px;} 
        .form-input[readonly]{background-color:#f8f9fa;color:#6c757d;cursor:not-allowed;} 
        .button-group{margin-top:20px;margin-bottom:10px;grid-column:span 2;} 
        .btn-primary{background-color:#2b5add;color:white;border:none; padding: 10px 20px;border-radius:4px;cursor:pointer;font-weight:bold;width:100%; font-size:15px;} 
        .btn-primary:hover{background-color:#1c45b5;}
    </style>
</head>
<body> 
<form id="form1">
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
        <a id="Ibtndash" href="dashboard.php">Dashboard</a>
        <a id="Ibtnpro" href="profile.php" style="font-weight:bold; color:#ffeb3b;">My Profile</a>
        <a id="Ibtnproject" href="submitproject.php">Submit Project</a>
        <a id="Ibtnresult" href="results.php">My Results</a>
        <a id="Ibtnupwd" href="pwdchange.php">Password Change</a>
        <a id="Ibtlout" href="../public/logout.php">Log Out</a>
    </div>
    <div class="contant">
        <div class="form-card">
            <div class="form-header"><h2>Student Profile</h2></div>
            <div class="form-body form-grid">
                <div class="form-group">
                    <label id="IbISIDText" class="form-label">Student ID</label>
                    <input type="text" id="txtSID" class="form-input" readonly />
                </div>
                <div class="form-group">
                    <label id="IblUsername" class="form-label">Username</label>
                    <input type="text" id="txtUsername" class="form-input" readonly />
                </div>
                <div class="form-group full-width"> 
                    <label id="lblEmail" class="form-label">Email Address</label>
                    <input type="email" id="txtEmail" class="form-input" required pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$" />
                </div>
                <div class="form-group">
                    <label id="IblFirstName" class="form-label">First Name</label>
                    <input type="text" id="txtFirstName" class="form-input" required />
                </div>
                <div class="form-group">
                    <label id="IblLastName" class="form-label">Last Name</label>
                    <input type="text" id="txtLastName" class="form-input" required />
                </div>
                <div class="form-group">
                    <label id="IblGender" class="form-label">Gender</label>
                    <input type="text" id="txtGender" class="form-input" required />
                </div>
                <div class="form-group">
                    <label id="lblAge" class="form-label">Age</label>
                    <input type="number" id="txtAge" class="form-input" required min="10" max="100" />
                </div>
                <div class="form-group">
                    <label id="lblClass" class="form-label">Class/Semester</label>
                    <input type="text" id="txtClass" class="form-input" required />
                </div>
                <div class="form-group">
                    <label id="lblYear" class="form-label">Academic Year</label>
                    <input type="number" id="txtYear" class="form-input" required min="2000" max="2100" />
                </div>
                <div class="button-group">
                    <span id="IbiMessage" style="font-weight:bold; display:block; margin-bottom:10px;"></span>
                    <button type="submit" id="btnUpdate" class="btn-primary">Update Profile</button>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>