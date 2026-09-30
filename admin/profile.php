<?php require_once __DIR__ . '/../contoler/db.php'; 
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit();
}
if ($_SESSION['role'] != 'admin') {
    header("Location: ../public/home.php");
    exit();
}



if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txtusername'], $_POST['txtemail'])) {
    
        $username = mysqli_real_escape_string($conn, $_POST['txtusername']);
        $email = mysqli_real_escape_string($conn, $_POST['txtemail']);

        // Update the user's profile in the database
        $updateQuery = "UPDATE `user` SET username='$username', email='$email' WHERE uid='"  . $_SESSION['uid'] . "';";
        if(mysqli_query($conn, $updateQuery)) {
            scriptAlert("Profile updated successfully.");
        }
        else {
            scriptAlert("Error updating profile: " . mysqli_error($conn));
        }
    }
function scriptAlert($updatedMessage) {
    echo "<script>alert('" . addslashes($updatedMessage) . "');</script>";
    
}  
$udata=mysqli_query($conn,"select * from user where uid='".$_SESSION['uid']."'");
$userdata = mysqli_fetch_assoc($udata);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Update Profile - Admin</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
    <style>
        .profile-container{margin-top:30px;max-width:600px;} 
        .auth-card{background:#ffffff; border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05);border:1px solid #e0e0e0;overflow:hidden;} 
        .auth-header{background:linear-gradient(to right,#1d3160,#2557d6);color:white;padding:25px 30px;} 
        .auth-header h2{margin:0 0 5px 0;font-size:22px;font-weight:bold;} 
        .auth-body{padding:30px;} 
        .form-group{margin-bottom:20px;} 
        .form-group label{display:block;font-weight:600;color:#333;margin-bottom:8px;font-size:14px;} 
        .form-control{width:100%; padding:12px 15px;box-sizing:border-box;border:1px solid #ced4da;border-radius:6px;font-size:14px;} 
        .auth-footer{padding:20px 30px; border-top:1px solid #eaeaea; display: flex; justify-content:flex-end;background-color:#fcfcfc;} 
        .btn-submit{background-color:#2b5add;color:white;border:none; padding: 10px 25px;font-size:15px;border-radius: 6px;cursor:pointer;font-weight:bold;} 
        .btn-submit:hover{background-color:#1c45b5;}
    </style>
</head>
<body> 
<form id="form1" method="post" action="profile.php">
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <span id="lbluname" style="float: right; margin:  0 0; font-size: 18px; font-weight:bold; color:#0077BE;"><?php echo htmlspecialchars($userdata['username']); ?></span>
    </div>
    <div id="pnsidebar" class="sidebar"><br /><br /><br />
        <a id="lbtndash" href="dashboard.php">Dashboard</a>
        <a id="Ibtnfact" href="profile.php" style="font-weight:bold; color:#ffeb3b;">Profile</a>
        <a id="Ibtnstud0" href="studmang.php">Students</a>
        <a id="Ibtnfact" href="factmang.php">Facultys</a> 
        <a id="lbtupwd" href="pwdchange.php">Password Change</a>
        <a id="lbtnaddu" href="adduser.php">Add User</a>
        <a id="LinkButton1" href="../public/logout.php">Log Out</a><br/>
    </div>
    <div class="contant">
        <div class="profile-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>Account Settings</h2>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Update your administrator contact details</p>
                </div>
                <div class="auth-body">
                    <span id="lblMsg" style="font-weight:bold; margin-bottom:15px; display:block;"></span>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" id="txtUsername" name="txtusername" class="form-control" required value="<?php echo htmlspecialchars($userdata['username']); ?>" />
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="txtEmail" name="txtemail" class="form-control" required pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$" value="<?php echo htmlspecialchars($userdata['email']); ?>" />
                    </div>
                </div>
                <div class="auth-footer">
                    <button type="submit" id="btnUpdateProfile" class="btn-submit">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>