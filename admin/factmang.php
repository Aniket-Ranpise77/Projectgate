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
$users = mysqli_query($conn, "SELECT * FROM user where role='faculty' ");
$actusers = mysqli_query($conn, "SELECT * FROM user where role='faculty' and status='active'");
$actucount = mysqli_num_rows($actusers);
$ucount = mysqli_num_rows($users);
$newusers = mysqli_query($conn, "SELECT * FROM user where role='faculty' and status='pending'");
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
    <title>Faculty Management-Admin</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
    <style>
        .grid-container{background:white; border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05);padding:20px; margin-top:20px;border:1px solid #e0e0e0;} 
        .styled-grid{width:100%;border-collapse:collapse; margin-top:10px;} 
        .styled-grid th{background:linear-gradient(to right,#1d3160,#2557d6);color:white;padding: 15px;text-align:left;font-weight:600;font-size:14px;} 
        .styled-grid td{padding: 15px;border-bottom:1px solid #eaeaea;color:#495057;font-size: 14px;} 
        .styled-grid tr:hover{background-color:#f8f9fa;} 
        .btn-action{background-color:#2b5add;color:white;border:none;padding: 8px 15px; border-radius:4px;cursor:pointer;font-weight:bold;} 
        .btn-action:hover{background-color:#1c45b5;} 
        .btn-primary{background-color:#2b5add;color:white; border:none; padding:10px 20px;border-radius:4px;cursor:pointer;font-weight:bold;} 
        .status-badge{padding:6px 12px;border-radius: 20px; font-size:12px;font-weight:bold;display:inline-block;} 
        .status-active{background-color:#d4edda;color:#155724;} 
        .status-pending{background-color:#fff3cd;color:#856404;} 
        .status-inactive{background-color:#f8d7da;color:#721c24;} 
        .student-page-header{display: flex; justify-content:space-between; align-items:center;margin-bottom:20px;} 
        .student-page-header h1{color:#1d3160;margin:0 0 5px 0;} 
        .student-page-header p{color:#666;margin:0;font-size:14px;}
    </style>
</head>
<body> 
<form id="form1">
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <div class="topbar-right">
            <span style="float: left; margin: 15px 20px 0 0; font-size: 16px; font-weight: bold; color: white;">Admin: [Username]</span>
            <a id="hidash" class="nav-link" href="dashboard.php">Dashboard</a>
            <a id="hlhome" class="nav-link" href="home.php">Home</a>
            <a id="hllout" class="nav-link"  href="../public/logout.php" type="button" style="border:none; background:none;">Log Out</a>
        </div>
    </div>
    <div id="pnsidebar" class="sidebar">
        <a id="lbtndash" href="dashboard.php">Dashboard</a>
        <a id="lbtnstud" href="studmang.php">Students</a>
        <a id="Ibtnfact" href="factmang.php" style="font-weight:bold; color:#ffeb3b;">Facultys</a>
        <a id="Ibtpro" href="profile.php">Update Profile</a>
        <a id="lbtupwd" href="pwdchange.php">Password Change</a>
        <a id="Ibtnaddu" href="adduser.php">Add User</a>
        <a id="Ibtlout" href="../public/logout.php">Log Out</a>
    </div>
    <div id="pnicontant" class="contant">
        <div class="student-page-header">
            <div><h1>Faculty Management</h1><p>Manage and monitor faculty information</p></div>
            <a id="btnaddfaculty" type="button" href="addfact." class="btn-primary">+ Add Faculty</a>
        </div>
        <div class="statusbar">
            <div class="card">
                <h3>Recent Faculty</h3><span id="Label10" class="card-description">Total Faculty</span><br/>
                <span id="Ibifcount" class="metric" style="font-weight:bold; font-size:x-large;"><?php echo $ucount  ?></span>
            </div>
            <div class="card">
                <h3>Active Faculty</h3><span id="IblactiveText" class="card-description">Currently Active</span><br/>
                <span id="lblacount" class="metric" style="font-weight:bold; font-size:x-large;"><?php echo $actucount  ?></span>
            </div>
            <div class="card">
                <h3>New Faculty</h3><span id="Label19" class="card-description">Pending Accounts</span><br/>
                <span id="Ibinewstd" class="metric" style="font-weight:bold; font-size:x-large;"><?php echo $newucount; ?></span>
            </div>
        </div>
        <div class="grid-container">
            <h3 style="color: #1d3160; margin-bottom: 15px;">Faculty Accounts</h3>
            <table id="gvfaculty" class="styled-grid">
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
                    <!-- Example Data Row -->
                    <tr>
                       <?php
                        while ($user = mysqli_fetch_assoc($users)) {
                            $statusClass = ($user['status'] === 'active') ? 'status-active' : (($user['status'] === 'pending') ? 'status-pending' : 'status-inactive');
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
                        <?php
                        }
                        ?></tr>
                </tbody>
            </table>
        </div>
    </div>
</form>
</body>
</html>