<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'db_connect.php';

// sementara, nanti boleh guna $_SESSION['user_id']
$user_id = 1;

$sql = "SELECT * FROM tasks WHERE user_id = $user_id ORDER BY due_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tasks | Student Tracker</title>
<style>
  body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background-color: #f8faff;
    margin: 0;
  }

  header {
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 15px 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  header h1 {
    color: #3a0ca3;
    font-size: 22px;
  }

  nav a {
    color: #333;
    margin-left: 20px;
    text-decoration: none;
  }

  nav a.active {
    color: #4361ee;
    font-weight: bold;
  }

  main {
    max-width: 1100px;
    margin: 40px auto;
    padding: 20px;
  }

  h2 {
    color: #2b2d42;
    font-size: 26px;
  }

  p {
    color: #555;
  }

  .add-btn {
    background-color: #4361ee;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
  }

  .add-btn:hover {
    background-color: #3b52d0;
  }

  .task-container {
    margin-top: 30px;
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
  }

  .task-card {
    background: #fff;
    border-left: 5px solid #4361ee;
    border-radius: 12px;
    padding: 20px;
    width: 320px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.07);
    position: relative;
    transition: 0.2s;
  }

  .task-card:hover {
    transform: translateY(-4px);
  }

  .task-card h3 {
    margin: 0 0 10px;
    color: #1e1e1e;
  }

  .task-card .subject {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 10px;
  }

  .task-card .desc {
    font-size: 14px;
    color: #444;
    margin-bottom: 15px;
  }

  .task-card .date {
    color: #d90429;
    font-weight: 600;
    position: absolute;
    top: 20px;
    right: 20px;
  }

  .priority {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
  }

  .High { background-color: #ffe3e3; color: #d90429; }
  .Medium { background-color: #fff3cd; color: #856404; }
  .Low { background-color: #d4edda; color: #155724; }

  .actions {
    position: absolute;
    bottom: 15px;
    right: 15px;
  }

  .actions button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 18px;
    margin-left: 5px;
  }

  .actions button:hover { opacity: 0.7; }

  /* Modal */
  #addTaskModal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.4);
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }

  .modal-content {
    background: white;
    padding: 25px;
    border-radius: 10px;
    width: 380px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.2);
  }

  .modal-content h3 {
    text-align: center;
    margin-top: 0;
  }

  input, textarea, select {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
  }

  .btn {
    background: #4361ee;
    color: white;
    border: none;
    padding: 10px;
    width: 100%;
    border-radius: 6px;
    cursor: pointer;
  }

  .btn:hover {
    background: #3b52d0;
  }

  .cancel-btn {
    background: #aaa;
    margin-top: 8px;
  }
</style>
</head>
<body>

<header>
  <h1>📘 Student Tracker</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="tasks.php" class="active">Tasks</a>
    <a href="profile.php">Profile</a>
  </nav>
</header>

<main>
  <h2>My Tasks</h2>
  <p>Manage all your assignments and projects in one place</p>
  <button class="add-btn" id="openAddTaskModal">Add New Task</button>

  <div class="task-container">
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="task-card">
          <div class="date"><?= date('M d, Y', strtotime($row['due_date'])) ?></div>
          <h3><?= htmlspecialchars($row['title']) ?></h3>
          <div class="subject"><?= htmlspecialchars($row['description']) ?></div>
          <span class="priority <?= htmlspecialchars($row['status']) ?>">
            <?= htmlspecialchars($row['status']) ?> Priority
          </span>
          <div class="actions">
            <button title="Edit">✏️</button>
            <button title="Delete">🗑️</button>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No tasks added yet.</p>
    <?php endif; ?>
  </div>
</main>

<!-- Modal Add Task -->
<div id="addTaskModal">
  <div class="modal-content">
    <h3>Add New Task</h3>
    <form id="addTaskForm">
      <input type="text" name="title" placeholder="Task Title" required>
      <textarea name="description" placeholder="Task Description" required></textarea>
      <input type="date" name="due_date" required>
      <select name="status" required>
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option value="Low">Low</option>
      </select>
      <button type="submit" class="btn">Save Task</button>
      <button type="button" class="btn cancel-btn" id="closeAddTaskModal">Cancel</button>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('addTaskModal');
  const openBtn = document.getElementById('openAddTaskModal');
  const closeBtn = document.getElementById('closeAddTaskModal');
  const form = document.getElementById('addTaskForm');

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
      form.reset();
      modal.style.display = 'none';
      window.location.reload();
    })
    .catch(err => alert('Error: ' + err));
  });
});
</script>

</body>
</html>
