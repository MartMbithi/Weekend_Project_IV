<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/checklogin.php');

/* Add  */
if (isset($_POST['add_caretaker'])) {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = sha1(md5($_POST['user_password']));
    $user_idno = $_POST['user_idno'];
    $user_phoneno = $_POST['user_phoneno'];
    $user_address = $_POST['user_address'];
    $user_access_level = 'caretaker';

    /* Persist */
    $sql = "INSERT INTO users (user_name, user_email, user_password, user_idno, user_phoneno, user_address, user_access_level)
    VALUES(?,?,?,?,?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sssssss',
        $user_name,
        $user_email,
        $user_password,
        $user_idno,
        $user_phoneno,
        $user_address,
        $user_access_level
    );
    $prepare->execute();
    if ($prepare) {
        $success = "$user_name Account Created";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update  */
if (isset($_POST['update_caretaker'])) {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_idno = $_POST['user_idno'];
    $user_phoneno = $_POST['user_phoneno'];
    $user_address = $_POST['user_address'];
    $user_id = $_POST['user_id'];

    /* Persist */
    $sql = "UPDATE  users  SET user_name =?, user_email =?, user_idno =?, user_phoneno =?, user_address =? WHERE user_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssssss',
        $user_name,
        $user_email,
        $user_idno,
        $user_phoneno,
        $user_address,
        $user_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "$user_name Account Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Delete */
if (isset($_POST['delete_caretaker'])) {
    $user_id = $_POST['user_id'];

    /* Persist */
    $sql = "DELETE FROM users WHERE user_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $user_id);
    $prepare->execute();
    if ($prepare) {
        $info = "Caretaker Account Deleted";
    } else {
        $err = "Failed!, Please Try  Again";
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
                            <h1 class="m-0 text-dark">Caretakers</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Users</a></li>
                                <li class="breadcrumb-item active">Caretakers</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
                <hr>
                <div class="text-right">
                    <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-warning"> Register New Caretaker</button>
                </div>
                <!-- Add Landlord Modal -->
                <!-- Add Modal -->
                <div class="modal fade fixed-right" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog  modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header align-items-center">
                                <div class="text-center">
                                    <h6 class="mb-0 text-bold">Register New Caretaker</h6>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data" role="form">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">Full Name</label>
                                            <input type="text" required name="user_name" class="form-control" id="exampleInputEmail1">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">National ID Number</label>
                                            <input type="text" required name="user_idno" class="form-control" id="exampleInputEmail1">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Password</label>
                                            <input type="password" required name="user_password" class="form-control" id="exampleInputEmail1">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Phone Number</label>
                                            <input type="text" required name="user_phoneno" class="form-control" id="exampleInputEmail1">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Email Address</label>
                                            <input type="text" name="user_email" class="form-control" id="exampleInputEmail1">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Address</label>
                                            <input type="text" name="user_address" class="form-control" id="exampleInputEmail1">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" name="add_caretaker" class="btn btn-warning">Register Caretaker</button>
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
                                                <th>Names</th>
                                                <th>ID No</th>
                                                <th>Email</th>
                                                <th>Phone No</th>
                                                <th>Address</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT * FROM users WHERE user_access_level = 'caretaker' ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($caretaker = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $caretaker->user_name; ?></td>
                                                    <td><?php echo $caretaker->user_idno; ?></td>
                                                    <td><?php echo $caretaker->user_email; ?></td>
                                                    <td><?php echo $caretaker->user_phoneno; ?></td>
                                                    <td><?php echo $caretaker->user_address; ?></td>
                                                    <td>
                                                        <a data-toggle="modal" href="#update_<?php echo $caretaker->user_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                        <a data-toggle="modal" href="#delete_<?php echo $caretaker->user_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                    </td>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade fixed-right" id="update_<?php echo $caretaker->user_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog  modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header align-items-center">
                                                                    <div class="text-bold">
                                                                        <h6 class="text-bold">Update <?php echo $caretaker->user_name; ?></h6>
                                                                    </div>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-12">
                                                                                <label for="">Full Name</label>
                                                                                <input type="hidden" required name="user_id" value="<?php echo $caretaker->user_id; ?>" class="form-control" id="exampleInputEmail1">
                                                                                <input type="text" required name="user_name" value="<?php echo $caretaker->user_name; ?>" class="form-control" id="exampleInputEmail1">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">National ID Number</label>
                                                                                <input type="text" required name="user_idno" value="<?php echo $caretaker->user_idno; ?>" class="form-control" id="exampleInputEmail1">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Access Rights</label>
                                                                                <input type="text" readonly required name="user_access_level" value="caretaker" class="form-control" id="exampleInputEmail1">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Phone Number</label>
                                                                                <input type="text" required name="user_phoneno" value="<?php echo $caretaker->user_phoneno; ?>" class="form-control" id="exampleInputEmail1">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Email Address</label>
                                                                                <input type="text" name="user_email" value="<?php echo $caretaker->user_email; ?>" class="form-control" id="exampleInputEmail1">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Address</label>
                                                                                <input type="text" name="user_address" class="form-control" value="<?php echo $caretaker->user_address; ?>" id="exampleInputEmail1">
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_caretaker" class="btn btn-warning">Update Caretaker</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete_<?php echo $caretaker->user_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <h4>Delete <?php echo $caretaker->user_name; ?></h4>
                                                                        <br>
                                                                        <!-- Hide This -->
                                                                        <input type="hidden" name="user_id" value="<?php echo $caretaker->user_id; ?>">
                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                        <input type="submit" name="delete_caretaker" value="Delete" class="text-center btn btn-danger">
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