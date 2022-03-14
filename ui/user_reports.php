<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/checklogin.php');
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
                            <h1 class="m-0 text-dark"><?php echo ucwords($_GET['user']); ?> Reports</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Reports</a></li>
                                <li class="breadcrumb-item active"><?php echo ucwords($_GET['user']); ?></li>
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
                                    <table class="report_table">
                                        <thead>
                                            <tr>
                                                <th>Names</th>
                                                <th>ID No</th>
                                                <th>Email</th>
                                                <th>Phone No</th>
                                                <th>Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $user = $_GET['user'];
                                            $ret = "SELECT * FROM users WHERE user_access_level = '$user' ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($landlords = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $landlords->user_name; ?></td>
                                                    <td><?php echo $landlords->user_idno; ?></td>
                                                    <td><?php echo $landlords->user_email; ?></td>
                                                    <td><?php echo $landlords->user_phoneno; ?></td>
                                                    <td><?php echo $landlords->user_address; ?></td>
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