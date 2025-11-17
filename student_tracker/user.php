<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <style>
        .btn-edit { color: blue; cursor: pointer; }
        .btn-delete { color: red; cursor: pointer; }
    </style>
</head>
<body>

<h2>User Management</h2>

<table border="1" width="100%" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>

    <?php
    // COLUMN ACTUAL: user_id, fullname, email, password, role
    $sql = "SELECT * FROM users ORDER BY user_id ASC";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?= $row['fullname'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['role'] ?></td>

            <td>
                <a href="edit_user.php?id=<?= $row['user_id'] ?>" class="btn-edit">✏ Edit</a> |
                <a href="delete_user.php?id=<?= $row['user_id'] ?>" class="btn-delete" onclick="return confirm('Delete user?');">🗑 Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
