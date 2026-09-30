<?php require_once __DIR__ . '/../contoler/db.php';
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit();
}
if ($_SESSION['role'] != 'admin') {
    header("Location: ../public/home.php");
    exit();
}



if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $stmt = $conn->prepare("DELETE FROM user WHERE uid = ?");
    $stmt->bind_param("i", $uid);
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting user: " . htmlspecialchars($stmt->error) . "');</script>";
    }
    $stmt->close();
}
if (isset($_GET['action']) && $_GET['action'] === 'change_status' && isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $stmt = $conn->prepare("SELECT status FROM user WHERE uid = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $stmt->bind_result($currentStatus);
    if ($stmt->fetch()) {
        $newStatus = ($currentStatus === 'Active') ? 'Inactive' : 'Active';
        $stmt->close();
        $updateStmt = $conn->prepare("UPDATE user SET status = ? WHERE uid = ?");
        $updateStmt->bind_param("si", $newStatus, $uid);
        if ($updateStmt->execute()) {
            echo "<script>alert('User status changed successfully.');</script>";
        } else {
            echo "<script>alert('Error changing user status: " . htmlspecialchars($updateStmt->error) . "');</script>";
        }
        $updateStmt->close();
    } else {
        echo "<script>alert('User not found.');</script>";
    }
}
$users = mysqli_query($conn, "SELECT * FROM user where role='student' ");
$actusers = mysqli_query($conn, "SELECT * FROM user where role='student' and status='active'");
$actucount = mysqli_num_rows($actusers);
$ucount = mysqli_num_rows($users);
$newusers = mysqli_query($conn, "SELECT * FROM user where role='student' and status='pending'");
$newucount = mysqli_num_rows($newusers);    

if (isset($_POST['btnadd'])) {
    $username = $_POST['txtuname'] ?? '';
    $email = $_POST['txtemail'] ?? '';
    $password = $_POST['txtpwd'] ?? '';
    $role = $_POST['ddirole'] ?? '';
    $sendEmail = isset($_POST['cbemail']);
    addUser($username, $email, $password, $role, $sendEmail);
}
function addUser(
    $username,
    $email,
    $password,
    $role,
    $sendEmail
) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO user (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    if ($stmt->execute()) {
        if ($sendEmail) {
            // Send email logic here
            mail($email, "Your Account Information", "Username: $username\nPassword: $password");
        }
        echo "<script>alert('User added successfully.');</script>";
    } else {
        echo "<script>alert('Error adding user: " . htmlspecialchars($stmt->error) . "');</script>";
    }
    $stmt->close();
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Student Management</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
    <style>
        .grid-container{background:white;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05); padding: 20px;margin-top:20px;border:1px solid #e0e0e0;} 
        .styled-grid{width:100%;border-collapse:collapse; margin-top:10px;} 
        .styled-grid th{background:linear-gradient(to right, #1d3160,#2557d6);color:white;padding:15px;text-align:left;font-weight:600;font-size:14px;} 
        .styled-grid td{padding: 15px;border-bottom:1px solid #eaeaea; color:#495057;font-size:14px;} 
        .styled-grid tr:hover{background-color:#f8f9fa;} 
        .btn-action{background-color:#2b5add;color:white; border:none;padding:8px 15px;border-radius:4px;cursor:pointer;font-weight:bold;} 
        .btn-action:hover{background-color:#1c45b5;} 
        .status-badge{padding:6px 12px; border-radius: 20px; font-size:12px;font-weight:bold;display:inline-block;} 
        .status-active{background-color:#d4edda;color:#155724;} 
        .status-pending{background-color:#fff3cd;color:#856404;} 
        .status-inactive{background-color:#f8d7da;color:#721c24;}
    </style>
</head>
<body> 
<form id="form1">
<div>
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <div class="topbar-right">
            <a id="hldash" class="nav-link" href="/Admin/dashboard.aspx">Dashboard</a>
            <a id="hlhome" class="nav-link" href="/Admin/home.aspx">Home</a>
            <button id="hllout" class="nav-link" type="button" style="border:none; background:none;">Log Out</button>
        </div>
    </div>
    
    <div id="pnsidebar" class="sidebar">
        <a id="Ibtndash" href="dashboard.php">Dashboard</a>
        <a id="Ibtnfact" href="studmang.php" style="font-weight:bold; color:#ffeb3b;">Students</a>
        <a id="lbtnfact" href="factmang.php">Facultys</a>
        <a id="lbtpro" href="profile.php">Update Profile</a>
        <a id="Ibtupwd" href="pwdchange.php">Password Change</a>
        <a id="lbtnaddu" href="adduser.php">Add User</a>
        <a id="Ibtlout" href="../public/logout.php">Log Out</a>
    </div>
    
    <div id="pnicontant" class="contant">
        <div class="student-page-header">
            <div><h1>Student Management</h1><p>Manage and monitor student information</p></div>
            <button id="btnaddstudent" type="button" class="btn btn-primary">+ Add Student</button>
        </div>
        
        <div class="statusbar">
            <div class="card">
                <h3><label id="Label9">Recent Students</label></h3>
                <span id="Ibiscount" class="card-number"><?php echo $ucount; ?></span>
                <span id="Label12" class="card-description">Updated Today</span>
            </div>
            <div class="card">
                <h3><label id="Iblstdac">Total Active Student</label></h3>
                <span id="lblacount" class="card-number"><?php echo $actucount; ?></span>
                <span id="lblactiveText" class="card-description">Currently Active</span>
            </div>
            <div class="card">
                <h3><label id="Label17">New Student</label></h3>
                <span id="Ibinewstd" class="card-number"><?php echo $newucount; ?></span>
                <span id="Label19" class="card-description">Today</span>
            </div>
        </div>
        
        <div class="grid-container">
            <h3 style="color: #1d3160; margin-bottom: 15px;">Student Accounts</h3>
            <table id="gvstud" class="styled-grid">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($user = mysqli_fetch_assoc($users)) {
                    $statuscase = strtolower($user['status']);
                    $statusClass = ($statuscase === 'active') ? 'status-active' : (($statuscase === 'pending') ? 'status-pending' : 'status-inactive');
                    ?>
                    <tr>

                                <td name="uname"><?php echo htmlspecialchars($user['username']) ?></td>
                                <td name="email"><?php echo htmlspecialchars($user['email']) ?></td>
                                <td name="role"><?php echo htmlspecialchars($user['role']) ?></td>
                                <td><span class="status-badge <?php echo $statusClass; ?>"><?php echo ucfirst($user['status']) ?></span></td>
                                <td>
                                    <a href="?action=change_status&uid=<?php echo $user['uid']; ?>" class="btn-action">Change Status</a>
                                    <a href="?action=delete&uid=<?php echo $user['uid']; ?>" class="btn-danger" onclick="return confirm('Are you sure you want to completely delete this user?');">Delete</a>
                                </td>
                                </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</form>
</body>
</html>