<?php
include 'db_connect.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $user_id = $_POST['user_id'];
    $fullname = $_POST['fullname'];
    $student_id = $_POST['student_id'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $faculty = $_POST['faculty'];
    $program = $_POST['program'];

    $sql = "UPDATE users SET
        fullname='$fullname',
        student_id='$student_id',
        email='$email',
        phone='$phone',
        faculty='$faculty',
        program='$program'
        WHERE user_id=$user_id";

    if($conn->query($sql)){
        echo "Profile updated successfully!";
    } else {
        echo "Error: ".$conn->error;
    }
}
?>
