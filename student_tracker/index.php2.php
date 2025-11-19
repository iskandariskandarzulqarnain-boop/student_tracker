<?php
include 'config.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_student'])) {
        // Add new student
        $name = $_POST['name'];
        $student_id = $_POST['student_id'];
        $email = $_POST['email'];
        $faculty = $_POST['faculty'];
        $status = $_POST['status'];
        
        $sql = "INSERT INTO students (name, student_id, email, faculty, status) 
                VALUES ('$name', '$student_id', '$email', '$faculty', '$status')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Student added successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
    } elseif (isset($_POST['update_student'])) {
        // Update student
        $id = $_POST['id'];
        $name = $_POST['name'];
        $student_id = $_POST['student_id'];
        $email = $_POST['email'];
        $faculty = $_POST['faculty'];
        $status = $_POST['status'];
        
        $sql = "UPDATE students SET 
                name='$name', student_id='$student_id', email='$email', 
                faculty='$faculty', status='$status' 
                WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Student updated successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
    } elseif (isset($_POST['delete_student'])) {
        // Delete student
        $id = $_POST['id'];
        
        $sql = "DELETE FROM students WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Student deleted successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

// Fetch all students
$sql = "SELECT * FROM students ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ST Student Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>ST Student Tracker</h1>
            <h2>Admin Panel</h2>
            <p>Manage users, courses, and system settings</p>
        </header>

        <section class="user-management">
            <h3>User Management</h3>
            
            <?php if (isset($message)): ?>
                <div class="alert success"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="add-student-form">
                <h4>Add New Student</h4>
                <form method="POST">
                    <div class="form-row">
                        <input type="text" name="name" placeholder="Name" required>
                        <input type="text" name="student_id" placeholder="Student ID" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="text" name="faculty" placeholder="Faculty" required>
                        <select name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <button type="submit" name="add_student">Add Student</button>
                    </div>
                </form>
            </div>

            <div class="students-table">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Email</th>
                            <th>Faculty</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['student_id']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['faculty']; ?></td>
                                    <td>
                                        <span class="status <?php echo strtolower($row['status']); ?>">
                                            <?php echo $row['status']; ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <form method="POST" class="inline-form">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                                            <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                                            <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                                            <input type="hidden" name="faculty" value="<?php echo $row['faculty']; ?>">
                                            <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
                                            <button type="submit" name="update_student" class="btn-edit">Edit</button>
                                        </form>
                                        <form method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_student" class="btn-delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="no-data">No students found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>
<?php $conn->close(); ?>