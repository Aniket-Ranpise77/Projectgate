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
$users = mysqli_query($conn, "SELECT * FROM user");


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
    <title>Add User - Admin</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css" />
    <style>
        .form-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            border: 1px solid #e0e0e0;
            margin-bottom: 30px;
            max-width: 800px;
        }

        .form-header h1 {
            color: white;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .form-header p {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .button-group {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn-primary {
            background-color: #2b5add;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .grid-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            border: 1px solid #e0e0e0;
        }

        .styled-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .styled-grid th {
            background: linear-gradient(to right, #1d3160, #2557d6);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        .styled-grid td {
            padding: 15px;
            border-bottom: 1px solid #eaeaea;
            color: #495057;
            font-size: 14px;
        }

        .btn-action {
            background-color: #2b5add;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 5px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <form id="form1" method="post" action="adduser.php">
        <div id="Panel1" class="topbar">
            <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
            <div class="topbar-right">
                <a id="hldash" class="nav-link" href="dashboard.php">Dashboard</a>
                <a id="hlhome" class="nav-link" href="home.php">Home</a>
                <a id="hllout" class="nav-link" href="/public/logout.php">Log Out</a>
            </div>
        </div>
        <div id="pnsidebar" class="sidebar">
            <a id="Ibtidash" href="dashboard.php">Dashboard</a>
            <a id="Ibtnfact" href="adduser.php" style="font-weight:bold; color:#ffeb3b;">Add User</a>
            <a id="lbtnstud" href="studmang.php">Students</a>
            <a id="Ibtnfact" href="factmang.php">Facultys</a>
            <a id="lbtpro" href="profile.php">Update Profile</a>
            <a id="lbtupwd" href="pwdchange.php">Password Change</a>
            <a id="Ibtlout" href="../public/logout.php">Log Out</a>
        </div>
        <div id="pnicontant" class="contant">
            <div class="form-card">
                <div class="form-header">
                    <h1>Add New User</h1>
                    <p>Enter the user's information below</p>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label id="lblFirstName" class="form-label">Username</label>
                        <input type="text" id="txtuname" name="txtuname" class="form-input" required />
                    </div>
                    <div class="form-group">
                        <label id="lblLastName" class="form-label">Email</label>
                        <input type="email" id="txtemail" name="txtemail" class="form-input" required pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$" title="Invalid email format." />
                    </div>
                    <div class="form-group">
                        <label id="IblEmail" class="form-label">Password</label>
                        <input type="password" id="txtpwd" name="txtpwd" class="form-input" required />
                    </div>
                    <div class="form-group">
                        <label id="Label1" class="form-label">Role</label>
                        <select id="ddirole" name="ddirole" class="form-input" required>
                            <option value="">-- Select Role --</option>
                            <option value="admin">Admin</option>
                            <option value="faculty">Faculty</option>
                            <option value="student">Student</option>
                        </select>
                    </div>
                    <div class="checkbox-group" style="margin-bottom: 20px;">
                        <label class="custom-checkbox"><input type="checkbox" id="cbemail" name="cbemail" /> Send account information to the user by email</label>
                    </div>
                    <span id="lblsmg" style="font-weight:bold; grid-column: 1/-1; display:block; margin-bottom: 10px;"></span>
                    <div class="button-group">
                        <button type="submit" id="btnadd" name="btnadd" class="btn-primary">Add User</button>
                        <button type="reset" id="btnclear" name="btnclear" class="btn-secondary">Clear</button>
                    </div>
                </div>
            </div>
            <div class="grid-container">
                <h3 style="color: #1d3160; margin-bottom: 15px;">User Directory</h3>
                <table id="gvuser" class="styled-grid">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
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
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </form>
</body>

</html>