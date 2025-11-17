<?php
include 'db_connect.php';
session_start();

$message = '';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Simpan sesi pengguna
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['fullname'] = $row['fullname'];

            // Redirect ke dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "<p class='error'>❌ Invalid password. Please try again.</p>";
        }
    } else {
        $message = "<p class='error'>⚠️ No account found with that email.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Student Tracker</title>
    <style>
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #4361ee;
            margin-bottom: 20px;
        }
        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }
        label {
            font-weight: 500;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            font-size: 1rem;
        }
        input:focus {
            border-color: #4361ee;
            box-shadow: 0 0 3px rgba(67, 97, 238, 0.3);
        }
        button {
            background-color: #4361ee;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #3f37c9;
        }
        .message {
            margin-top: 15px;
            font-size: 0.9rem;
        }
        .error {
            color: red;
        }
        .register-link {
            margin-top: 15px;
            display: block;
            color: #4361ee;
            text-decoration: none;
        }
        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>🔐 Login to Student Tracker</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" name="login">Login</button>
        </form>

        <div class="message"><?php echo $message; ?></div>

        <a href="register.php" class="register-link">Don’t have an account? Sign up here</a>
    </div>
</body>
</html>
