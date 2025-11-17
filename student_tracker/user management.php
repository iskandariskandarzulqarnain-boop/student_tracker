<?php
include 'db_connect.php';

// Fetch all users
$sql = "SELECT * FROM users ORDER BY user_id ASC";
$result = $conn->query($sql);
$users = [];
if ($result && $result->num_rows > 0) {
    while($r = $result->fetch_assoc()) $users[] = $r;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>User Management | Admin Panel</title>
<style>
/* --- styling ringkas pastel (sama theme) --- */
body { margin:0; font-family: 'Segoe UI', sans-serif; background:#f7f8fc; }
.sidebar { width:260px; height:100vh; background: linear-gradient(180deg,#ffb3c6,#b8e0f5); padding:30px 20px; position:fixed; border-right:2px solid #eee; }
.sidebar h2{ text-align:center; color:#333; margin:0 0 20px; }
.sidebar a{ display:block; padding:12px; margin:8px 0; background: rgba(255,255,255,0.6); text-decoration:none; border-radius:8px; color:#333; font-weight:500; }
.sidebar a.active{ background:white; font-weight:bold; }
.main { margin-left:280px; padding:24px; }
.card { background:white; padding:18px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.05); margin-bottom:16px; }
button { padding:8px 14px; border:none; border-radius:6px; cursor:pointer; }
.add-btn { background:#6fa3ef; color:#fff; }
.edit-btn { background:#ffa7c4; color:#000; }
.delete-btn { background:#ff6b6b; color:#fff; }

/* table */
table { width:100%; border-collapse: collapse; background:white; border-radius:8px; overflow:hidden; box-shadow:0 3px 10px rgba(0,0,0,0.06); }
th, td { padding:12px; border-bottom:1px solid #eee; text-align:left; }
th { background:#d8eefc; }

/* modal */
.modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.35); align-items:center; justify-content:center; z-index:1000; }
.modal.open { display:flex; }
.modal-content { background:#fff; padding:18px; border-radius:10px; width:420px; max-width:92%; box-shadow:0 6px 24px rgba(0,0,0,0.15); }
.modal-content h3 { margin-top:0; }
input, select { width:100%; padding:10px; margin:8px 0; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; }
.modal-actions { display:flex; gap:8px; justify-content:flex-end; margin-top:8px; }
.close-x { position:absolute; right:18px; top:12px; background:transparent; border:none; font-size:20px; cursor:pointer; }
small.info { color:#666; }
</style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin.php">Dashboard</a>
    <a href="user_management.php" class="active">User Management</a>
    <a href="course_management.php">Course Management</a>
    <a href="system_settings.php">System Settings</a>
    <a href="reports.php">Reports</a>
    <a href="backup_restore.php">Backup & Restore</a>
    <a href="logout.php" style="color:red;">Logout</a>
</div>

<div class="main">
    <h1>User Management</h1>

    <div class="card">
        <button class="add-btn" id="openAddBtn">+ Add User</button>
    </div>

    <div class="card">
        <table id="usersTable">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['user_id']) ?></td>
                    <td><?= htmlspecialchars($u['fullname']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['role']) ?></td>
                    <td>
                        <!-- gunakan data-json = data encoded secure -->
                        <button class="edit-btn js-edit"
                            data-user='<?= json_encode($u, JSON_HEX_APOS|JSON_HEX_QUOT) ?>'>Edit</button>
                        <button class="delete-btn js-delete" data-userid="<?= htmlspecialchars($u['user_id']) ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($users)): ?>
                <tr><td colspan="5"><em>No users found.</em></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ADD MODAL -->
<div class="modal" id="addModal" aria-hidden="true">
    <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="addTitle">
        <button class="close-x" data-close>&times;</button>
        <h3 id="addTitle">Add User</h3>
        <form id="addForm" action="user_add.php" method="POST">
            <input name="fullname" placeholder="Fullname" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="">-- Select Role --</option>
                <option>Admin</option>
                <option>Staff</option>
                <option>Student</option>
            </select>
            <div class="modal-actions">
                <button type="button" data-close>Cancel</button>
                <button type="submit" class="add-btn">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal" id="editModal" aria-hidden="true">
    <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="editTitle">
        <button class="close-x" data-close>&times;</button>
        <h3 id="editTitle">Edit User</h3>
        <form id="editForm" action="user_edit.php" method="POST">
            <input type="hidden" name="user_id" id="edit_user_id">
            <input name="fullname" id="edit_fullname" placeholder="Fullname" required>
            <input type="email" name="email" id="edit_email" placeholder="Email" required>
            <select name="role" id="edit_role" required>
                <option value="">-- Select Role --</option>
                <option>Admin</option>
                <option>Staff</option>
                <option>Student</option>
            </select>
            <div class="modal-actions">
                <button type="button" data-close>Cancel</button>
                <button type="submit" class="edit-btn">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal" id="deleteModal" aria-hidden="true">
    <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="deleteTitle">
        <button class="close-x" data-close>&times;</button>
        <h3 id="deleteTitle">Delete User</h3>
        <p class="info">Are you sure you want to delete this user?</p>
        <form id="deleteForm" action="user_delete.php" method="POST">
            <input type="hidden" name="user_id" id="delete_user_id">
            <div class="modal-actions">
                <button type="button" data-close>Cancel</button>
                <button type="submit" class="delete-btn">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
/* Bind when DOM ready */
document.addEventListener('DOMContentLoaded', function () {
    const openAddBtn = document.getElementById('openAddBtn');
    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');

    // Open add modal
    openAddBtn.addEventListener('click', () => openModal(addModal));

    // Delegate edit buttons
    document.querySelectorAll('.js-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            try {
                const data = JSON.parse(btn.getAttribute('data-user'));
                document.getElementById('edit_user_id').value = data.user_id || '';
                document.getElementById('edit_fullname').value = data.fullname || '';
                document.getElementById('edit_email').value = data.email || '';
                document.getElementById('edit_role').value = data.role || '';
                openModal(editModal);
            } catch (e) {
                console.error('Failed to parse user data', e);
            }
        });
    });

    // Delete buttons
    document.querySelectorAll('.js-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            const uid = btn.getAttribute('data-userid');
            document.getElementById('delete_user_id').value = uid;
            openModal(deleteModal);
        });
    });

    // Close on click [data-close]
    document.querySelectorAll('[data-close]').forEach(el => {
        el.addEventListener('click', (e) => {
            closeModal(e.target.closest('.modal'));
        });
    });

    // Close when clicking outside modal-content
    document.querySelectorAll('.modal').forEach(m => {
        m.addEventListener('click', (e) => {
            if (e.target === m) closeModal(m);
        });
    });

    // Close on Esc
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal.open').forEach(closeModal);
        }
    });

    // Helper open/close
    function openModal(modal) {
        if (!modal) return;
        modal.classList.add('open');
        modal.setAttribute('aria-hidden','false');
    }
    function closeModal(modal) {
        if (!modal) return;
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden','true');
    }

    // Debug: log to console so you can see script loaded
    console.log('User Management JS loaded. Modals ready.');
});
</script>

</body>
</html>
