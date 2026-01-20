<?php

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

    $value = '';
    $error = "";
    $error_text = "";

    if (isset($_SESSION["form"][$section])) {
        if (isset($_SESSION["form"][$section]["error"][$name])) {
            $error = $_SESSION["form"][$section]["error"][$name];
            $error_text = '<div class="d-flex text-danger mt-2"><i class="material-icons">error</i>&nbsp;' . $error . '</div>';
        }

        if (isset($_FILES[$name]['full_path'])) {
            $value = $_FILES[$name]['full_path'];
        }
    }

    return '
            <div class="file-drop-area">
                <div class="file-drop-icon ci-cloud-upload"></div><span class="file-drop-message">Drag and
                    drop here to upload product screenshot</span>
                <input class="file-drop-input" type="file" name="' . $name . '" value="' . $value . '">
                <button class="file-drop-btn btn btn-primary btn-sm mb-2" type="button">Or select
                    file</button>
                <div class="form-text">1000 x 800px ideal size for hi-res displays</div>
            </div>
        ' . $error_text . '
    ';

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

    foreach ($data as $id => $option) {
        $options .= "<option value='{$id}'>{$option}</option>";
    }


    return '
        <label class="form-label" for="' . $name . '">' . $label . '</label>
        <select class="form-select" id="' . $name . '" name="' . $name . '" value="' . $value . '">
            <option value="0" selected>Choose a parent category</option>
            ' . $options . '
        </select>
        ' . $error_text . '
    ';

}