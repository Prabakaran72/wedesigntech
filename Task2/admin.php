<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h2>Admin Panel</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>DOB</th>
            <th>Age</th>
            <th>Role</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['dob'] ?></td>
                <td><?= $user['age'] ?></td>
                <td><?= $user['role'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
