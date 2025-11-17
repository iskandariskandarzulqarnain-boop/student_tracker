<?php
session_start();
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Panel | Student Tracker</title>
<style>
body {margin:0; font-family:Segoe UI, sans-serif; background:#f7f8fc;}
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
    <a href="admin.php" class="active">Dashboard</a>
    
    <a href="logout.php" style="color:red;">Logout</a>
</div>

<div class="main">
    <h1>Welcome, Admin!</h1>
    <div class="card">
        <p>Use the sidebar to navigate the admin panel.</p>
        <button class="add-btn" id="btnAdd">Add Sample Item</button>
        <button class="edit-btn" id="btnEdit">Edit Sample Item</button>
        <button class="delete-btn" id="btnDelete">Delete Sample Item</button>
    </div>
</div>

<!-- MODAL -->
<div class="modal" id="modal">
    <div class="modal-content">
        <button class="close-x" id="closeModal">&times;</button>
        <h3 id="modalTitle">Modal</h3>
        <p id="modalBody">This is a sample modal</p>
    </div>
</div>

<script>
// pastikan DOM siap
document.addEventListener('DOMContentLoaded', function() {
    console.log("✅ Admin JS loaded"); // confirm console muncul

    const modal = document.getElementById('modal');
    const closeModalBtn = document.getElementById('closeModal');
    const title = document.getElementById('modalTitle');
    const body = document.getElementById('modalBody');

    function openModal(t, b){
        title.textContent = t;
        body.textContent = b;
        modal.classList.add('open');
    }
    function closeModal(){
        modal.classList.remove('open');
    }

    document.getElementById('btnAdd').addEventListener('click', ()=>openModal('Add','You clicked Add'));
    document.getElementById('btnEdit').addEventListener('click', ()=>openModal('Edit','You clicked Edit'));
    document.getElementById('btnDelete').addEventListener('click', ()=>openModal('Delete','You clicked Delete'));
    closeModalBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', e=>{ if(e.target===modal) closeModal(); });
    document.addEventListener('keydown', e=>{ if(e.key==='Escape') closeModal(); });
});
</script>

</body>
</html>
