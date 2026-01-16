<?php require_once("./files/functions.php"); ?>

<?php

protected_area();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $redirectUrl = url("/admin-categories-create.php");

    $_SESSION["form"]['add_category'] = $_POST; // form data
    $_SESSION["form"]['add_category']["error"] = [""]; // set default container

    $_SESSION["form"]['add_category']["error"]["category_name"] = "Error example";
    // print_r($_POST);

    header("Location: {$redirectUrl}");

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
                    <form method="post" action="admin-categories-create.php">
                        <div class="mb-3 pb-2">
                            <?php text_input("category_name", "Category name", "Name") ?>
                        </div>
                        <div class="file-drop-area mb-3">
                            <div class="file-drop-icon ci-cloud-upload"></div><span class="file-drop-message">Drag and
                                drop here to upload product screenshot</span>
                            <input class="file-drop-input" type="file">
                            <button class="file-drop-btn btn btn-primary btn-sm mb-2" type="button">Or select
                                file</button>
                            <div class="form-text">1000 x 800px ideal size for hi-res displays</div>
                        </div>
                        <div class="mb-3 py-2">
                            <label class="form-label" for="unp-product-description">Product description</label>
                            <textarea class="form-control" rows="6" id="unp-product-description"></textarea>
                            <div class="bg-secondary p-3 fs-ms rounded-bottom"><span
                                    class="d-inline-block fw-medium me-2 my-1">Markdown supported:</span><em
                                    class="d-inline-block border-end pe-2 me-2 my-1">*Italic*</em><strong
                                    class="d-inline-block border-end pe-2 me-2 my-1">**Bold**</strong><span
                                    class="d-inline-block border-end pe-2 me-2 my-1">- List item</span><span
                                    class="d-inline-block border-end pe-2 me-2 my-1">##Heading##</span><span
                                    class="d-inline-block">--- Horizontal rule</span></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="unp-standard-price">Standard license price</label>
                                <div class="input-group"><span class="input-group-text"><i class="ci-dollar"></i></span>
                                    <input class="form-control" type="text" id="unp-standard-price">
                                </div>
                                <div class="form-text">Average marketplace price for this category is $15.</div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="unp-extended-price">Extended license price</label>
                                <div class="input-group"><span class="input-group-text"><i class="ci-dollar"></i></span>
                                    <input class="form-control" type="text" id="unp-extended-price">
                                </div>
                                <div class="form-text">Typically 10x of the Standard license price.</div>
                            </div>
                        </div>
                        <div class="mb-3 py-2">
                            <label class="form-label" for="unp-product-tags">Product tags</label>
                            <textarea class="form-control" rows="4" id="unp-product-tags"></textarea>
                            <div class="form-text">Up to 10 keywords that describe your item. Tags should all be in
                                lowercase and separated by commas.</div>
                        </div>
                        <div class="mb-3 pb-2">
                            <label class="form-label" for="unp-product-files">Product files for sale</label>
                            <input class="form-control" type="file" id="unp-product-files">
                            <div class="form-text">Maximum file size is 1GB</div>
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