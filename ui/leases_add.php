<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();
/* Add Lease */
if (isset($_POST['add_lease'])) {
    $lease_ref = $a . $b;
    $lease_property_id = $_POST['lease_property_id'];
    $lease_tenant_id = $_POST['lease_tenant_id'];
    $lease_duration = $_POST['lease_duration'];
    $lease_date_added = date('d M Y g:ia');

    /* Persist */
    $sql = "INSERT INTO property_leases (lease_ref, lease_property_id, lease_tenant_id, lease_duration, lease_date_added)
    VALUES(?,?,?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sssss',
        $lease_ref,
        $lease_property_id,
        $lease_tenant_id,
        $lease_duration,
        $lease_duration,
        $lease_date_added
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Tenant Lease Record Added";
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
                            <h1 class="m-0 text-dark">Property Leases Module - Add Lease</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-4">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Property Leases</a></li>
                                <li class="breadcrumb-item active">Add</li>
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
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="">Property Details</label>
                                                <select class="form-control basic" name="lease_property_id">
                                                    <option>Select Property</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label for="">Tenant Details</label>
                                                <select class="form-control basic" name="lease_tenant_id">
                                                    <option>Select Tenant</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Lease Duration (Months)</label>
                                                <select class="form-control basic" name="lease_duration">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                    <option>6</option>
                                                    <option>7</option>
                                                    <option>8</option>
                                                    <option>9</option>
                                                    <option>10</option>
                                                    <option>11</option>
                                                    <option>12</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="add_lease" class="btn btn-warning">Lease Property</button>
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