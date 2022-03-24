<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();

/* Add Property */
if (isset($_POST['update_property'])) {
    $property_id = $_POST['property_id'];
    $property_name = $_POST['property_name'];
    $property_cost = $_POST['property_cost'];
    $property_category_id = $_POST['property_category_id'];
    $property_landlord_id = $_POST['property_landlord_id'];
    $property_address = $_POST['property_address'];

    /* Perisist */
    $sql = "UPDATE properties SET property_name =?, property_cost =?, property_category_id =?, property_landlord_id =?, property_address =?    WHERE  property_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssssss',
        $property_name,
        $property_cost,
        $property_category_id,
        $property_landlord_id,
        $property_address,
        $property_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Rental Property Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update Images */
if (isset($_POST['update_images'])) {
    $property_id = $_POST['property_id'];
    $property_code  = $_POST['property_code'];
    /* Process Image 1 */
    $property_img_1 = $property_code . $_FILES['property_img_1']['name'];
    $upload_directory = "../data/" . $property_img_1;
    $temp_name = $_FILES["property_img_1"]["tmp_name"];
    move_uploaded_file($temp_name, $upload_directory);

    /* Process Image 2 */
    $property_img_2 = $property_code . $_FILES['property_img_2']['name'];
    $upload_directory_2 = "../data/" . $property_img_2;
    $temp_name = $_FILES["property_img_2"]["tmp_name"];
    move_uploaded_file($temp_name, $upload_directory_2);

    /* Persist */
    $sql = "UPDATE properties SET  property_img_1 =?, property_img_2 =? WHERE property_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sss',
        $property_img_1,
        $property_img_2,
        $property_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Property Images Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Delete */
if (isset($_POST['delete_property'])) {
    $property_id = $_POST['property_id'];

    /* Delete */
    $sql = "DELETE FROM properties WHERE property_id = ?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $property_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Property Deleted";
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
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Manage Properties</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Properties</a></li>
                                <li class="breadcrumb-item active">Manage</li>
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
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Property Landlord</th>
                                                <th>Location</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT * FROM properties p 
                                            INNER JOIN categories c ON c.category_id  = p.property_category_id
                                            INNER JOIN users u ON u.user_id = p.property_landlord_id";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($properties = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $properties->property_code; ?></td>
                                                    <td><?php echo $properties->property_name; ?></td>
                                                    <td><?php echo $properties->category_name; ?></td>
                                                    <td><?php echo $properties->user_name; ?></td>
                                                    <td><?php echo $properties->property_address; ?></td>
                                                    <td>
                                                        <a href="property?view=<?php echo $properties->property_id; ?>" class="badge badge-success"><i class="fas fa-eye"></i> View</a>
                                                        <a data-toggle="modal" href="#update_<?php echo $properties->property_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                        <a data-toggle="modal" href="#image_<?php echo $properties->property_id; ?>" class="badge badge-warning"><i class="fas fa-image"></i> Update Images</a>
                                                        <a data-toggle="modal" href="#delete_<?php echo $properties->property_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                    </td>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade fixed-right" id="update_<?php echo $properties->property_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog  modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header align-items-center">
                                                                    <div class="text-bold">
                                                                        <h6 class="text-bold">Update </h6>
                                                                    </div>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Property Code</label>
                                                                                <input type="text" value="<?php echo $properties->property_code; ?>" readonly required name="property_code" class="form-control">
                                                                                <input type="hidden" value="<?php echo $properties->property_id; ?>" readonly required name="property_id" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-2">
                                                                                <label for="">Monthly Rent (Ksh)</label>
                                                                                <input type="text" required value="<?php echo $properties->property_cost; ?>" name="property_cost" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Property Name</label>
                                                                                <input type="text" value="<?php echo $properties->property_name; ?>" required name="property_name" class="form-control">
                                                                            </div>

                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Property Category</label>
                                                                                <select class="form-control basic" name="property_category_id">
                                                                                    <option value="<?php echo $properties->property_category_id; ?>"><?php echo $properties->category_code . ' - ' . $properties->category_name; ?></option>
                                                                                    <?php
                                                                                    $categories_ret = "SELECT * FROM categories  ";
                                                                                    $categories_stmt = $mysqli->prepare($categories_ret);
                                                                                    $categories_stmt->execute(); //ok
                                                                                    $categories_res = $categories_stmt->get_result();
                                                                                    while ($categories_cat = $categories_res->fetch_object()) {
                                                                                    ?>
                                                                                        <option value="<?php echo $categories_cat->category_id; ?>"><?php echo $categories_cat->category_code . ' - ' . $categories_cat->category_name; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Property Landlord / Manager</label>
                                                                                <select class="form-control basic" name="property_landlord_id">
                                                                                    <option value="<?php echo $properties->property_landlord_id; ?>"><?php echo $properties->user_idno . ' - ' . $properties->user_name; ?></option>
                                                                                    <?php
                                                                                    $landlord_ret = "SELECT * FROM users WHERE user_access_level  = 'landlord'  ";
                                                                                    $landlord_stmt = $mysqli->prepare($landlord_ret);
                                                                                    $landlord_stmt->execute(); //ok
                                                                                    $landlord_res = $landlord_stmt->get_result();
                                                                                    while ($landlord_users = $landlord_res->fetch_object()) {
                                                                                    ?>
                                                                                        <option value="<?php echo $landlord_users->user_id; ?>"><?php echo $landlord_users->user_idno . ' - ' . $landlord_users->user_name; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-12">
                                                                                <label for="">Property Address</label>
                                                                                <textarea type="text" name="property_address" class="form-control"><?php echo $properties->property_address; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_property" class="btn btn-warning">Update Property</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->
                                                    <!-- Update Modal -->
                                                    <div class="modal fade fixed-right" id="image_<?php echo $properties->property_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog  modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header align-items-center">
                                                                    <div class="text-bold">
                                                                        <h6 class="text-bold">Update mages</h6>
                                                                    </div>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="exampleInputFile">Property Exterior Image</label>
                                                                                <div class="input-group">
                                                                                    <div class="custom-file">
                                                                                        <input name="property_img_1" required accept=".png, jpeg, .jpg" type="file" class="custom-file-input">
                                                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                                                        <input type="hidden" value="<?php echo $properties->property_id; ?>" readonly required name="property_id" class="form-control">
                                                                                        <input type="hidden" value="<?php echo $properties->property_code; ?>" readonly required name="property_code" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="exampleInputFile">Property Interior Image</label>
                                                                                <div class="input-group">
                                                                                    <div class="custom-file">
                                                                                        <input name="property_img_2" required accept=".png, jpeg, .jpg" type="file" class="custom-file-input">
                                                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_images" class="btn btn-warning">Update Property Images</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete_<?php echo $properties->property_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">CONFIRM DELETE</h5>
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST">
                                                                    <div class="modal-body text-center text-danger">
                                                                        <h4>Delete <?php echo $properties->property_code . ' ' . $properties->property_name; ?></h4>
                                                                        <br>
                                                                        <!-- Hide This -->
                                                                        <input type="hidden" name="property_id" value="<?php echo $properties->property_id; ?>">
                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                        <input type="submit" name="delete_property" value="Delete" class="text-center btn btn-danger">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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