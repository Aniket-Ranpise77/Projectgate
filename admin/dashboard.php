<?php require_once __DIR__ . '/../contoler/db.php';
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit();
}
if ($_SESSION['role'] != 'admin') {
    header("Location: ../public/home.php");
    exit();
}

$facultys = mysqli_query($conn, "SELECT tblfaculty.*   FROM tblfaculty,`user`   where `user`.uid=tblfaculty.uid  ");
$students = mysqli_query($conn, "SELECT tblstud.* FROM tblstud,`user` where `user`.uid=tblstud.uid ");
$Projects = mysqli_query($conn, "SELECT * FROM tblproject where status='Approved' ");
$pandingProjects = mysqli_query($conn, "SELECT * FROM tblproject where status='Pending' and status='Need Modification' ");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Project-Gate Admin Dashboard</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <form id="form1">
        <div id="Panel1" class="topbar">
            <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
            <span id="lbluname" style="margin: 0; color:dimgrey;">Welcome : <?php echo $_SESSION['username']; ?></span>
            <span id="Label20"></span>
            <div class="topbar-right">
                <a id="hidash" class="nav-link" href="dashboard.php">Dashboard</a>
                <a id="hlhome" class="nav-link" href="home.php">Home</a>
                <a id="hllout" class="nav-link" href="../public/logout.php" type="button" style="border:none; background:none;">Log Out</a>
            </div>
        </div>

        <div id="pnsidebar" class="sidebar">
            <br /><br />
            
            <a id="lbtnstud" href="studmang.php">Students</a>
            <a id="Ibtnfact" href="factmang.php">Facultys</a>
            <a id="lbtpro" href="profile.php">Update Profile</a>
            <a id="Ibtupwd" href="pwdchange.php">Password Change</a>
            <a id="Ibtnaddu" href="adduser.php">Add User</a>
            <a id="Ibtlout" href="../public/logout.php">Log Out</a>
        </div>

        <div id="pnicontant" class="contant">
            <div class="statusbar">
                <div class="card"><span id="Label1">Total Students</span><span id="Ibiscount"><?php echo mysqli_num_rows($students) ?></span></div>
                <div class="card"><span id="Label3">Total Faculty</span><span id="lbifcount"><?php echo mysqli_num_rows($facultys) ?></span></div>
                <div class="card"><span id="Label5">Aproved Project</span><span id="Ibiforms"><?php echo mysqli_num_rows($Projects) ?></span></div>
                <div class="card"><span id="Label7">Project to Aprove</span><span id="lblaform"><?php echo mysqli_num_rows($pandingProjects) ?></span></div>
            </div>
        </div>
    </form>
</body>

</html>