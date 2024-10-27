<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="validation.js" defer></script>
    <script src="dataFormat.js" defer></script>
    <style>
        .card {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <?php if (!isset($_SESSION['user'])) {
        ?>
        <div id="login-id">
            <h2>Login</h2>
            <form id="loginForm" action="login">
                <div>
                    <input type="email" name="email" placeholder="Email" required><br>
                </div>
                <div>
                    <input type="password" name="password" placeholder="Password" required><br>
                </div>
                <div>
                    <button type="submit">Login</button>
                </div>
            </form>
            <p><a href="#" id="registerLink">Register</a> | <a href="forgot.php">Forgot Password</a></p>
        </div>
        <div id="container" style="display:none">
            <?php
            include 'form.php';
            ?>
        </div>
        <?php
    } else {
        $user = $_SESSION['user'];
        if ($user['role'] == 'admin') {
            ?>
            <p>Welcome <?php echo $user['name'] ?? 'Guest'; ?></p>
            <?php
            include 'listUsers.php';
            ?>
            <?php
        } else if ($user['role'] === 'user') {
            include 'form.php';
        } else {
            echo "You are not authenticated user. Please <a href=''>click here to login</a>";
        }
    }
    ?>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'login');

            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    const response = data;
                    if (response.success) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error:', textStatus, errorThrown);
                    alert('An error occurred. Please try again.');
                }
            });

        });

        document.getElementById('registerLink').addEventListener('click', function (e) {
            e.preventDefault();
            console.log('login-id id ');
            $('.container').load('form.php', function () {
                $('.container').show(); // Show the form container after loading
            });
            const ele = document.getElementById('container');
            ele.style.display = 'inline';
            const loginEle = document.getElementById('login-id');
            loginEle.style.display = 'none';

        })


    </script>
</body>


</html>