<?php
include 'db_connect.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $user_id = $_POST['user_id'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';

    if($user_id && $fullname && $email && $role){
        $stmt = $conn->prepare("UPDATE users SET fullname=?, email=?, role=? WHERE user_id=?");
        $stmt->bind_param("sssi",$fullname,$email,$role,$user_id);
        $stmt->execute();
        $stmt->close();
    }
}
header("Location: user_management.php");
exit;
?>
