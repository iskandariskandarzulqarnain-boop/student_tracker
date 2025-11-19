<?php
include 'db_connect.php';

$user_id = $_GET['user_id'];

$sql = "DELETE FROM users WHERE user_id=$user_id";

if ($conn->query($sql)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}
?>
