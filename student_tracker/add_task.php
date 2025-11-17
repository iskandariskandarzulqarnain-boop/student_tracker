<?php
session_start();
include 'db_connect.php';

// — Sementara, kalau belum login, tetapkan user_id manual
// (nanti boleh guna $_SESSION['user_id'])
$user_id = 1;

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO tasks (user_id, title, description, due_date, status)
            VALUES ('$user_id', '$title', '$description', '$due_date', '$status')";

    if ($conn->query($sql) === TRUE) {
        $message = "<p class='success'>✅ Task added successfully!</p>";
    } else {
        $message = "<p class='error'>❌ Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Task</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f7fb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #333; }
        input, textarea, select, button {
            width: 100%;
            margin: 8px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background-color: #4361ee;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #3f37c9;
        }
        .success { color: green; text-align:center; }
        .error { color: red; text-align:center; }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Add New Task</h2>
        <?= $message; ?>
        <input type="text" name="title" placeholder="Task Title" required>
        <textarea name="description" placeholder="Task Description" rows="4"></textarea>
        <input type="date" name="due_date" required>
        <select name="status">
            <option value="Pending">Pending</option>
            <option value="Completed">Completed</option>
        </select>
        <button type="submit">Add Task</button>
    </form>
</body>
</html>
