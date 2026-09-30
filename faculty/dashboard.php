<?php require_once __DIR__ . '/../contoler/db.php'; 
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit();
}
if ($_SESSION['role'] != 'faculty') {
    header("Location: ../public/home.php");
    exit();
}
$fact = mysqli_query($conn, "SELECT tblfaculty.*, subject.subject FROM tblfaculty, `user`, subject WHERE `user`.uid=tblfaculty.uid AND subject.subid=tblfaculty.subid AND tblfaculty.uid = '{$_SESSION['uid']}'");
$faculty = mysqli_fetch_assoc($fact);
$Projects = mysqli_query($conn, "SELECT * FROM tblproject where subid = '{$faculty['subid']}'");

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <title>Faculty Dashboard</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
</head>
<body> 
<form id="form1">
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <span style="float: right; margin:  0 0; font-size: 18px; font-weight: bold; color: green;">Faculty: <?php echo htmlspecialchars($faculty['fname']); ?></span>
        <a id="hidash" class="nav-link" href="/Faculty/dashboard.aspx">Dashboard</a>
        <a id="hlhome" class="nav-link" href="/Faculty/home.aspx">Home</a>
        <a id="hllout" class="nav-link" href="#">Log Out</a>
    </div>
    <div class="sidebar">
        <a id="Ibtnpro" href="profile.php">My Profile</a>
        <a id="Ibtnproject" href="reviewproject.php">Student Projects</a>
        <a id="Ibtnresult" href="grad.php">Student Results</a>
        <a id="Ibtnupwd" href="pwdchange.php">Password Change</a>
        <a id="Ibtlout" href="../public/logout.php">Log Out</a>
    </div>
    <div class="contant">
        <h1>Faculty Dashboard</h1>
        <div class="statusbar">
            <div class="card"><h3>Faculty Name</h3><span id="lblFacultyName"><?php echo htmlspecialchars($faculty['fname']); ?></span></div>
            <div class="card"><h3>Faculty ID</h3><span id="IbIFID"><?php echo htmlspecialchars($faculty['fid']); ?></span></div>
            <div class="card"><h3>Subject</h3><span id="lblSubject"><?php echo htmlspecialchars($faculty['subject']); ?></span></div>
            <div class="card"><h3>Total Projects</h3><span id="lblProjects"><?php echo htmlspecialchars(mysqli_num_rows($Projects)); ?></span></div>
        </div>
    </div>
</form>
</body>
</html>