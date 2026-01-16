<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("localhost", "root", '', "xshop");

function login($email, $password)
{

    global $conn;
    $sql = "SELECT * FROM users WHERE email = '{$email}'";

    $result = $conn->query($sql);

    if ($result->num_rows <= 0) {
        return false;
    }

    $row = $result->fetch_assoc();


    if (!password_verify($password, $row["password"])) {
        return false;
    }

    $_SESSION['user'] = $row;

    return true;

}

function setLoginFormData($email, $password)
{
    $_SESSION['login_form_data']['email'] = $email;
    $_SESSION['login_form_data']['password'] = $password;
}

function alert($type, $message)
{
    $_SESSION['alert']['message'] = $message;
    $_SESSION['alert']['type'] = $type;
}

function is_logged_in()
{
    if (isset($_SESSION['user'])) {
        return true;
    }

    return false;
}