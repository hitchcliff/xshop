<?php
// compress image
require_once("./files/Zebra_Image.php");
require_once("./files/functions.php");

protected_area();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $redirectUrl = url("/admin-categories-create.php");

    $_SESSION["form"]['add_category'] = $_POST; // form data
    $_SESSION["form"]['add_category']["error"] = [""]; // set default container
    $imgs = upload_images($_FILES);

    $errorsLen = 0;

    // checking
    if (isset($_POST['category_name']) || isset($_POST['category_description']) || count($imgs) <= 0) {

        if (empty($_POST['category_name'])) {
            $_SESSION["form"]['add_category']["error"]["category_name"] = "Must not be empty";
            $errorsLen++;
        }

        if (empty($_POST['category_description'])) {
            $_SESSION["form"]['add_category']["error"]["category_description"] = "Must not be empty";
            $errorsLen++;
        }

        if (count($imgs) <= 0) {
            $_SESSION["form"]['add_category']["error"]["category_image"] = "Must not be empty";
            $errorsLen++;
        }

    }

    // check if has errors
    if ($errorsLen == 0) {
        $name = $_POST["category_name"];
        $description = $_POST["category_description"];
        $parentId = 0;
        $imgs = json_encode($imgs);
        $userId = $_SESSION["user"]["id"];

        $sql = "INSERT INTO categories (name, photo,description, parent_id, user_id)
        VALUES ('{$name}', '{$imgs}', '$description', $parentId, $userId);
        ";

        global $conn;

        if ($conn->query($sql)) {
            $redirectUrl2 = url("/admin-categories.php");
            alert("success", "Created successfully.");
            header("Location: {$redirectUrl2}");

            unset($_SESSION["form"]["add_category"]);
        }
    } else {
        alert("danger", "Failed to create category.");
        header("Location: {$redirectUrl}");
    }

    die();
}

?>

<?php require_once("./files/header.php"); ?>

<!-- Page Title-->
<div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="index-2.html"><i
                                class="ci-home"></i>Home</a></li>
                    <li class="breadcrumb-item text-nowrap"><a href="#">Account</a>
                    </li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page">Orders history</li>
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Product categories</h1>
        </div>
    </div>
</div>
<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
        <!-- Sidebar-->
        <?php require_once("./files/account_sidebar.php"); ?>
        <!-- Content  -->
        <section class="col-lg-8">
            <!-- Placeholder -->
            <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
            </div>

            <!-- Content-->
            <section class="pt-lg-4 pb-4 mb-3">
                <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
                    <!-- Title-->
                    <div class="d-sm-flex flex-wrap justify-content-between align-items-center pb-2">
                        <h2 class="h3 py-2 me-2 text-center text-sm-start">Add New Category</h2>
                    </div>
                    <form method="post" action="admin-categories-create.php" enctype="multipart/form-data">
                        <div class="mb-3 pb-2">
                            <?= text_input("add_category", "category_name", "Category name", "Name") ?>
                        </div>
                        <div class="mb-3">
                            <?= file_drop_input("add_category", "category_image", ) ?>
                        </div>
                        <!-- <div class="file-drop-area mb-3">
                            <div class="file-drop-icon ci-cloud-upload"></div><span class="file-drop-message">Drag and
                                drop here to upload product screenshot</span>
                            <input class="file-drop-input" type="file" name="category_image">
                            <button class="file-drop-btn btn btn-primary btn-sm mb-2" type="button">Or select
                                file</button>
                            <div class="form-text">1000 x 800px ideal size for hi-res displays</div>
                        </div> -->
                        <div class="mb-3 py-2">
                            <?= text_area_input("add_category", "category_description", "Product Description", "Description"); ?>
                            <!-- <div class="bg-secondary p-3 fs-ms rounded-bottom"><span
                                    class="d-inline-block fw-medium me-2 my-1">Markdown supported:</span><em
                                    class="d-inline-block border-end pe-2 me-2 my-1">*Italic*</em><strong
                                    class="d-inline-block border-end pe-2 me-2 my-1">**Bold**</strong><span
                                    class="d-inline-block border-end pe-2 me-2 my-1">- List item</span><span
                                    class="d-inline-block border-end pe-2 me-2 my-1">##Heading##</span><span
                                    class="d-inline-block">--- Horizontal rule</span></div> -->
                        </div>

                        <div class="mb-3 pb-2">
                            <?= select_input("add_category", "category_parent", "Parent Category", ["One", "Two", "Three"]) ?>
                        </div>
                        <button class="btn btn-primary d-block w-100" type="submit"><i
                                class="ci-cloud-upload fs-lg me-2"></i>Upload Product</button>
                    </form>
                </div>
            </section>

        </section>
    </div>
</div>

<?php require_once('./files/footer.php'); ?>