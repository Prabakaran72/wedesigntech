<?php
session_start();
include 'db.php';
require 'helpers.php';

$action = $_POST['action'] ?? '';

if ($action === 'register') {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $dob = $_POST['dob'];
        $age = $_POST['age'];
        $phone_no = $_POST['phone_no'];


        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, dob, age, role, phone_no) VALUES (?, ?, ?, ?, ?, 'user', ?)");
        $stmt->execute([$name, $email, $password, $dob, $age, $phone_no]);

        // Set first user as admin
        if ($pdo->lastInsertId() == 1) {
            $pdo->query("UPDATE users SET role='admin' WHERE id=1");
        }

        echo json_encode(['success' => true]);
    } catch (Exception $err) {
        $err_code = $err->getCode();
        if (isset($err_code)) {
            if ($err_code == '23000') { // Integrity constraint violation
                if (strpos($err->getMessage(), 'email') !== false) {
                    $field_name = 'email';
                } elseif (strpos($err->getMessage(), 'name') !== false) {
                    $field_name = 'name';
                } elseif (strpos($err->getMessage(), 'phone_no') !== false) {
                    $field_name = 'phone number';
                }
                $err_msg = get_exception_message($err->getCode(), $field_name);
            } else {
                $err_msg = 'Oops, Somthing went wrong. Please try again later.';
            }
        } else {
            $err_msg = 'Oops, Somthing went wrong. Please try again later.';
        }

        echo json_encode(["success" => false, "message" => $err_msg, 'error' => $err->getMessage()]);

    }
} elseif ($action === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid login']);
    }
} elseif ($action === 'update_profile') {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $age = $_POST['age'];
        $phone_no = $_POST['phone_no'];

        if (isset($_SESSION['user'])) {
            $is_hashed = (strlen($_POST['password']) === 60 && preg_match('/^\$2[aby]\$/', $_POST['password']));
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }
        if (isset($is_hashed) && $is_hashed == true) {
            $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, dob=?, age=?, phone_no=? WHERE id=?");
            $stmt->execute([$name, $email, $dob, $age, $phone_no, $_SESSION['user']['id']]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, dob=?, age=?, password=?, phone_no=? WHERE id=?");
            $stmt->execute([$name, $email, $dob, $age, $password, $phone_no, $_SESSION['user']['id']]);
        }
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if(isset($user)){
            $_SESSION['user'] = $user;
        }
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'session' => $_SESSION['user']]);
    }
}
?>