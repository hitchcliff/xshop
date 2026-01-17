<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("localhost", "root", '', "xshop");

define("BASE_URL", "http://localhost/xshop");

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

function text_input($name, $label, $placeholder = "")
{

    $value = "";
    $error = "";
    $error_text = "";

    if (isset($_SESSION["form"]['add_category'])) {
        if (isset($_SESSION["form"]['add_category'][$name])) {
            $value = $_SESSION["form"]['add_category'][$name];

            if (isset($_SESSION["form"]['add_category']["error"][$name])) {
                $error = $_SESSION["form"]['add_category']["error"][$name];
                $error_text = '<div class="d-flex text-danger mt-2"><i class="material-icons">error</i>&nbsp;' . $error . '</div>';
            }
        }
    }

    return '
        <label class="form-label" for="' . $name . '">' . $label . '</label>
        <input class="form-control" type="text" id="' . $name . '" name="' . $name . '" placeholder="' . $placeholder . '" value="' . $value . '">
        ' . $error_text . '
    ';

}

function upload_images($files)
{

    ini_set('memory_limit', '512M');

    if ($files == null || empty($files)) {
        return [];
    }

    $uploaded_images = array();

    foreach ($files as $file) {
        print_r("<pre>");
        print_r($file);

        if (
            isset($file['name']) &&
            isset($file['full_path']) &&
            isset($file['tmp_name'])
            && isset($file['error']) &&
            isset($file["size"])
        ) {
            $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
            $file_name = time() . "-" . rand(0, 10000000000) . '.' . $ext;
            $destination = 'uploads/' . $file_name;

            $res = move_uploaded_file($file['tmp_name'], $destination);

            if (!$res) {
                die("failed");
            }


            die("success");
        }
    }


}