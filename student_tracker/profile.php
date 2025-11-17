<?php
include 'db_connect.php';

// sementara guna user_id = 1
$user_id = 1;

// ambil data user dari DB
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);
$user = $result && $result->num_rows > 0 ? $result->fetch_assoc() : [
    'fullname'=>'Iskandar Zulqarnain',
    'student_id'=>'AM2408016624',
    'email'=>'iskandar@student.edu',
    'phone'=>'+60 12-345 6789',
    'faculty'=>'Faculty of Computer Science',
    'program'=>'Bachelor of Computer Science'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Profile | Student Tracker</title>
<style>
body{font-family:Arial,sans-serif;background:#f9f6f7;margin:0}
header{background:#fff;padding:15px 50px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 10px rgba(0,0,0,0.05);}
nav a{margin-left:20px;text-decoration:none;color:#333;}
nav a.active{color:#c487bf;font-weight:bold;}
main{max-width:800px;margin:40px auto;background:#fff;padding:30px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.05);}
.profile-info p{margin:8px 0;}
.btn{background:#c487bf;color:#fff;padding:10px 20px;border:none;border-radius:6px;cursor:pointer;font-weight:500;transition:0.3s;}
.btn:hover{background:#b067a5;}
#editModal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);justify-content:center;align-items:center;z-index:1000;}
.modal-content{background:#fff;padding:25px;border-radius:10px;width:400px;box-shadow:0 3px 12px rgba(0,0,0,0.2);}
input{width:100%;padding:10px;margin:8px 0;border:1px solid #ccc;border-radius:6px;}
.cancel-btn{background:#aaa;margin-top:8px;}
</style>
</head>
<body>

<header>
  <h1>📘 Student Tracker</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    
    <a href="profile.php" class="active">Profile</a>
  </nav>
</header>

<main>
  <h2>My Profile</h2>
  <div class="profile-info">
    <p><strong>Full Name:</strong> <?= htmlspecialchars($user['fullname']) ?></p>
    <p><strong>Student ID:</strong> <?= htmlspecialchars($user['student_id']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
    <p><strong>Faculty:</strong> <?= htmlspecialchars($user['faculty']) ?></p>
    <p><strong>Program:</strong> <?= htmlspecialchars($user['program']) ?></p>
  </div>
  <button class="btn" id="editProfileBtn">Edit Profile</button>
</main>

<!-- Modal -->
<div id="editModal">
  <div class="modal-content">
    <h3>Edit Profile</h3>
    <form id="editProfileForm">
      <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" placeholder="Full Name" required>
      <input type="text" name="student_id" value="<?= htmlspecialchars($user['student_id']) ?>" placeholder="Student ID" required>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Email" required>
      <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" placeholder="Phone" required>
      <input type="text" name="faculty" value="<?= htmlspecialchars($user['faculty']) ?>" placeholder="Faculty" required>
      <input type="text" name="program" value="<?= htmlspecialchars($user['program']) ?>" placeholder="Program" required>
      <button type="submit" class="btn">Save Changes</button>
      <button type="button" class="btn cancel-btn" id="closeModal">Cancel</button>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded',()=>{
    const modal = document.getElementById('editModal');
    const openBtn = document.getElementById('editProfileBtn');
    const closeBtn = document.getElementById('closeModal');
    const form = document.getElementById('editProfileForm');

    // buka modal
    openBtn.addEventListener('click',()=>modal.style.display='flex');

    // tutup modal
    closeBtn.addEventListener('click',()=>modal.style.display='none');

    // submit AJAX
    form.addEventListener('submit',e=>{
        e.preventDefault();
        const formData = new FormData(form);
        formData.append('user_id', <?= $user['user_id'] ?>);

        fetch('update_profile.php',{
            method:'POST',
            body:formData
        })
        .then(res=>res.text())
        .then(data=>{
            alert(data);
            window.location.reload();
        })
        .catch(err=>alert('Error: '+err));
    });
});
</script>

</body>
</html>
