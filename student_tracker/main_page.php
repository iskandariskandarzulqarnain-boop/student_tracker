<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Task and Assignment Tracker</title>
    <style>
        /* Global Styles */
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
		  .welcome-section {
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
				text-align: center;
				padding: 80px 0;
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
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header Styles */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-container {
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
        
        .user-actions {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background-color: var(--light-gray);
        }
        
        /* Main Content Styles */
        main {
            padding: 30px 0;
            min-height: calc(100vh - 140px);
        }
        
        .page {
            display: none;
        }
        
        .page.active {
            display: block;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .page-description {
            color: var(--gray);
            font-size: 1.1rem;
        }
        
        /* Dashboard Styles */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }
        
        .stat-card-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        
        .stat-card-icon.primary {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }
        
        .stat-card-icon.warning {
            background-color: rgba(255, 204, 0, 0.1);
            color: var(--warning);
        }
        
        .stat-card-icon.danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }
        
        .stat-card-icon.success {
            background-color: rgba(75, 181, 67, 0.1);
            color: var(--success);
        }
        
        .stat-card-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-card-label {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .dashboard-sections {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        .dashboard-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .card-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
        }
        
        .card-actions {
            display: flex;
            gap: 10px;
        }
        
        .task-list {
            list-style: none;
        }
        
        .task-item {
            padding: 15px 0;
            border-bottom: 1px solid var(--light-gray);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .task-item:last-child {
            border-bottom: none;
        }
        
        .task-checkbox {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid var(--light-gray);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .task-checkbox.checked {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        .task-info {
            flex: 1;
        }
        
        .task-title {
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        .task-meta {
            display: flex;
            gap: 15px;
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        .task-priority {
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .priority-high {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }
        
        .priority-medium {
            background-color: rgba(255, 204, 0, 0.1);
            color: var(--warning);
        }
        
        .priority-low {
            background-color: rgba(75, 181, 67, 0.1);
            color: var(--success);
        }
        
        /* Tasks Page Styles */
        .tasks-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .filter-btn {
            padding: 8px 16px;
            border-radius: 20px;
            background-color: white;
            border: 1px solid var(--light-gray);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .filter-btn.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .task-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary);
        }
        
        .task-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .task-card-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        
        .task-card-course {
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        .task-card-due {
            font-size: 0.85rem;
            color: var(--danger);
            font-weight: 500;
        }
        
        .task-card-description {
            margin-bottom: 15px;
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .task-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .task-card-actions {
            display: flex;
            gap: 10px;
        }
        
        .action-btn {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--light-gray);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            background-color: var(--primary);
            color: white;
        }
        
        /* Calendar Styles */
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .calendar-nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background-color: var(--light-gray);
            border: 1px solid var(--light-gray);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .calendar-day-header {
            background-color: var(--light-gray);
            padding: 15px 10px;
            text-align: center;
            font-weight: 600;
        }
        
        .calendar-day {
            background-color: white;
            padding: 10px;
            min-height: 120px;
            display: flex;
            flex-direction: column;
        }
        
        .calendar-day.other-month {
            background-color: #f8f9fa;
            color: var(--gray);
        }
        
        .day-number {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .calendar-event {
            background-color: rgba(67, 97, 238, 0.1);
            border-left: 3px solid var(--primary);
            padding: 5px 8px;
            margin-top: 5px;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
        }
        
        .calendar-event.urgent {
            background-color: rgba(220, 53, 69, 0.1);
            border-left-color: var(--danger);
        }
        
        /* Profile Styles */
        .profile-container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }
        
        .profile-sidebar {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: var(--light-gray);
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--gray);
        }
        
        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .profile-role {
            color: var(--gray);
            margin-bottom: 20px;
        }
        
        .profile-stats {
            display: flex;
            justify-content: space-around;
            margin: 25px 0;
        }
        
        .profile-stat {
            text-align: center;
        }
        
        .profile-stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .profile-stat-label {
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        .profile-content {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .profile-tabs {
            display: flex;
            border-bottom: 1px solid var(--light-gray);
            margin-bottom: 25px;
        }
        
        .profile-tab {
            padding: 12px 20px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .profile-tab.active {
            border-bottom-color: var(--primary);
            color: var(--primary);
            font-weight: 500;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--light-gray);
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        /* Admin Styles */
        .admin-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
        }
        
        .admin-sidebar {
            background-color: white;
            border-radius: 10px;
            padding: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .admin-nav {
            list-style: none;
        }
        
        .admin-nav-item {
            padding: 12px 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .admin-nav-item:hover, .admin-nav-item.active {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            border-right: 3px solid var(--primary);
        }
        
        .admin-content {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .table th {
            background-color: var(--light-gray);
            font-weight: 600;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-active {
            background-color: rgba(75, 181, 67, 0.1);
            color: var(--success);
        }
        
        .status-inactive {
            background-color: rgba(108, 117, 125, 0.1);
            color: var(--gray);
        }
        
        /* About Styles */
        .about-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .about-section {
            margin-bottom: 30px;
        }
        
        .about-section:last-child {
            margin-bottom: 0;
        }
        
        .about-section-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary);
        }
        
        .team-members {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .team-member {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: var(--light);
            transition: all 0.3s ease;
        }
        
        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .member-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--light-gray);
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--gray);
        }
        
        .member-name {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .member-role {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        /* Footer Styles */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 30px 0;
        }
        
        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .footer-links {
            display: flex;
            gap: 20px;
        }
        
        .footer-links a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: var(--accent);
        }
        
        .copyright {
            color: var(--light-gray);
            font-size: 0.9rem;
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .dashboard-sections {
                grid-template-columns: 1fr;
            }
            
            .profile-container {
                grid-template-columns: 1fr;
            }
            
            .admin-container {
                grid-template-columns: 1fr;
            }
            
            .admin-sidebar {

                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .user-actions {
                width: 100%;
                justify-content: center;
            }
            
            .stats-cards {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            
            .tasks-grid {
                grid-template-columns: 1fr;
            }
            
            .calendar-grid {
                grid-template-columns: repeat(7, 1fr);
                font-size: 0.8rem;
            }
            
            .calendar-day {
                min-height: 80px;
                padding: 5px;
            }
            
            .footer-container {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <div class="logo-icon">ST</div>
                <span>Student Tracker</span>
            </div>
            
			<div class="user-actions">
				<a href="login.php" class="btn btn-outline">Login</a>
				<a href="register.php" class="btn btn-primary">Sign Up</a>
			</div>

        </div>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            <!-- Home Page -->
            <section id="home" class="page active">
                <div class="page-header">
                    <h1 class="page-title">Student Task and Assignment Tracker</h1>
                    <p class="page-description">Organize your assignments, track deadlines, and boost your productivity</p>
                </div>
				
				<div class="welcome-section">
					<div class="logo-icon" style="width:80px;height:80px;font-size:2.5rem;">HII</div>
					<h1 style="margin-top:15px;font-size:2.2rem;color:var(--primary);">WELCOME!</h1>
					<p style="font-size:1.1rem;color:var(--gray);margin-top:5px;">
						Start tracking your tasks and assignments today 🎓
					</p>
				</div>

				
				
    <!-- Footer -->
    <footer>
        <div class="container footer-container">
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Help Center</a>
                <a href="#">Contact Us</a>
            </div>
            <div class="copyright">
                &copy; 2025 Student Task and Assignment Tracker. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Navigation functionality
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const pages = document.querySelectorAll('.page');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links and pages
                    navLinks.forEach(l => l.classList.remove('active'));
                    pages.forEach(p => p.classList.remove('active'));
                    
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Show corresponding page
                    const pageId = this.getAttribute('data-page');
                    document.getElementById(pageId).classList.add('active');
                });
            });
            
            // Task checkbox functionality
            const taskCheckboxes = document.querySelectorAll('.task-checkbox');
            taskCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('click', function() {
                    this.classList.toggle('checked');
                    this.innerHTML = this.classList.contains('checked') ? '✓' : '';
                });
            });
            
            // Filter buttons functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Profile tabs functionality
            const profileTabs = document.querySelectorAll('.profile-tab');
            profileTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    profileTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Admin nav functionality
            const adminNavItems = document.querySelectorAll('.admin-nav-item');
            adminNavItems.forEach(item => {
                item.addEventListener('click', function() {
                    adminNavItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
	<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('addTaskModal');
  const openBtn = document.getElementById('openAddTaskModal');
  const closeBtn = document.getElementById('closeAddTaskModal');
  const form = document.getElementById('addTaskForm');

  if (openBtn && modal && form) {
    openBtn.addEventListener('click', () => modal.style.display = 'flex');
    closeBtn.addEventListener('click', () => modal.style.display = 'none');

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const formData = new FormData(form);

      fetch('add_task.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.text())
      .then(data => {
        alert(data);
        window.location.reload();
      })
      .catch(err => alert('Error: ' + err));
    });
  }
});
</script>
</body>
</html>