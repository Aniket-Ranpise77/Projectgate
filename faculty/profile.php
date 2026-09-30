<?php require_once __DIR__ . '/../contoler/db.php';
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit();
}
if ($_SESSION['role'] != 'faculty') {
    header("Location: ../public/home.php");
    exit();
}
function scriptAlert($message) {
    echo "<script>alert('$message');</script>";
}
$subjects = mysqli_query($conn, "SELECT * FROM subject");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txtfname'], $_POST['txtlname'], $_POST['txtemail'], $_POST['ddlsubject'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['txtfname']);
    $lname = mysqli_real_escape_string($conn, $_POST['txtlname']);
    $email = mysqli_real_escape_string($conn, $_POST['txtemail']);
    $subid = mysqli_real_escape_string($conn, $_POST['ddlsubject']);
    
    // Update the faculty's profile in the database
    $updateFacultyQuery = mysqli_query($conn, "UPDATE `tblfaculty` SET `subid`='$subid',`fname`='$fname',`lname`='$lname' WHERE  uid='" . $_SESSION['uid'] . "'");
    $updateUserQuery = mysqli_query($conn, "UPDATE `user` SET email='$email' WHERE uid='" . $_SESSION['uid'] . "'");

    if ($updateFacultyQuery && $updateUserQuery) {
        scriptAlert('Profile updated successfully.');

    } else {
        scriptAlert('Error updating profile: ' . mysqli_error($conn));
    }
}
$fact=mysqli_query($conn, "SELECT tblfaculty.*, subject.subject FROM tblfaculty, `user`, subject WHERE `user`.uid=tblfaculty.uid AND subject.subid=tblfaculty.subid AND tblfaculty.uid = '{$_SESSION['uid']}'");
$faculty = mysqli_fetch_assoc($fact);
$udata=mysqli_query($conn, "SELECT * FROM `user` WHERE uid = '{$_SESSION['uid']}'");
$user = mysqli_fetch_assoc($udata);
$_SESSION['username'] = $faculty['fname'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Faculty Profile</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
</head>
<body> 
<form id="form1" method="POST" action="profile.php">
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <span style="float: right; margin: 0 0; font-size: 18px; font-weight: bold; color: green;">Faculty: <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a id="hidash" class="nav-link" href="/Faculty/dashboard.aspx">Dashboard</a>
        <a id="hlhome" class="nav-link" href="/Faculty/home.aspx">Home</a>
        <a id="hllout" class="nav-link" href="#">Log Out</a>
    </div>
    <div id="pnsidebar" class="sidebar">
        <a id="lbtndash" href="dashboard.php">Dashboard</a>
        <a id="Ibtnproject" href="reviewproject.php">Student Projects</a>
        <a id="Ibtnfact" href="profile.php" style="font-weight:bold; color:#ffeb3b;">Profile</a>
        <a id="Ibtnresult" href="grad.php">Student Results</a>
        <a id="Ibtnupwd" href="pwdchange.php">Password Change</a>
        <a id="Ibtlout" href="../public/logout.php">Log Out</a>
    </div>
    <div id="pnicontant" class="contant">
        <div class="page-header">
            <div><h1>Faculty Profile</h1><p>Manage your faculty profile and information.</p></div>
        </div>
        <div class="content-card">
            <h2>Faculty Information</h2><p>View and manage your faculty information.</p>
            <div class="form-body">
                <div class="form-group">
                    <label id="Iblfname" class="form-label">First Name</label>
                    <input type="text" id="txtfname" name="txtfname" class="form-input" required value="<?php echo htmlspecialchars($_SESSION['username']); ?>" />
                </div>
                <div class="form-group">
                    <label id="Ibliname" class="form-label">Last Name</label>
                    <input type="text" name="txtlname" id="txtlname" class="form-input" required value="<?php echo htmlspecialchars($faculty['lname']); ?>" />
                </div>
                <div class="form-group">
                    <label id="lblemail" class="form-label">Email</label>
                    <input type="email"  name="txtemail" id="txtemail" class="form-input" required value="<?php echo htmlspecialchars($user['email']); ?>" />
                </div>
                <div class="form-group">
                    <label id="lblSubject" class="form-label">Subject</label>
                    <select id="ddlsubject" name="ddlsubject" class="form-input" required>
                        <option value="">Select Subject</option>
                     <?php 
                        echo '<option value="' . htmlspecialchars($faculty['subid']) . '" selected>' . htmlspecialchars($faculty['subject']) . '</option>';
                     
                     while ($subject = mysqli_fetch_assoc($subjects)) {
                         echo '<option value="' . htmlspecialchars($subject['subid']) . '">' . htmlspecialchars($subject['subject']) . '</option>';
                     }
                     ?>   <!-- Options generated by backend -->
                    </select>
                    <br /><br />
                    <span id="lblMsg" style="font-weight:bold;"></span>
                    <br /><br />
                    <button type="submit" id="btnUpdate" class="btn btn-primary">Update Profile</button>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>