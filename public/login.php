<?php

require_once __DIR__. '/../contoler/db.php';
$error_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username=$_POST['username'];
$password=$_POST['password'];
$hashed_password = "";
$hashed_password = md5($password);

$login=mysqli_query($conn,"select * from user where username='$username' and password='$hashed_password' and status='Active'");
if (mysqli_num_rows($login)>0) {
    $result=mysqli_fetch_assoc($login);
    $_SESSION['uid']=$result['uid'];
    $_SESSION['username']=$result['username'];
    $_SESSION['role']=$result['role'];

    if ($_SESSION['role']=='admin')
    {
        header("Location: ../admin/dashboard.php");
        exit();
        }
    elseif($_SESSION['role']=='faculty'){
           header("Location: ../faculty/dashboard.php");
        exit();
           }
    elseif($_SESSION['role']=='student'){
        header("Location:  ../student/dashboard.php");
        exit();
    }
    else{
        header("Location: ../public/home.php");
        exit();
    }}
else{
    $error_message = "Invalid username or password.";

}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project-Gate | Login</title>
    <link href="../Styles/index.css" rel="stylesheet" type="text/css" />
</head>
<body style="background-color: #f4f7f6; font-family: Arial, sans-serif;">

    <div class="login-container" style="width: 350px; margin: 100px auto; padding: 30px; background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        
        <!-- Header Section -->
        <div style="text-align: center; margin-bottom: 25px;">
            <h2 style="color: #333; margin: 0 0 10px 0;">Project-Gate</h2>
            <p style="color: #666; font-size: 14px; margin: 0;">Please sign in to continue</p>
        </div>
        <?php if (!empty($error_message)) : ?>
            <div style="color: #d9534f; background-color: #f2dede; border: 1px solid #ebccd1; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="login.php" method="POST">
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="username" style="display: block; margin-bottom: 5px; color: #333; font-weight: bold; font-size: 14px;">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-size: 14px;" />
            </div>
            
            <div class="form-group" style="margin-bottom: 25px;">
                <label for="password" style="display: block; margin-bottom: 5px; color: #333; font-weight: bold; font-size: 14px;">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-size: 14px;" />
            </div>
            
            <button type="submit" style="width: 100%; padding: 12px; background-color: #0056b3; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; font-weight: bold; transition: background-color 0.3s;">
                Log In
            </button>
            
        </form>

        <!-- Footer / Navigation -->
        <div style="text-align: center; margin-top: 20px;">
            <a href="home.php" style="color: #0056b3; text-decoration: none; font-size: 14px;">&larr; Back to Home</a>
        </div>

    </div>

</body>
</html>
