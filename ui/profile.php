<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/checklogin.php');

/* Update Profile */
if (isset($_POST['update_profile'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_phoneno = $_POST['user_phoneno'];
    $user_idno = $_POST['user_idno'];
    $user_address = $_POST['user_address'];

    /* Persist */
    $sql = "UPDATE users SET user_name =?, user_email =?, user_phoneno =?, user_idno =?, user_address =? WHERE user_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssssss',
        $user_name,
        $user_email,
        $user_phoneno,
        $user_idno,
        $user_address
    );
    $prepare->execute();
    if ($prepare) {
        $success = "$user_name Account Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}
/* Change Password */
/* Head Partial */
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Profile</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item active">User Profile</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">

                            <!-- Profile Image -->
                            <div class="card card-warning card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="../assets/upload/no-profile.png" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center">Nina Mcintire</h3>

                                    <p class="text-muted text-center">System Admin</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b><i class="fas fa-envelope text-warning"></i> Email: </b> <a class="float-right">mart@gmail.com</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><i class="fas fa-phone text-warning"></i> Phone No: </b> <a class="float-right">071234567</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><i class="fas fa-map-pin text-warning"></i> Address: </b> <a class="float-right">127001</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><i class="fas fa-user-tag text-warning"></i> ID No: </b> <a class="float-right">3559076</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        </div>
                        <!-- /.col -->
                        <div class="col-md-8">
                            <div class="card card-warning card-outline">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Update Profile</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Change Password</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <form method="post" enctype="multipart/form-data" role="form">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="">Name</label>
                                                        <input type="text" required name="user_name" class="form-control" id="exampleInputEmail1">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="">Email</label>
                                                        <input type="text" required name="user_email" class="form-control" id="exampleInputEmail1">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="">Phone Number</label>
                                                        <input type="text" required name="user_phone" class="form-control" id="exampleInputEmail1">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="">National ID Number</label>
                                                        <input type="text" required name="user_idno" class="form-control" id="exampleInputEmail1">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="">Address</label>
                                                        <textarea type="text" required name="user_address" rows="2" class="form-control" id="exampleInputEmail1"></textarea>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" name="add_category" class="btn btn-warning">Update Profile</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="timeline">
                                            <form method="post" enctype="multipart/form-data" role="form">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="">Old Password</label>
                                                        <input type="password" required name="old_password" class="form-control" id="exampleInputEmail1">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="">New Password</label>
                                                        <input type="password" required name="new_password" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="">Confirm New Password</label>
                                                        <input type="password" required name="confirm_new_password" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" name="update_password" class="btn btn-warning">Update Password</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.nav-tabs-custom -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </section>
        </div>
        <!-- Footer -->
        <?php require_once('../app/partials/footer.php'); ?>
    </div>
    <!-- Scripts -->
    <?php require_once('../app/partials/scripts.php'); ?>
</body>

</html>