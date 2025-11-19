<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Student Tracker</title>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4bb543;
            --warning: #ffcc00;
            --danger: #dc3545;
            --gray: #6c757d;
            --light-gray: #e9ecef;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
        }

        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            width: 90%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

		
		
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
        }

        .logo-icon {
            background-color: var(--primary);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
		
		nav ul {
            display: flex;
            list-style: none;
            gap: 25px;
        }
        
        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        nav a:hover, nav a.active {
            background-color: var(--light-gray);
            color: var(--primary);
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-logout {
            background-color: var(--danger);
            color: white;
        }

        .btn-logout:hover {
            background-color: #b02a37;
        }

        main {
            width: 90%;
            margin: 40px auto;
        }

        h1 {
            color: var(--primary);
            margin-bottom: 10px;
        }

        .welcome {
            margin-bottom: 40px;
            font-size: 1.1rem;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .stat-title {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }

        th {
            background-color: var(--light-gray);
        }

        tr:hover {
            background-color: #f1f3f5;
        }

        .status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
        }

        .Pending {
            background-color: rgba(255, 204, 0, 0.1);
            color: var(--warning);
        }

        .Completed {
            background-color: rgba(75, 181, 67, 0.1);
            color: var(--success);
        }

        .Overdue {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }

        footer {
            margin-top: 50px;
            text-align: center;
            color: var(--gray);
            font-size: 0.9rem;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <header>
		
		
        <div class="header-container">
            <div class="logo">
                <div class="logo-icon">ST</div>
                <span>Student Tracker</span>
            </div>
			
		<nav>
                <ul>
                    <li><a href="index.php" class="nav-link active" data-page="home">Home</a></li>
                    <li><a href="dashboard.php" class="nav-link" data-page="dashboard">Dashboard</a></li>
                   
                    <li><a href="index.php" class="nav-link" data-page="admin">Admin</a></li>
                    <li><a href="" class="nav-link" data-page="about">About</a></li>
                </ul>
            </nav>
			
            <div class="user-section">
                <span>👋 Welcome, <strong><?php echo $_SESSION['fullname']; ?></strong></span>
                <a href="logout.php"><button class="btn btn-logout">Logout</button></a>
            </div>
        </div>
    </header>

    <main>
        <h1>Dashboard</h1>
        <p class="welcome">Here’s your current task summary and progress overview.</p>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-title">Active Tasks</div>
                <div class="stat-value">12</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Due This Week</div>
                <div class="stat-value">3</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Completed</div>
                <div class="stat-value">24</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Overdue</div>
                <div class="stat-value">1</div>
            </div>
        </div>

        <h2 style="margin-bottom:15px;">Your Latest Tasks</h2>
        <table>
            <thead>
                <tr>
                    <th>Task Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve tasks from database (optional)
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM tasks WHERE user_id='$user_id' ORDER BY due_date ASC LIMIT 10";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['title']}</td>
                                <td>{$row['description']}</td>
                                <td>{$row['due_date']}</td>
                                <td><span class='status {$row['status']}'>{$row['status']}</span></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align:center;'>No tasks found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        &copy; 2025 Student Task and Assignment Tracker. All rights reserved.
    </footer>
</body>
</html>
