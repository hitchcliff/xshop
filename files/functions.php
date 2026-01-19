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

function text_input($section, $name, $label, $placeholder = "")
{

    $value = "";
    $error = "";
    $error_text = "";

    if (isset($_SESSION["form"][$section])) {
        if (isset($_SESSION["form"][$section][$name])) {
            $value = $_SESSION["form"][$section][$name];

            if (isset($_SESSION["form"][$section]["error"][$name])) {
                $error = $_SESSION["form"][$section]["error"][$name];
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

function text_area_input($section, $name, $label, $placeholder = "")
{

    $value = "";
    $error = "";
    $error_text = "";

    if (isset($_SESSION["form"][$section])) {
        if (isset($_SESSION["form"][$section][$name])) {
            $value = $_SESSION["form"][$section][$name];

            if (isset($_SESSION["form"][$section]["error"][$name])) {
                $error = $_SESSION["form"][$section]["error"][$name];
                $error_text = '<div class="d-flex text-danger mt-2"><i class="material-icons">error</i>&nbsp;' . $error . '</div>';
            }
        }
    }

    return '
        <label class="form-label" for="' . $name . '">' . $label . '</label>
        <textarea class="form-control" rows="6" type="text" id="' . $name . '" name="' . $name . '" placeholder="' . $placeholder . '">' . $value . '</textarea>
        ' . $error_text . '
    ';

}

function file_drop_input($section, $name)
{

    $error = "";
    $error_text = "";

    if (isset($_SESSION["form"][$section])) {
        if (isset($_SESSION["form"][$section]["error"][$name])) {
            $error = $_SESSION["form"][$section]["error"][$name];
            $error_text = '<div class="d-flex text-danger mt-2"><i class="material-icons">error</i>&nbsp;' . $error . '</div>';
        }
    }

    return '
            <div class="file-drop-area">
                <div class="file-drop-icon ci-cloud-upload"></div><span class="file-drop-message">Drag and
                    drop here to upload product screenshot</span>
                <input class="file-drop-input" type="file" name="' . $name . '">
                <button class="file-drop-btn btn btn-primary btn-sm mb-2" type="button">Or select
                    file</button>
                <div class="form-text">1000 x 800px ideal size for hi-res displays</div>
            </div>
        ' . $error_text . '
    ';

}


function upload_images($files)
{

    ini_set('memory_limit', '512M');

    if ($files == null || empty($files)) {
        return [];
    }

    $uploaded_images = [];

    foreach ($files as $file) {

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
            $thumb_destination = 'uploads/' . 'thumb-' . $file_name;

            $res = move_uploaded_file($file['tmp_name'], $destination);

            if (!$res) {
                // put in session
                $_SESSION['upload_error'] = "FAILED TO UPLOAD FILE/S";
                return [];
            }

            $thumb_destination = create_thumb(["width" => 100, "height" => 100], $destination, $thumb_destination);

            $img['src'] = $destination;
            $img['thumb'] = $thumb_destination;

            $uploaded_images[] = $img;
        }
    }


    return $uploaded_images;
}

function create_thumb($size, $source, $target)
{
    ini_set("memory_limit", "-1");

    $image = new stefangabos\Zebra_Image\Zebra_Image();

    $image->auto_handle_exif_orientation = true;
    $image->source_path = $source;
    $image->target_path = $target;
    $image->preserve_aspect_ratio = true;
    $image->enlarge_smaller_images = true;
    $image->preserve_time = true;

    $image->jpeg_quality = 100;

    if (!$image->resize($size['width'], $size['height'], ZEBRA_IMAGE_CROP_CENTER)) {
        return $image->source_path;
    } else {
        return $image->target_path;
    }
    ;
}


function select_input($section, $name, $label, $data)
{

    $value = "";
    $error = "";
    $error_text = "";

    if (isset($_SESSION["form"][$section])) {
        if (isset($_SESSION["form"][$section][$name])) {
            $value = $_SESSION["form"][$section][$name];

            if (isset($_SESSION["form"][$section]["error"][$name])) {
                $error = $_SESSION["form"][$section]["error"][$name];
                $error_text = '<div class="d-flex text-danger mt-2"><i class="material-icons">error</i>&nbsp;' . $error . '</div>';
            }
        }
    }

    $options = "";

    foreach ($data as $option) {
        $options .= "<option value='{$option}'>{$option}</option>";
    }


    return '
        <label class="form-label" for="' . $name . '">' . $label . '</label>
        <select class="form-select" id="' . $name . '" name="' . $name . '" >
            <option value="" disabled selected hidden>Choose a parent category</option>
            ' . $options . '

        </select>
        ' . $error_text . '
    ';

}
