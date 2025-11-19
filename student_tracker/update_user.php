<?php
include 'db_connect.php';

$user_id = $_POST['user_id'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];

$sql = "UPDATE users SET fullname='$fullname', email='$email' WHERE user_id=$user_id";

if ($conn->query($sql)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}
?>
