<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/checklogin.php');
check_login();
require_once('../app/helpers/landlord_analytics.php');
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
                                <li class="breadcrumb-item"><a href="landlord_dashboard">Home</a></li>
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
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="landlord_manage_properties">
                                <div class="info-box mb-3 text-dark">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hotel"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Houses</span>
                                        <span class="info-box-number"><?php echo $properties; ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                        <!-- /.col -->
                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="landlord_leases_manage">
                                <div class="info-box mb-3 text-dark">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-edit"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Occupied Houses</span>
                                        <span class="info-box-number"><?php echo $properties_leased; ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="landlord_manage_properties">
                                <div class="info-box mb-3 text-dark">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-home"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Vacant Houses</span>
                                        <span class="info-box-number"><?php echo $properties_vacant; ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="landlord_reports_revenue">
                                <div class="info-box mb-3 text-dark">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding-usd"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Rent Collections</span>
                                        <span class="info-box-number">kSH <?php echo number_format($payments, 2); ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h3 class="card-title text-bold">Recent Rentals Records</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered text-truncate" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Tenant Details</th>
                                                <th>House Details</th>
                                                <th>Renting Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $user_id = $_SESSION['user_id'];
                                            $ret = "SELECT * FROM house_rentals hr
                                            INNER JOIN  houses h on h.house_id = hr.rental_house_id
                                            INNER JOIN categories c ON c.category_id  = h.house_category_id
                                            INNER JOIN users u ON u.user_id = hr.rental_tenant_id
                                            WHERE hr.rental_eviction_status = '0' AND h.house_landlord_id = '{$user_id}'";
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
                                                        <b>Code: </b> <?php echo $leases->house_code; ?> <br>
                                                        <b>Name: </b> <?php echo $leases->house_name; ?> <br>
                                                        <b>Category: </b> <?php echo $leases->category_name; ?> <br>
                                                        <b>Location : </b> <?php echo $leases->house_address; ?>
                                                    </td>
                                                    <td>
                                                        <b>REF: </b> <?php echo $leases->rental_ref; ?> <br>
                                                        <b>Duration: </b> <?php echo $leases->rental_duration; ?> Months <br>
                                                        <b>Payment Status: </b> <?php echo $leases->rental_payment_status; ?> <br>
                                                        <b>Rental Date: </b> <?php echo $leases->rental_date_added; ?>
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