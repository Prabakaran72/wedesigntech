<?php session_start(); if (!isset($_SESSION['user'])) header('Location: index.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
</head>
<body>
    <h2>Your Profile</h2>
    <form id="profileForm">
        <input type="text" name="name" value="<?= $_SESSION['user']['name'] ?>" required><br>
        <input type="email" name="email" value="<?= $_SESSION['user']['email'] ?>" required><br>
        <input type="date" name="dob" value="<?= $_SESSION['user']['dob'] ?>" required><br>
        <button type="submit">Update</button>
    </form>

    <script>
        document.getElementById('profileForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'update_profile');
            
            fetch('process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) alert('Profile updated');
            });
        });
    </script>
</body>
</html>
