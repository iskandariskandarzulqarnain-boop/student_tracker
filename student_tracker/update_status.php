<?php
include 'db_connect.php';

$id = $_GET['id'];
$status = $_GET['status'];

$sql = "UPDATE users SET status='$status' WHERE id=$id";

$conn->query($sql);

header("Location: users.php");
?>
