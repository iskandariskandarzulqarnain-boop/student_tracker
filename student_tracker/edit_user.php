<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $email = $_POST['email'];
    $faculty = $_POST['faculty'];
    $status = $_POST['status'];

    $conn->query("UPDATE users SET name='$name', student_id='$student_id', email='$email', faculty='$faculty', status='$status' WHERE id=$id");
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit User</title></head>
<body>
    <h2>Edit User</h2>
    <form method="POST" action="edit_user.php">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= $user['name'] ?>"><br><br>
        <label>Student ID:</label><br>
        <input type="text" name="student_id" value="<?= $user['student_id'] ?>"><br><br>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= $user['email'] ?>"><br><br>
        <label>Faculty:</label><br>
        <input type="text" name="faculty" value="<?= $user['faculty'] ?>"><br><br>
        <label>Status:</label><br>
        <select name="status">
            <option <?= $user['status']=='Active'?'selected':'' ?>>Active</option>
            <option <?= $user['status']=='Inactive'?'selected':'' ?>>Inactive</option>
        </select><br><br>
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
