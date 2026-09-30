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
    <title>My Project - Student</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
    <style>
        .form-card{background:white; border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05);padding:25px;border:1px solid #e0e0e0; margin-bottom:30px;max-width:800px;} 
        .form-header h2{color:#1d3160;margin-top:0;margin-bottom:20px;} 
        .form-group{margin-bottom:15px;} 
        .form-label{display:block;font-weight:600; margin-bottom:5px;color:#333;font-size:14px;} 
        .form-input{width:100%; padding: 10px; border:1px solid #ccc;border-radius:4px;box-sizing:border-box;font-size:14px;} 
        .button-group{margin-top:20px;margin-bottom:20px;} 
        .btn-primary{background-color:#2b5add;color:white; border:none;padding: 10px 20px; border-radius:4px;cursor:pointer;font-weight:bold;} 
        .btn-primary:hover{background-color:#1c45b5;} 
        .grid-container{background:white; border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05); padding:20px;border:1px solid #e0e0e0;} 
        .styled-grid{width:100%;border-collapse:collapse; margin-top:10px;} 
        .styled-grid th{background:linear-gradient(to right, #1d3160,#2557d6);color:white;padding:15px;text-align:left;font-weight:600; font-size:14px;} 
        .styled-grid td{padding:15px;border-bottom:1px solid #eaeaea; color:#495057;font-size:14px;} 
        .styled-grid tr:hover{background-color:#f8f9fa;}
    </style>
</head>
<body> 
<form id="form1">
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <div class="topbar-right">
            <span style="float: left; margin: 15px 20px 0 0; font-size: 16px; font-weight: bold; color: #17a2b8;">Student: [Username]</span>
            <a id="hlidash" class="nav-link" href="dashboard.php">Dashboard</a>
            <a id="hlhome" class="nav-link" href="home.php">Home</a>
            <a id="hllout" class="nav-link" href="../public/logout.php">Log Out</a>
        </div>
    </div>
    <div id="pnsidebar" class="sidebar">
        <a id="lbtndash" href="dashboard.php">Dashboard</a>
        <a id="Ibtnpro" href="profile.php">My Profile</a>
        <a id="lbtnproject" href="submitproject.php" style="font-weight:bold; color:#ffeb3b;">My Project</a>
        <a id="lbtnresult" href="results.php">My Results</a>
        <a id="lbtnupwd" href="pwdchange.php">Password Change</a>
        <a id="Ibtlout" href="../public/logout.php">Log Out</a>
    </div>
    <div class="contant">
        <div class="form-card">
            <div class="form-header"><h2>Submit/Update Project</h2></div>
            <div class="form-body">
                <div class="form-group">
                    <label id="lblTitle" class="form-label">Project Title</label>
                    <input type="text" id="txtTitle" class="form-input" required />
                </div>
                <div class="form-group">
                    <label id="lblDescription" class="form-label">Project Description</label>
                    <textarea id="txtDescription" class="form-input" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label id="lblTechnology" class="form-label">Technology</label>
                    <input type="text" id="txtTechnology" class="form-input" required />
                </div>
                <div class="form-group">
                    <label id="lblSubject" class="form-label">Subject</label>
                    <select id="ddlsubject" class="form-input" required>
                        <option value="">Select Subject</option>
                        <!-- Dynamic options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label id="IblFile" class="form-label">Project File (ZIP/PDF/DOCX)</label>
                    <input type="file" id="fuProject" class="form-input" style="padding-bottom: 35px;" accept=".zip,.pdf,.docx" required />
                </div>
                <div class="button-group">
                    <button type="submit" id="btnSubmit" class="btn-primary">Submit Project</button>
                </div>
                
                <div class="form-group" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px;">
                    <label id="lblStatusText" class="form-label" style="display:inline;">Project Status: </label>
                    <span id="IbiStatus" style="font-weight:bold;"></span>
                </div>
                <div class="form-group">
                    <label id="IblReviewText" class="form-label" style="display:inline;">Review Date: </label>
                    <span id="IbIReview"></span>
                </div>
                <div class="form-group">
                    <label id="lblCommentsText" class="form-label" style="display:inline;">Faculty Comments: </label>
                    <span id="lblComments"></span>
                </div>
            </div>
        </div>
        
        <div class="grid-container">
            <h3 style="color: #1d3160; margin-bottom: 15px;">Submission History</h3>
            <table id="GridView1" class="styled-grid">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Technology</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Review Date</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[ID]</td>
                        <td>[Title]</td>
                        <td>[Tech]</td>
                        <td>[Subject]</td>
                        <td>[Status]</td>
                        <td>[Date]</td>
                        <td>[Comments]</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>
</body>
</html>