<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("localhost", "root", '', "xshop");

define("BASE_URL", "http://localhost/xshop");

require_once "files/inputs.php";
require_once "files/uploads.php";
require_once "files/db.php";

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

function url($path = "/")
{

    return BASE_URL . $path;

}

function protected_area()
{
    if (!isset($_SESSION["user"])) {
        $redirectUrl = url("/login.php");

        alert("warning", "You must login first to access this page.");
        header("Location: {$redirectUrl}");
        die();
    }
}
function logout()
{
    if (isset($_SESSION["user"])) {

        unset($_SESSION["user"]);

        $redirectUrl = url("/login.php");

        alert("success", "Logged out successfully.");
        header("Location: {$redirectUrl}");
    }
}

function is_link_active($link)
{
    $url = $_SERVER['REQUEST_URI'];

    if (strpos($url, $link) !== false) {
        echo 'active';
    }
}