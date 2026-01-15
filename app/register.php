<?php

require_once('../files/functions.php');

$email = trim($_POST['email']);
$firstName = trim($_POST['first_name']);
$lastName = trim($_POST['last_name']);
$password = trim($_POST['password']);
$confirmPassword = trim($_POST['confirm_password']);
$phoneNumber = trim($_POST['phone_number']);

$sql = "SELECT * FROM users WHERE email = '{$email}'";

$stmt = $conn->query($sql);

if ($stmt->num_rows > 0) {
    die("User email already exists.");
}

if ($password != $confirmPassword) {
    die("Password did not match.");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (
            first_name,
            last_name,
            email,
            phone_number,
            password,
            user_type
        ) VALUES (
            '{$firstName}',
            '{$lastName}',
            '{$email}',
            '{$phoneNumber}',
            '{$hashedPassword}',
            'customer'
        )";

if ($conn->query($sql)) {
    login($email, $password);

    // redirect
    header('Location: ../orders.php');

    die("Created account successfully.");
} else {
    die("Failed to create account.");
}

