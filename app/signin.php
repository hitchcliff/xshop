<?php

require_once('../files/functions.php');

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$loggedIn = login($email, $password);

if ($loggedIn) {
    alert("success", "Logged in successfully");

    // redirect
    header('Location: ../orders.php');
} else {
    alert("danger", "Wrong email/password");

    // go back 
    header("Location: {$_SERVER['HTTP_REFERER']}");
}


