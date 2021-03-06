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
/* Change Password */
if (isset($_POST['change_password'])) {
    $user_id = $_SESSION['user_id'];
    $old_password = sha1(md5($_POST['old_password']));
    $new_password = sha1(md5($_POST['new_password']));
    $confirm_password = sha1(md5($_POST['confirm_password']));

    /* Check If Old Password  Match  */
    $sql = "SELECT * FROM  users WHERE user_id = '$user_id'";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($old_password != $row['user_password']) {
            $err =  "Please Enter Correct Old Password";
        } elseif ($new_password != $confirm_password) {
            $err = "Confirmation Password Does Not Match";
        } else {
            $new_password  = sha1(md5($_POST['new_password']));
            $query = "UPDATE users SET  user_password =? WHERE user_id =?";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('ss', $new_password, $id);
            $stmt->execute();
            if ($stmt) {
                $success = "Password Updated";
            } else {
                $err = "Please Try Again Or Try Later";
            }
        }
    }
}
/* Head Partial */
require_once('../app/partials/head.php');
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once('../app/partials/nav.php'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once('../app/partials/aside.php');
        $user_id = $_SESSION['user_id'];
        $ret = "SELECT * FROM users WHERE user_id = '$user_id' ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        while ($user = $res->fetch_object()) {
        ?>
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
                                    <li class="breadcrumb-item"><a href="">Home</a></li>
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

                                        <h3 class="profile-username text-center"><?php echo $user->user_name; ?></h3>

                                        <p class="text-muted text-center"><?php echo ucfirst($user->user_access_level); ?></p>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b><i class="fas fa-envelope text-warning"></i> Email: </b> <a class="float-right"><?php echo $user->user_email; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b><i class="fas fa-phone text-warning"></i> Phone No: </b> <a class="float-right"><?php echo $user->user_phoneno; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b><i class="fas fa-map-pin text-warning"></i> Address: </b> <a class="float-right"><?php echo $user->user_address; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b><i class="fas fa-user-tag text-warning"></i> ID No: </b> <a class="float-right"><?php echo $user->user_idno; ?></a>
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
                                                            <input type="text" value="<?php echo $user->user_name; ?>" required name="user_name" class="form-control" id="exampleInputEmail1">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="">Email</label>
                                                            <input type="text" value="<?php echo $user->user_email; ?>" required name="user_email" class="form-control" id="exampleInputEmail1">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="">Phone Number</label>
                                                            <input type="text" required value="<?php echo $user->user_phoneno; ?>" name="user_phoneno" class="form-control" id="exampleInputEmail1">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="">National ID Number</label>
                                                            <input type="text" value="<?php echo $user->user_idno; ?>" required name="user_idno" class="form-control" id="exampleInputEmail1">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="">Address</label>
                                                            <textarea type="text" required name="user_address" rows="2" class="form-control" id="exampleInputEmail1"><?php echo $user->user_address; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <button type="submit" name="update_profile" class="btn btn-warning">Update Profile</button>
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
                                                            <input type="password" required name="confirm_password" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <button type="submit" name="change_password" class="btn btn-warning">Update Password</button>
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
        <?php } ?>
        <!-- Footer -->
        <?php require_once('../app/partials/footer.php'); ?>
    </div>
    <!-- Scripts -->
    <?php require_once('../app/partials/scripts.php'); ?>
</body>

</html>