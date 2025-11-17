<?php
include 'db_connect.php';

$id = $_POST['id'];
$name = $_POST['name'];
$student_id = $_POST['student_id'];
$email = $_POST['email'];
$faculty = $_POST['faculty'];

$sql = "UPDATE users SET 
        name='$name', 
        student_id='$student_id',
        email='$email',
        faculty='$faculty'
        WHERE id=$id";

if ($conn->query($sql)) {
    header("Location: users.php?success=updated");
} else {
    echo "Error updating record";
}
?>
