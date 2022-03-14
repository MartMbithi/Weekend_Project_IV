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
                            <h1 class="m-0 text-dark">Revenue Reports</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Reports</a></li>
                                <li class="breadcrumb-item active">Revenue</li>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group float-right m-t-15">
                                <form class="form-inline" method="POST">
                                    <label class="mr-sm-2" for="inlineFormCustomSelect">Start Date </label>
                                    <input required type="date" class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date">
                                    <label class="mr-sm-2" for="inlineFormCustomSelect">End Date </label>
                                    <input required type="date" class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date">
                                    <button type="submit" name="filter" class="btn btn-primary">Filter Revenue Reports</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <br><br><br>

            <?php
            if (isset($_POST['filter'])) {
            ?>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-warning card-outline">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Lease Details</th>
                                                    <th>Property Details</th>
                                                    <th>Tenant Details</th>
                                                    <th>Payment Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $start_date = date('d M Y g:ia', strtotime($_POST['start_date']));
                                                $end_date = date('d M Y g:ia', strtotime($_POST['end_date']));
                                                $ret = "SELECT * FROM property_leases pl
                                                INNER JOIN  properties p on p.property_id = pl.lease_property_id
                                                INNER JOIN categories c ON c.category_id  = p.property_category_id
                                                INNER JOIN users u ON u.user_id = pl.lease_tenant_id 
                                                INNER JOIN payments pa ON pa.payment_lease_id = pl.lease_id 
                                                WHERE pl.lease_eviction_status = '0'
                                                WHERE pa.payment_date BETWEEN '$start_date' AND '$end_date'
                                                ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($leases = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <b>REF: </b> <?php echo $leases->lease_ref; ?> <br>
                                                            <b>Duration: </b> <?php echo $leases->lease_duration; ?> Months <br>
                                                            <b>Payment Status: </b> <?php echo $leases->lease_payment_status; ?> <br>
                                                            <b>Date Leased: </b> <?php echo $leases->lease_date_added; ?>
                                                        </td>
                                                        <td>
                                                            <b>Code: </b> <?php echo $leases->property_code; ?> <br>
                                                            <b>Name: </b> <?php echo $leases->property_name; ?> <br>
                                                            <b>Category: </b> <?php echo $leases->category_name; ?> <br>
                                                            <b>Location : </b> <?php echo $leases->property_address; ?>
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
            <?php } ?>
        </div>

        <!-- Main Footer -->
        <?php require_once('../app/partials/footer.php'); ?>
    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <?php require_once('../app/partials/scripts.php'); ?>
</body>

</html>