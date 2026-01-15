<?php

require_once('../files/functions.php');

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$loggedIn = login($email, $password);

if ($loggedIn) {
    // redirect
    header('Location: ../orders.php');
} else {
    header('Location: ../login.php');
}


