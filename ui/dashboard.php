<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/checklogin.php');
check_login();
require_once('../app/helpers/admin_analytics.php');
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
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-sitemap"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Property Categories</span>
                                    <span class="info-box-number">
                                        <?php echo $categories; ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hotel"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Properties</span>
                                    <span class="info-box-number"><?php echo $properties; ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-edit"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Leased Properties</span>
                                    <span class="info-box-number"><?php echo $properties_leased; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-home"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Vacant Properties</span>
                                    <span class="info-box-number"><?php echo $properties_vacant; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-tie"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Staffs</span>
                                    <span class="info-box-number"><?php echo $staffs; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-tag"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Landlords</span>
                                    <span class="info-box-number"><?php echo $landlords; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-cog"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Caretakers</span>
                                    <span class="info-box-number"><?php echo $caretakers; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Tenants</span>
                                    <span class="info-box-number"><?php echo $tenants; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    /* Show This To Admin Only */
                    if ($_SESSION['user_access_level'] == "admin") { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-warning card-outline">
                                    <div class="card-header">
                                        <h5 class="card-title text-bold">
                                            Overall Income Statements Recap Report
                                        </h5>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="chart">
                                                    <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 100%; max-width: 100%;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-4 col-6">
                                                <div class="description-block border-right">
                                                    <h5 class="description-header">KSH <?php echo number_format($payments, 2); ?></h5>
                                                    <span class="description-text">Total Rent Collections</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 col-6">
                                                <div class="description-block border-right">
                                                    <h5 class="description-header"><?php echo number_format($expenses, 2); ?></h5>
                                                    <span class="description-text">Expenses</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <?php
                                            if ($payments >= $expenses) {
                                                $pl = $payments - $expenses;
                                            ?>
                                                <div class="col-sm-4 col-6 text-success">
                                                    <div class="description-block border-right">
                                                        <h5 class="description-header">Ksh <?php echo number_format($pl, 2); ?></h5>
                                                        <span class="description-text">Total Profit</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                                <!-- /.col -->
                                            <?php } else {
                                                $pl =  $expenses - $payments;
                                            ?>
                                                <div class="col-sm-4 col-6 text-danger">
                                                    <div class="description-block border-right">
                                                        <h5 class="description-header">Ksh <?php echo number_format($pl, 2); ?></h5>
                                                        <span class="description-text">Total Loss</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                            <?php } ?>

                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                            <!-- /.card -->
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-warning card-outline">
                                <div class="card-header">
                                    <h3 class="card-title text-bold">Recent Property Leases</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered text-truncate" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Tenant Details</th>
                                                <th>Property Details</th>
                                                <th>Lease Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT * FROM property_leases pl
                                            INNER JOIN  properties p on p.property_id = pl.lease_property_id
                                            INNER JOIN categories c ON c.category_id  = p.property_category_id
                                            INNER JOIN users u ON u.user_id = pl.lease_tenant_id
                                            WHERE pl.lease_eviction_status = '0'";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($leases = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <b>Name: </b> <?php echo $leases->user_name; ?> <br>
                                                        <b>IDNO: </b> <?php echo $leases->user_idno; ?> <br>
                                                        <b>Phone No : </b> <?php echo $leases->user_phoneno; ?> <br>
                                                        <b>Email : </b> <?php echo $leases->user_email; ?>

                                                    </td>
                                                    <td>
                                                        <b>Code: </b> <?php echo $leases->property_code; ?> <br>
                                                        <b>Name: </b> <?php echo $leases->property_name; ?> <br>
                                                        <b>Category: </b> <?php echo $leases->category_name; ?> <br>
                                                        <b>Location : </b> <?php echo $leases->property_address; ?>
                                                    </td>
                                                    <td>
                                                        <b>REF: </b> <?php echo $leases->lease_ref; ?> <br>
                                                        <b>Duration: </b> <?php echo $leases->lease_duration; ?> Months <br>
                                                        <b>Payment Status: </b> <?php echo $leases->lease_payment_status; ?> <br>
                                                        <b>Date Leased: </b> <?php echo $leases->lease_date_added; ?>
                                                    </td>
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
    <!-- Load Chart Scripts -->
    <?php require_once('../app/partials/chart_scripts.php'); ?>
</body>

</html>