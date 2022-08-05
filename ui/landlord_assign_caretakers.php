<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();

/* Add  */
if (isset($_POST['assign_property'])) {
    $assignment_caretaker_id = $_POST['assignment_caretaker_id'];
    $assignment_property_id = $_POST['assignment_property_id'];

    /* Prevent Double Entries */
    $sql = "SELECT * FROM  caretaker_assigns WHERE assignment_caretaker_id = '$assignment_caretaker_id' 
    AND  assignment_property_id = '$assignment_property_id'";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $assigns = mysqli_fetch_assoc($res);
        /* Check If Assign Exists */
        if (
            $assigns['assignment_caretaker_id'] == $assignment_caretaker_id &&  $assigns['assignment_property_id'] == $assignment_property_id
        ) {
            $err = "Property Already Assigned Caretaker";
        }
    } else {
        $sql = "INSERT INTO  caretaker_assigns(assignment_caretaker_id, assignment_property_id) VALUES(?,?)";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ss',
            $assignment_caretaker_id,
            $assignment_property_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "House Assigned Caretaker";
        } else {
            $err = "Failed!, Please Try Again Later!";
        }
    }
}

/* Update */
if (isset($_POST['update_assign'])) {
    $assignment_caretaker_id = $_POST['assignment_caretaker_id'];
    $assignment_property_id = $_POST['assignment_property_id'];
    $assignment_id = $_POST['assignment_id'];


    $sql = "UPDATE  caretaker_assigns SET assignment_caretaker_id =?, assignment_property_id =? WHERE assignment_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sss',
        $assignment_caretaker_id,
        $assignment_property_id,
        $assignment_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "House Caretaker Assignment Updated";
    } else {
        $err = "Failed!, Please Try Again Later!";
    }
}

/* Delete */
if (isset($_POST['delete_assign'])) {
    $assignment_id = $_POST['assignment_id'];

    /* Delete */
    $sql = "DELETE FROM caretaker_assigns WHERE assignment_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $assignment_id);
    $prepare->execute();
    if ($prepare) {
        $info = "House Assignment Deleted";
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
                        <div class="col-sm-7">
                            <h1 class="m-0 text-dark">Houses Management - Assign Caretaker</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-5">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="landlord_dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Houses</a></li>
                                <li class="breadcrumb-item active">Assign Caretaker</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
                <hr>
                <div class="text-right">
                    <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-success"> Assign House A Caretaker</button>
                </div>
                <!-- Add Landlord Modal -->
                <!-- Add Modal -->
                <div class="modal fade fixed-right" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog  modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header align-items-center">
                                <div class="text-center">
                                    <h6 class="mb-0 text-bold"> Assign House Caretaker</h6>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data" role="form">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">Caretaker</label>
                                            <select class="form-control basic" name="assignment_caretaker_id">
                                                <option>Select Caretaker</option>
                                                <?php
                                                $ret = "SELECT * FROM users WHERE user_access_level = 'caretaker'  ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($user = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_idno . ' ' . $user->user_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">House Details</label>
                                            <select class="form-control basic" name="assignment_property_id">
                                                <option>Select House</option>
                                                <?php
                                                $user_id = $_SESSION['user_id'];
                                                $ret = "SELECT * FROM properties WHERE property_landlord_id = '$user_id' ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($cat = $res->fetch_object()) { ?>
                                                    <option value="<?php echo $cat->property_id; ?>"><?php echo $cat->property_code . ' ' . $cat->property_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" name="assign_property" class="btn btn-success">Assign Caretaker</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-success card-outline">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Caretaker Details</th>
                                                <th>House Details</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $user_id = $_SESSION['user_id'];
                                            $ret = "SELECT * FROM caretaker_assigns ca 
                                            INNER JOIN users u ON ca.assignment_caretaker_id = u.user_id
                                            INNER JOIN properties p ON p.property_id = ca.assignment_property_id
                                            WHERE p.property_landlord_id = '$user_id'  ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($assn = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <b>Name: </b> <?php echo $assn->user_name; ?> <br>
                                                        <b>IDNO : </b> <?php echo $assn->user_idno; ?> <br>
                                                        <b>Email: </b> <?php echo $assn->user_email; ?>
                                                    </td>
                                                    <td>
                                                        <b>Code: </b> <?php echo $assn->property_code; ?><br>
                                                        <b>Name: </b> <?php echo $assn->property_name; ?><br>
                                                        <b>Location: </b> <?php echo $assn->property_address ?>
                                                    </td>
                                                    <td>
                                                        <a data-toggle="modal" href="#update_<?php echo $assn->assignment_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                        <a data-toggle="modal" href="#delete_<?php echo $assn->assignment_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                    </td>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade fixed-right" id="update_<?php echo $assn->assignment_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog  modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header align-items-center">
                                                                    <div class="text-bold">
                                                                        <h6 class="text-bold">Update <?php echo $assn->user_name . '' . $assn->property_name; ?> Allocation </h6>
                                                                    </div>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Caretaker</label>
                                                                                <!-- Hide This -->
                                                                                <input type="hidden" required name="assignment_id" value="<?php echo $assn->assignment_id; ?>" readonly class="form-control" id="exampleInputEmail1">
                                                                                <select class="form-control basic" name="assignment_caretaker_id">
                                                                                    <option value="<?php echo $assn->assignment_caretaker_id; ?>"><?php echo $assn->user_idno . ' ' . $assn->user_name; ?></option>
                                                                                    <?php
                                                                                    $caretaker_ret = "SELECT * FROM users WHERE user_access_level = 'caretaker'  ";
                                                                                    $caretaker_stmt = $mysqli->prepare($caretaker_ret);
                                                                                    $caretaker_stmt->execute(); //ok
                                                                                    $caretaker_res = $caretaker_stmt->get_result();
                                                                                    while ($caretaker_user = $caretaker_res->fetch_object()) {
                                                                                    ?>
                                                                                        <option value="<?php echo $caretaker_user->user_id; ?>"><?php echo $caretaker_user->user_idno . ' ' . $caretaker_user->user_name; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">House Details</label>
                                                                                <select class="form-control basic" name="assignment_property_id">
                                                                                    <option value="<?php echo $assn->assignment_property_id; ?>"><?php echo $assn->property_code . ' ' . $assn->property_name; ?></option>
                                                                                    <?php
                                                                                    $properties_ret = "SELECT * FROM properties WHERE property_landlord_id = '$user_id'  ";
                                                                                    $properties_stmt = $mysqli->prepare($properties_ret);
                                                                                    $properties_stmt->execute(); //ok
                                                                                    $properties_res = $properties_stmt->get_result();
                                                                                    while ($properties_cat = $properties_res->fetch_object()) { ?>
                                                                                        <option value="<?php echo $properties_cat->property_id; ?>"><?php echo $properties_cat->property_code . ' ' . $properties_cat->property_name; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_assign" class="btn btn-success">Update</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete_<?php echo $assn->assignment_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <h4>Delete <?php echo $assn->user_name . '' . $assn->property_name; ?> Allocation </h4>
                                                                        <br>
                                                                        <!-- Hide This -->
                                                                        <input type="hidden" name="assignment_id" value="<?php echo $assn->assignment_id; ?>">
                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                        <input type="submit" name="delete_assign" value="Delete" class="text-center btn btn-danger">
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