<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();

/* Add  */
if (isset($_POST['add_assign'])) {
    $assignment_caretaker_id = $_POST['assignment_caretaker_id'];
    $assignment_property_id = $_POST['assignment_property_id'];

    /* Prevent Double Entries */
    $sql = "SELECT * FROM  caretaker_assigns WHERE assignment_caretaker_id = '$assignment_caretaker_id' 
    || assignment_property_id = '$assignment_property_id'";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $assigns = mysqli_fetch_assoc($res);
        /* If ID Number Already Exists Exit */
        if (
            $assigns['user_idno'] == $assignment_caretaker_id &&  $assigns['assignment_property_id'] == $assignment_property_id
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
            $success = "Property Assigned Caretaker";
        } else {
            $err = "Failed!, Please Try Again Later!";
        }
    }
}

/* Update */
if (isset($_POST['add_assign'])) {
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
        $success = "Property Caretaker Assignment Updated";
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
    if ($prepare) {
        $success = "Property Assignment Deleted";
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
                            <h1 class="m-0 text-dark">Property Management Module - Assign Caretaker</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-5">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Properties</a></li>
                                <li class="breadcrumb-item active">Assign Caretaker</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
                <hr>
                <div class="text-right">
                    <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-warning"> Assign Property Caretaker</button>
                </div>
                <!-- Add Landlord Modal -->
                <!-- Add Modal -->
                <div class="modal fade fixed-right" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog  modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header align-items-center">
                                <div class="text-center">
                                    <h6 class="mb-0 text-bold"> Assign Property Caretaker</h6>
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
                                                <option>Select Category</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Property Details</label>
                                            <select class="form-control basic" name="assignment_property_id">
                                                <option>Select Category</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" name="assign_property" class="btn btn-warning">Assign Property</button>
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
                            <div class="card card-warning card-outline">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Caretaker Details</th>
                                                <th>Property Details</th>
                                                <th>Date Assigned</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>Name</td>
                                                <td>IDNO</td>
                                                <td>Email</td>
                                                <td>
                                                    <a data-toggle="modal" href="#update_" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                    <a data-toggle="modal" href="#delete_" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                                <!-- Update Modal -->
                                                <div class="modal fade fixed-right" id="update_" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                        <div class="form-group col-md-6">
                                                                            <label for="">Caretaker</label>
                                                                            <select class="form-control basic" name="assignment_caretaker_id">
                                                                                <option>Select Category</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="">Property Details</label>
                                                                            <select class="form-control basic" name="assignment_property_id">
                                                                                <option>Select Category</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <button type="submit" name="update_assign" class="btn btn-warning">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="delete_" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                    <h4>Delete </h4>
                                                                    <br>
                                                                    <!-- Hide This -->
                                                                    <input type="hidden" name="user_id" value="">
                                                                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                    <input type="submit" name="delete_assign" value="Delete" class="text-center btn btn-danger">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </tr>

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