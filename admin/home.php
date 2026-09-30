<?php require_once __DIR__ . '/../contoler/db.php';
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit();
}
if ($_SESSION['role'] != 'admin') {
    header("Location: ../public/home.php");
    exit();
}



$facultys = mysqli_query($conn, "SELECT tblfaculty.* ,subject.subject  FROM tblfaculty,`user`,subject   where `user`.uid=tblfaculty.uid and subject.subid=tblfaculty.subid  ");
$student = mysqli_query($conn, "SELECT tblstud.* FROM tblstud,`user` where `user`.uid=tblstud.uid ");
$projects = mysqli_query($conn, "SELECT * FROM tblproject ,tblstud where tblstud.uid=tblproject.uid ");


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>View Projects - Project-Gate</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
    <style>
        .grid-container{background:white; border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05); padding: 20px;margin-top:20px;border:1px solid #e0e0e0;} 
        .styled-grid{width:100%;border-collapse:collapse; margin-top:10px;margin-bottom:30px;} 
        .styled-grid th{background:linear-gradient(to right, #1d3160,#2557d6);color:white;padding:15px;text-align:left;font-weight:600;font-size:14px;} 
        .styled-grid td{padding: 15px;border-bottom:1px solid #eaeaea;color:#495057;font-size:14px;} 
        .styled-grid tr:hover{background-color:#f8f9fa;} 
        .status-badge{padding:6px 12px; border-radius: 20px;font-size:12px;font-weight:bold;display:inline-block;} 
        .status-completed{background-color:#d4edda;color:#155724;} 
        .status-progress{background-color:#fff3cd;color:#856404;} 
        .status-pending{background-color:#f8d7da;color:#721c24;}
    </style>
</head>
<body> 
<form id="form1">
<div>
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <span style="float: right; margin:   0 0; font-size: 18px; font-weight: bold; color: #0077BE;">Welcome, <?php echo $_SESSION['username'] ;?></span>
    </div>
    
    <div id="pnsidebar" class="sidebar"><br /><br />
        <a id="lbtndash" href="dashboard.php">Dashboard</a>
        <a id="Ibtnstud" href="studmang.php">Student</a>
        <a id="Ibtnfact" href="factmang.php">Faculty</a>
        <a id="Ibtpro" href="profile.php">Update Profile</a>
        <a id="LinkButton1" href="../public/logout.php">Log Out</a>
    </div>
    
    <div class="contant">
        <h1 style="color: #333; margin-bottom: 10px;">Project Database</h1>
        <p style="color: #666; margin-top: 0;">Overview of all submitted student projects and current statuses.</p>
        
        <div class="grid-container">
            <h3 style="color: #1d3160; margin-bottom: 10px;">Student Projects</h3>
            <table id="gvProjects" class="styled-grid">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Technology</th>
                        <th>Status</th>
                        <th>Review Date</th>
                    </tr>
                </thead>
                <tbody><?php while($project=mysqli_fetch_assoc($projects)){  
                    ?>
                    <!-- Data Rows Go Here -->
                    <tr>
                        <td><?php echo htmlspecialchars($project['title']) ?></td>
                        <td><?php echo htmlspecialchars($project['ddescription']) ?></td>
                        <td><?php echo htmlspecialchars($project['technology']) ?></td>
                        <td><span class="status-badge status-completed"><?php echo htmlspecialchars($project['status']) ?></span></td>
                        <td><?php echo htmlspecialchars($project['reviewdate'])?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <h3 style="color: #1d3160; margin-top: 20px; margin-bottom: 10px;">Faculty Directory</h3>
            <table id="GridView1" class="styled-grid">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Subject</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($faculty=mysqli_fetch_assoc($facultys)){
                        ?>
                    <tr>
                        <td><?php echo htmlspecialchars($faculty['fname']) ?></td>
                        <td><?php echo htmlspecialchars($faculty['lname']) ?></td>
                        <td><?php echo htmlspecialchars($faculty['subject']) ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <h3 style="color: #1d3160; margin-top: 20px; margin-bottom: 10px;">Student Directory</h3>
            <table id="GridView2" class="styled-grid">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Class</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($stud=mysqli_fetch_assoc($student)){
                        ?>
                    <tr>
                        <td><?php echo htmlspecialchars($stud['sname']) ?></td>
                        <td><?php echo htmlspecialchars($stud['lname']) ?></td>
                        <td><?php echo htmlspecialchars($stud['gender']) ?></td>
                        <td><?php echo htmlspecialchars($stud['class']) ?></td>
                        <td><?php echo htmlspecialchars($stud['year']) ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</form>
</body>
</html>