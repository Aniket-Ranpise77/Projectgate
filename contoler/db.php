<?php
session_start();
$conn = new mysqli("localhost", "root", "", "project_gate");
if ($conn->connect_error) {
    die("Connection Error: " . $conn->connect_error);
    
}

$current_page = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['uid']) && $current_page != 'login.php' && $current_page != 'home.php') {
    $_SESSION['error_message'] = "Login Required";
    header("Location: ../public/login.php");
    exit();
}

?>