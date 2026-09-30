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
    <title>Change Password - Project-Gate</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
    <style>
        body{background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;margin:0;padding:0;} 
        .login-container{display:flex;justify-content:center;margin-top:50px;margin-bottom:50px;} 
        .auth-card{background:#ffffff;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05);width:500px; max-width:95%;border:1px solid #e0e0e0;overflow:hidden;} 
        .auth-header{background:linear-gradient(to right, #1d3160,#2557d6);color:white;padding:30px 40px;} 
        .auth-header h2{margin:0 0 8px 0;font-size:24px;font-weight:bold;} 
        .auth-body{padding:30px 40px 10px 40px;} 
        .form-group{margin-bottom:20px;} 
        .form-group label{display:block;font-weight:600;color:#333;margin-bottom:8px;font-size:14px;} 
        .form-control{width:100%; padding:12px 15px;box-sizing:border-box;border:1px solid #ced4da;border-radius:6px;font-size:14px;} 
        .auth-footer{padding:20px 40px;border-top:1px solid #eaeaea;display: flex; justify-content:flex-end; background-color:#ffffff;} 
        .btn-submit{background-color:#2b5add;color:white;border:none;padding: 10px 30px;font-size:15px;border-radius:6px;cursor:pointer;font-weight:bold;} 
        .btn-submit:hover{background-color:#1c45b5;}
    </style>
</head>
<body> 
<form id="form1">
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <span style="float: right; margin: 60px 40px 0 0; font-size: 18px; font-weight: bold; color: green;">Admin: [Username]</span>
    </div>
    <div id="pnsidebar" class="sidebar"><br />
        
        <a id="Ibtnpro" href="profile.php">My Profile</a>
        <a id="Ibtnproject" href="reviewproject.php">Student Projects</a>
        <a id="Ibtnresult" href="grad.php">Student Results</a>
        <a id="Ibtnfact" href="pwdchange.php" style="font-weight:bold; color:#ffeb3b;">Password Change</a>
        <a id="Ibtlout" href="../public/logout.php">Log Out</a>
    </div>
    <div class="contant login-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Change Password</h2>
                <p style="margin: 0; font-size: 14px; opacity: 0.9;">Ensure your account is using a strong password to stay secure.</p>
            </div>
            <div class="auth-body">
                <span id="lblMsg" style="font-weight:bold; margin-bottom:15px; display:block;"></span>
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" id="txtOldPwd" class="form-control" required />
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" id="txtNewPwd" class="form-control" required />
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" id="txtConfirmPwd" class="form-control" required />
                </div>
            </div>
            <div class="auth-footer">
                <button type="submit" id="btnChangePwd" class="btn-submit">Update Password</button>
            </div>
        </div>
    </div>
</form>
</body>
</html>