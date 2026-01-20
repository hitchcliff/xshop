<?php

require_once("./files/functions.php");
require_once("./files/db.php");
require_once("./files/inputs.php");
require_once("./files/uploads.php");

protected_area();

$data = db_select("categories", "WHERE parent_id != 0");

$categories = [];

foreach ($data as $value) {
    $categories[$value["id"]] = $value["name"];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $redirectUrl = url("/create-product.php");

    $_SESSION["form"]['create_product'] = $_POST; // form data
    $_SESSION["form"]['create_product']["error"] = [""]; // set default container
    $imgs = upload_images($_FILES);


    $errorsLen = 0;

    // checking
    if (isset($_POST['product_name']) || isset($_POST['product_description']) || isset($_POST['product_price']) || isset($_POST['category_select']) || count($imgs) <= 0) {

        if (empty($_POST['product_name'])) {
            $_SESSION["form"]['create_product']["error"]["product_name"] = "Must not be empty";
            $errorsLen++;
        }

        if (empty($_POST['product_description'])) {
            $_SESSION["form"]['create_product']["error"]["product_description"] = "Must not be empty";
            $errorsLen++;
        }

        if (empty($_POST['product_price'])) {
            $_SESSION["form"]['create_product']["error"]["product_price"] = "Must not be empty";
            $errorsLen++;
        }

        if ($_POST['category_select'] == 0) {
            $_SESSION["form"]['create_product']["error"]["category_select"] = "Category is required";
            $errorsLen++;
        }

        if (count($imgs) <= 0) {
            $_SESSION["form"]['create_product']["error"]["product_img_1"] = "Must not be empty";
            $errorsLen++;
        }
    }

    // check if has errors
    if ($errorsLen == 0) {
        $name = $_POST["product_name"];
        $description = $_POST["product_description"];
        $productPrice = doubleval($_POST["product_price"]);
        $salePrice = doubleval($_POST["product_sale_price"] ?? $productPrice);
        $categoryId = $_POST["category_select"];
        $imgs = json_encode($imgs);
        $userId = $_SESSION["user"]["id"];


        $sql = "INSERT INTO products (name, description, photo, category_id, price, sale_price, user_id)
        values ('$name', '$description', '$imgs', $categoryId, $productPrice, $salePrice, $userId);
        ";

        global $conn;

        if ($conn->query($sql)) {
            $redirectUrl2 = url("/create-product.php");
            alert("success", "Created successfully.");
            header("Location: {$redirectUrl2}");

            unset($_SESSION["form"]["create_product"]);
        }
    } else {
        alert("danger", "Failed to create category.");
        header("Location: {$redirectUrl}");
    }
}

require_once("./files/header.php"); ?>



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
            <!-- Toolbar-->
            <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">

            </div>
            <!-- Content-->
            <section class="pt-lg-4 pb-4 mb-3">
                <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
                    <!-- Title-->
                    <div class="d-sm-flex flex-wrap justify-content-between align-items-center pb-2">
                        <h2 class="h3 py-2 me-2 text-center text-sm-start">Add New Product</h2>
                        <!-- <select class="form-select me-2" id="unp-category">
                                <option>Select category</option>
                                <option>Photos</option>
                                <option>Graphics</option>
                                <option>UI Design</option>
                                <option>Web Themes</option>
                                <option>Fonts</option>
                                <option>Add-Ons</option>
                            </select> -->
                    </div>
                    <form method="post" action="create-product.php" enctype="multipart/form-data">
                        <div class="mb-3 pb-2">
                            <?= text_input("create_product", "product_name", "Product Name", "Name") ?>
                        </div>
                        <div class="flex flex-row mb-3 gap-3">
                            <?= file_drop_input("create_product", "product_img_1") ?>
                            <?= file_drop_input("create_product", "product_img_2") ?>
                        </div>
                        <div class="flex flex-row mb-3 gap-3">
                            <?= file_drop_input("create_product", "product_img_3") ?>
                            <?= file_drop_input("create_product", "product_img_4") ?>
                        </div>
                        <div class="flex flex-row mb-3 gap-3">
                            <?= file_drop_input("create_product", "product_img_5") ?>
                            <?= file_drop_input("create_product", "product_img_6") ?>
                        </div>
                        <div class="mb-3 py-2">
                            <?= text_area_input("create_product", "product_description", "Product Description", "Description") ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <?= text_input("create_product", "product_price", "Product Price", "0") ?>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <?= text_input("create_product", "product_sale_price", "Sale Price", "0") ?>
                            </div>
                        </div>
                        <div class="mb-3 pb2">
                            <?= select_input("create_product", "category_select", "Select category", $categories) ?>
                        </div>

                        <button class="btn btn-primary d-block w-100" type="submit"><i
                                class="ci-cloud-upload fs-lg me-2"></i>Upload Product</button>
                    </form>
                </div>
            </section>
        </section>
        </section>
    </div>
</div>

<?php require_once('./files/footer.php'); ?>