<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE user_id = $id";

    if ($conn->query($sql)) {
        echo "<script>alert('User deleted successfully'); window.location='users.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid ID";
}
?>
