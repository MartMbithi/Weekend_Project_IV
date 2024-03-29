<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();

/* Add Property */
if (isset($_POST['add_property'])) {
    $property_code = $_POST['property_code'];
    $property_name = $_POST['property_name'];
    $property_cost = $_POST['property_cost'];
    $property_category_id = $_POST['property_category_id'];
    $property_landlord_id = $_POST['property_landlord_id'];
    $property_address = $_POST['property_address'];

    /* Process Image 1 */
    $property_img_1 = $property_code.$_FILES['property_img_1']['name'];
    $upload_directory = "../data/" . $property_img_1;
    $temp_name = $_FILES["property_img_1"]["tmp_name"];
    move_uploaded_file($temp_name, $upload_directory);

    /* Process Image 2 */
    $property_img_2 = $property_code.$_FILES['property_img_2']['name'];
    $upload_directory_2 = "../data/" . $property_img_2;
    $temp_name = $_FILES["property_img_2"]["tmp_name"];
    move_uploaded_file($temp_name, $upload_directory_2);

    /* Perisist */
    $sql = "INSERT INTO  houses (house_code, house_name, house_cost, house_category_id, house_landlord_id, house_img_1, house_img_2, house_address)
    VALUES(?,?,?,?,?,?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssssssss',
        $property_code,
        $property_name,
        $property_cost,
        $property_category_id,
        $property_landlord_id,
        $property_img_1,
        $property_img_2,
        $property_address
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Rental House Added";
    } else {
        $err = "Failed!, Please Try Again";
    }
}
require_once('../app/partials/head.php');
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once('../app/partials/nav.php'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once('../app/partials/aside.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <h1 class="m-0 text-dark">Register Houses</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-4">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Houses</a></li>
                                <li class="breadcrumb-item active">Register</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
                <hr>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-warning card-outline">
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data" role="form">
                                        <fieldset class="border border-primary p-2">
                                            <legend class="w-auto text-primary font-weight-light">Rental House Details </legend>
                                            <div class="row">
                                                <div class="form-group col-md-8">
                                                    <label for="">House Name</label>
                                                    <input type="text" required name="property_name" class="form-control">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="">House Code</label>
                                                    <input type="text" readonly value="<?php echo $a . $b; ?>" required name="property_code" class="form-control">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="">Monthly Rent (Ksh)</label>
                                                    <input type="text" required name="property_cost" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">House Category</label>
                                                    <select class="form-control basic" name="property_category_id">
                                                        <option>Select Category</option>
                                                        <?php
                                                        $ret = "SELECT * FROM categories  ";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        while ($cat = $res->fetch_object()) {
                                                        ?>
                                                            <option value="<?php echo $cat->category_id; ?>"><?php echo $cat->category_code . ' - ' . $cat->category_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">House Landlord / Manager</label>
                                                    <select class="form-control basic" name="property_landlord_id">
                                                        <option>Select House / Manager</option>
                                                        <?php
                                                        $ret = "SELECT * FROM users WHERE user_access_level  = 'landlord'  ";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        while ($users = $res->fetch_object()) {
                                                        ?>
                                                            <option value="<?php echo $users->user_id; ?>"><?php echo $users->user_idno . ' - ' . $users->user_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="">House Address</label>
                                                    <textarea type="text" name="property_address" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <br>
                                        <fieldset class="border border-primary p-2">
                                            <legend class="w-auto text-primary font-weight-light">Rental House Images</legend>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputFile">House Exterior Image</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input required name="property_img_1" accept=".png, jpeg, .jpg" type="file" class="custom-file-input">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputFile">House Interior Image</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input required name="property_img_2" accept=".png, jpeg, .jpg" type="file" class="custom-file-input">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <br>
                                        <div class="text-right">
                                            <button type="submit" name="add_property" class="btn btn-warning">Add House</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Main Footer -->
        <?php require_once('../app/partials/footer.php'); ?>
    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <?php require_once('../app/partials/scripts.php'); ?>
</body>

</html>