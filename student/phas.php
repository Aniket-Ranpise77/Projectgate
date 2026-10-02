<?php
require_once __DIR__ . '/../contoler/db.php';

//$uid = 1; // Change this to the user's uid
$newPassword = md5('Pgate2026@');

$sql = "UPDATE `user` SET `password`='$newPassword'";

if (mysqli_query($conn, $sql)) {
    echo "Password changed successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>