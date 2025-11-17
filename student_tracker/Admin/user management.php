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
<meta charset="UTF-8">
<title>User Management | Admin Panel</title>
<style>
body{margin:0;font-family:Segoe UI,sans-serif;background:#f7f8fc;}
.sidebar{width:260px;height:100vh;background:linear-gradient(180deg,#ffb3c6,#b8e0f5);padding:30px 20px;position:fixed;border-right:2px solid #eee;}
.sidebar h2{text-align:center;color:#333;margin-bottom:30px;}
.sidebar a{display:block;padding:12px;margin:8px 0;background:rgba(255,255,255,0.6);text-decoration:none;border-radius:8px;color:#333;font-weight:500;}
.sidebar a.active{background:white;font-weight:bold;}
.main{margin-left:280px;padding:25px;}
.card{background:white;padding:20px;border-radius:10px;box-shadow:0 3px 10px rgba(0,0,0,0.05);margin-bottom:20px;}
button{padding:10px 20px;border:none;border-radius:6px;cursor:pointer;margin:5px;}
.add-btn{background:#6fa3ef;color:#fff;}
.edit-btn{background:#ffa7c4;color:#000;}
.delete-btn{background:#ff6b6b;color:#fff;}
table{width:100%;border-collapse:collapse;background:white;border-radius:8px;overflow:hidden;box-shadow:0 3px 10px rgba(0,0,0,0.06);}
th,td{padding:12px;border-bottom:1px solid #eee;text-align:left;}
th{background:#d8eefc;}
.modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);align-items:center;justify-content:center;z-index:1000;}
.modal.open{display:flex;}
.modal-content{background:white;padding:20px;border-radius:10px;width:400px;max-width:95%;}
.close-x{position:absolute;top:10px;right:15px;font-size:20px;background:none;border:none;cursor:pointer;}
input,select{width:100%;padding:10px;margin:8px 0;border:1px solid #ccc;border-radius:6px;box-sizing:border-box;}
.modal-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:10px;}
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
        <button class="add-btn" id="btnAdd">+ Add User</button>
    </div>
    <div class="card">
        <table>
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
                        <button class="edit-btn js-edit" data-user='<?= json_encode($u, JSON_HEX_APOS|JSON_HEX_QUOT) ?>'>Edit</button>
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
<div class="modal" id="addModal">
    <div class="modal-content">
        <button class="close-x" data-close>&times;</button>
        <h3>Add User</h3>
        <form action="user_add.php" method="POST">
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
<div class="modal" id="editModal">
    <div class="modal-content">
        <button class="close-x" data-close>&times;</button>
        <h3>Edit User</h3>
        <form action="user_edit.php" method="POST">
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
<div class="modal" id="deleteModal">
    <div class="modal-content">
        <button class="close-x" data-close>&times;</button>
        <h3>Delete User</h3>
        <p>Are you sure?</p>
        <form action="user_delete.php" method="POST">
            <input type="hidden" name="user_id" id="delete_user_id">
            <div class="modal-actions">
                <button type="button" data-close>Cancel</button>
                <button type="submit" class="delete-btn">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded',function(){
    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');

    function openModal(modal){ modal.classList.add('open'); }
    function closeModal(modal){ modal.classList.remove('open'); }

    document.getElementById('btnAdd').addEventListener('click',()=>openModal(addModal));

    document.querySelectorAll('.js-edit').forEach(btn=>{
        btn.addEventListener('click',()=>{
            const data=JSON.parse(btn.dataset.user);
            document.getElementById('edit_user_id').value=data.user_id;
            document.getElementById('edit_fullname').value=data.fullname;
            document.getElementById('edit_email').value=data.email;
            document.getElementById('edit_role').value=data.role;
            openModal(editModal);
        });
    });

    document.querySelectorAll('.js-delete').forEach(btn=>{
        btn.addEventListener('click',()=>{
            document.getElementById('delete_user_id').value=btn.dataset.userid;
            openModal(deleteModal);
        });
    });

    document.querySelectorAll('[data-close]').forEach(btn=>{
        btn.addEventListener('click',()=>closeModal(btn.closest('.modal')));
    });

    document.querySelectorAll('.modal').forEach(mod=>{
        mod.addEventListener('click',e=>{ if(e.target===mod) closeModal(mod); });
    });

    document.addEventListener('keydown',e=>{ if(e.key==='Escape'){ document.querySelectorAll('.modal.open').forEach(mod=>closeModal(mod)); } });

    console.log("✅ User Management JS loaded");
});
</script>

</body>
</html>
