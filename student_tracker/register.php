<?php
include 'db_connect.php';
$message = '';

if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "<p class='success'>✅ Registration successful! <a href='login.php'>Click here to login</a></p>";
    } else {
        $message = "<p class='error'>❌ Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Student Tracker</title>
    <style>
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
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
        .success {
            color: green;
        }
        .error {
            color: red;
        }
        .login-link {
            margin-top: 15px;
            display: block;
            color: #4361ee;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>🧾 Create Account</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" name="register">Sign Up</button>
        </form>

        <div class="message"><?php echo $message; ?></div>

        <a href="login.php" class="login-link">Already have an account? Login here</a>
    </div>
</body>
</html>
