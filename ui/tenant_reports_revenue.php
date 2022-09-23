<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();

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
                            <h1 class="m-0 text-dark">My Rent Payment Reports</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="my_dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Reports</a></li>
                                <li class="breadcrumb-item active">Rent Payments</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
                <hr>
            </div>
            <!-- /.content-header -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-danger card-outline">
                                <div class="card-body">
                                    <table class="report_table">
                                        <thead>
                                            <tr>
                                                <th>Rental Agreement Details</th>
                                                <th>House Details</th>
                                                <th>Landlord Details</th>
                                                <th>Payment Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $user_id = $_SESSION['user_id'];
                                            $ret = "SELECT * FROM house_rentals hr
                                            INNER JOIN  houses h on h.house_id = hr.rental_house_id
                                            INNER JOIN categories c ON c.category_id  = h.house_category_id
                                            INNER JOIN users u ON u.user_id = hr.rental_tenant_id 
                                            INNER JOIN payments pa ON pa.payment_rental_id = hr.rental_id 
                                            WHERE hr.rental_eviction_status = '0'  AND hr.rental_tenant_id = '$user_id'
                                            ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($leases = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <b>REF: </b> <?php echo $leases->rental_ref; ?> <br>
                                                        <b>Duration: </b> <?php echo $leases->rental_duration; ?> Months <br>
                                                        <b>Payment Status: </b> <?php echo $leases->rental_payment_status; ?> <br>
                                                        <b>Date Leased: </b> <?php echo $leases->rental_date_added; ?>
                                                    </td>
                                                    <td>
                                                        <b>Code: </b> <?php echo $leases->house_code; ?> <br>
                                                        <b>Name: </b> <?php echo $leases->house_name; ?> <br>
                                                        <b>Category: </b> <?php echo $leases->house_name; ?> <br>
                                                        <b>Location : </b> <?php echo $leases->house_address; ?>
                                                    </td>
                                                    <td>
                                                        <b>Name: </b> <?php echo $leases->user_name; ?> <br>
                                                        <b>IDNO: </b> <?php echo $leases->user_idno; ?> <br>
                                                        <b>Phone No : </b> <?php echo $leases->user_phoneno; ?> <br>
                                                        <b>Email : </b> <?php echo $leases->user_email; ?>
                                                    </td>
                                                    <td>
                                                        <b>Ref: </b> <?php echo $leases->payment_ref; ?> <br>
                                                        <b>Amount: </b> Ksh <?php echo number_format($leases->payment_amount, 2); ?> <br>
                                                        <b>Mode : </b> <?php echo $leases->payment_mode; ?> <br>
                                                        <b>Date : </b> <?php echo date('d M Y g:ia', strtotime($leases->payment_date)); ?>
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
</body>

</html>