<?php
require 'db.php';
// session_start(); // Make sure session is started

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$user_id = '';
$name = '';
$email = '';
$dob = '';
$phone_no = '';

// Check if user_id is set in POST data
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Fetch user data from the database
    $stmt = $pdo->prepare("SELECT name, email, dob, phone_no FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // Set user data in variables
    if ($user) {
        $name = $user['name'];
        $email = $user['email'];
        $dob = $user['dob'];
        $phone_no = $user['phone_no'];
    }
}

// Fetch users for the user list
$stmt = $pdo->query("SELECT id, name, email, dob, phone_no, age FROM users;");
$users = $stmt->fetchAll();
?>

<style>
    table {
        width: 500px;
        border-collapse: collapse;
        animation: pulseBorder 2s infinite;
    }

    th,
    td {
        width: 100px;
        padding: 8px;
        border: 1px solid #000;
        text-align: center;
    }
</style>

<div id="profile-edit">
    <div class="card" style="display:flex; justify-content: center; align-items: center">
        <form id="registerForm" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <div style="padding: 5px 0px;">
                <input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>">
                <span id="nameError" style="margin-left:10px; font-size:14px; color: red; display:none"></span><br>
            </div>
            <div style="padding: 5px 0px;">
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
                <span id="emailError" style="margin-left:10px; font-size:14px; color: red; display:none"></span> <br>
            </div>
            <div style="padding: 5px 0px;">
                <input type="password" name="password" placeholder="Password" value="<?php echo isset($password) ? $password : ''; ?>">
                <span id="passwordError" style="margin-left:10px; font-size:14px; color: red; display:none"></span>
            </div>
            <div style="padding: 5px 0px;">
                <input type="date" name="dob" value="<?php echo $dob; ?>">
                <span id="dobError" style="margin-left:10px; font-size:14px; color: red; display:none"></span> <br>
            </div>
            <div style="padding: 5px 0px;">
                <input type="text" name="phone_no" placeholder="Mobile Number" maxlength="10" value="<?php echo $phone_no; ?>">
                <span id="phoneError" style="margin-left:10px; font-size:14px; color: red; display:none"></span> <br>
            </div>
            <button id="update-profile"><?php echo !isset($_SESSION['user']) ? 'Register' : 'Update'; ?></button>
        </form>
    </div>
    
    <h2>User List</h2>
    <table width="800px" border="1" style="border">
        <tr>
            <th width="20%">Name</th>
            <th width="25%">Email</th>
            <th width="20%">Phone Number</th>
            <th width="15%">DOB</th>
            <th width="10%">Age</th>
            <th width="10%">Action</th>
        </tr>
        <?php
        if (count($users) > 0) {
            foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone_no']); ?></td>
                    <td><?php echo htmlspecialchars($user['dob']); ?></td>
                    <td><?php echo htmlspecialchars($user['age']); ?></td>
                    <td><button class="user-update" data-id="<?php echo $user['id']; ?>">Edit</button></td>
                </tr>
            <?php }
        } else { ?>
            <td colspan="6">No data found</td>
        <?php } ?>
    </table>
</div>

<script>
    // Attach event listener to all "Edit" buttons
    document.querySelectorAll('.user-update').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');

            // Create a form to send the POST request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = ''; // Submit to the same page
            form.style.display = 'none';

            // Append hidden user_id input
            const userIdInput = document.createElement('input');
            userIdInput.type = 'hidden';
            userIdInput.name = 'user_id';
            userIdInput.value = userId;
            form.appendChild(userIdInput);

            // Append the form to the body and submit
            document.body.appendChild(form);
            form.submit();
        });
    });
    
</script>
