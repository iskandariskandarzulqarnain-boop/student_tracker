<?php
include 'db_connect.php';

$user_id = $_GET['user_id'];
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("User not found");
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #f4f6f9;
        }
        .card {
            border-radius: 12px;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card shadow p-4">
                    <h3 class="text-center mb-4">Edit User</h3>

                    <form method="POST" action="update_user.php">
                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="fullname" value="<?php echo $user['fullname']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="index.php" class="btn btn-secondary mt-2" style="width:100%;">Cancel</a>
                    </form>

                </div>

            </div>
        </div>
    </div>
</body>
</html>
