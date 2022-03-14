<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();
/* Add Payment */
if (isset($_POST['pay_lease'])) {
    $payment_ref = $_POST['payment_ref'];
    $payment_lease_id = $_POST['payment_lease_id'];
    $payment_amount = $_POST['payment_amount'];
    $payment_mode = $_POST['payment_mode'];
    $payment_date = date('d M Y g:ia');
    $lease_payment_status = 'Paid';

    /* Persist */
    $sql = "INSERT INTO payments (payment_ref, payment_lease_id, payment_amount, payment_mode, payment_date) 
    VALUES(?,?,?,?, ?)";
    $lease_sql = "UPDATE property_leases SET lease_payment_status =? WHERE lease_id =?";

    $prepare = $mysqli->prepare($sql);
    $lease_prepare = $mysqli->prepare($lease_sql);

    $bind = $prepare->bind_param(
        'sssss',
        $payment_ref,
        $payment_lease_id,
        $payment_amount,
        $payment_mode,
        $payment_date
    );
    $lease_bind = $lease_prepare->bind_param(
        'ss',
        $lease_payment_status,
        $payment_lease_id
    );

    $prepare->execute();
    $lease_prepare->execute();

    if ($prepare && $lease_bind) {
        $success = "Payment $payment_ref Posted";
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
                            <h1 class="m-0 text-dark">Rent Collections</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-4">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item active">Rent Collections</li>
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
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Property Details</th>
                                                <th>Tenant Details</th>
                                                <th>Lease Agreement Details</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT * FROM property_leases pl
                                            INNER JOIN  properties p on p.property_id = pl.lease_property_id
                                            INNER JOIN categories c ON c.category_id  = p.property_category_id
                                            INNER JOIN users u ON u.user_id = pl.lease_tenant_id 
                                            WHERE pl.lease_eviction_status = '0'
                                            ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($leases = $res->fetch_object()) {
                                                $payable_rent = $leases->lease_duration * $leases->property_cost;
                                            ?>
                                                <tr>
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
                                                        <b>REF: </b> <?php echo $leases->lease_ref; ?> <br>
                                                        <b>Duration: </b> <?php echo $leases->lease_duration; ?> Months <br>
                                                        <b>Payment Status: </b> <?php echo $leases->lease_payment_status; ?> <br>
                                                        <b>Date Leased: </b> <?php echo $leases->lease_date_added; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($leases->lease_payment_status != 'Paid') { ?>
                                                            <a data-toggle="modal" href="#update_<?php echo $leases->lease_id; ?>" class="badge badge-primary"><i class="fas fa-hand-holding-usd"></i> Collect Rent</a>
                                                        <?php  } else { ?>
                                                            <span class="badge badge-success"><i class="fas fa-check"></i> Already Paid</span>
                                                        <?php } ?>
                                                    </td>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade fixed-right" id="update_<?php echo $leases->lease_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog  modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header align-items-center">
                                                                    <div class="text-bold">
                                                                        <h6 class="text-bold">Collect Rent </h6>
                                                                    </div>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Payment Ref Code</label>
                                                                                <input type="text" required value="<?php echo $paycode; ?>" name="payment_ref" readonly class="form-control">
                                                                                <!-- Hidden Values -->
                                                                                <input type="hidden" required name="payment_lease_id" value="<?php echo $leases->lease_id; ?>" readonly class="form-control">
                                                                                <input type="hidden" required name="lease_property_id" value="<?php echo $leases->lease_property_id; ?>" readonly class="form-control">

                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Amount (Ksh)</label>
                                                                                <input type="text" value="<?php echo $payable_rent; ?>" required name="payment_amount" readonly class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Mode</label>
                                                                                <select name="payment_mode" class="form-control basic">
                                                                                    <option>Cash</option>
                                                                                    <option>MPESA</option>
                                                                                    <option>Debit/Credit Card</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="pay_lease" class="btn btn-warning">Add Payment</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
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