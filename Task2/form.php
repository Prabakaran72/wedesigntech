<h2 style="text-align: center">
    <?php echo isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user' ? 'Update' : 'Register'; ?>
</h2>
<div class="card" style="display:flex; justify-content: center; align-item: center">
    <form id="registerForm" method="POST">
        <?php
            $name = $_SESSION['user']['name'] ?? '';
            $email = $_SESSION['user']['email'] ?? '';
            $phone_no = $_SESSION['user']['phone_no'] ?? '';
            $dob = $_SESSION['user']['dob'] ?? null;
            $password = $_SESSION['user']['password'] ?? '';
        ?>

        <div style="padding: 5px 0px;">
            <input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>">
            <span id="nameError" style="margin-left:10px; font-size:14px; color: red; display:none"></span><br>
        </div>
        <div style="padding: 5px 0px;">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
            <span id="emailError" style="margin-left:10px; font-size:14px; color: red; display:none"></span> <br>
        </div>
        <div style="padding: 5px 0px;">
            <input type="password" name="password" placeholder="Password" value="<?php echo $password; ?>">
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
        <button><?php echo !isset($_SESSION['user']) ? 'Register' : 'Update'; ?></button>
    </form>
</div>

<script>
       document.getElementById('registerForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const name = formData.get('name');
            const email = formData.get('email');
            const phone_no = formData.get('phone_no');
            const password = formData.get('password');
            const dob = new Date(formData.get('dob')); // Keep dob as a Date object
            const formattedDob = formatDateToMMDDYYYY(dob); // 

            const nameErrorContainer = document.getElementById('nameError').innerHTML = '';
            const emailErrorContainer = document.getElementById('emailError').innerHTML = '';
            const passwordErrorContainer = document.getElementById('passwordError').innerHTML = '';
            const phoneErrorContainer = document.getElementById('phoneError').innerHTML = '';
            const dobErrorContainer = document.getElementById('dobError').innerHTML = '';

            let err = {}; // Initialize error object
            function addErrorSpan(idName, errMessage) {
                const errElement = document.getElementById(idName);
                errElement.innerHTML = errMessage;
                errElement.style.color = 'red'; // Set the color for error messages
                errElement.style.display = 'inline'; // Set the color for error messages
            }

            let isHashed = false;
            let isSessionSet = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;
            if(isSessionSet)
            {
                isHashed = <?php echo (strlen($password) === 60 && preg_match('/^\$2[aby]\$/', $password)) ? 'true' : 'false'; ?>;
            }
            if (isEmpty(name)) {
                addErrorSpan('nameError', 'Invalid Name');
            }
            if (!isValidEmailId(email)) {
                addErrorSpan('emailError', "Invalid Email id");
            }
            if (!isValidMobileNo(phone_no)) {
                addErrorSpan('phoneError', "Invalid Mobile Number");
            }
            if (!isHashed && !isValidPassword(password)) {
                addErrorSpan('passwordError', "Invalid Password");
            }
            if (!isValidDate(formattedDob)) {
                addErrorSpan('dobError', "Invalid Date of birth");
            }

            const age = new Date().getFullYear() - dob.getFullYear();
            formData.append('age', age);
            formData.append('action', '<?php echo isset($_SESSION['user']) ? 'update_profile' : 'register'; ?>');

            if (!isEmpty(name) && isValidEmailId(email) && isValidMobileNo(phone_no) && (isHashed || isValidPassword(password)) && isValidDate(formattedDob)) {
                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        const response = typeof data === 'string' ? JSON.parse(data) : data;
                        if (response.success) {
                            alert('Registered Successfully..!');
                            // window.location.href = 'index.php';
                            setTimeout(()=>{
                                location.reload();
                            },2000)
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                        alert('An error occurred. Please try again.');
                    }
                });

            }
        });
        </script>