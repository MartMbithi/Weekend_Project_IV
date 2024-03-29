<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();

/* Update Payments */
if (isset($_POST['update_payment'])) {
    $payment_id = $_POST['payment_id'];
    $payment_mode = $_POST['payment_mode'];

    /* Persist */
    $sql = "UPDATE payments SET payment_mode = ? WHERE payment_id = ?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('ss', $payment_mode, $payment_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Payment Record Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Delete  Psyments*/
if (isset($_POST['delete_payment'])) {
    $payment_id = $_POST['payment_id'];
    $payment_lease_id   = $_POST['lease_id'];

    /* Persist */
    $sql = "DELETE FROM payments WHERE payment_id =?";
    $lease_sql = "UPDATE house_rentals SET rental_payment_status ='Pending' WHERE rental_id = '$payment_lease_id'";

    $prepare = $mysqli->prepare($sql);
    $lease_prepare = $mysqli->prepare($lease_sql);

    $bind = $prepare->bind_param('s', $payment_id);

    $prepare->execute();
    $lease_prepare->execute();

    if ($prepare && $lease_prepare) {
        $success = "Payment Reversed";
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
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Rent Payments</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="landlord_dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Rent Collections</a></li>
                                <li class="breadcrumb-item active">Manage</li>
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
                            <div class="card card-success card-outline">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Rental Agreement Details</th>
                                                <th>House Details</th>
                                                <th>Tenant Details</th>
                                                <th>Payment Details</th>
                                                <th>Manage</th>
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
                                            WHERE hr.rental_eviction_status = '0' AND h.house_landlord_id = '$user_id'
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
                                                        <b>Category: </b> <?php echo $leases->category_name; ?> <br>
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
                                                    <td>
                                                        <a data-toggle="modal" href="#print_<?php echo $leases->payment_id; ?>" class="badge badge-success"><i class="fas fa-receipt"></i> Print Receipt</a>
                                                        <a data-toggle="modal" href="#update_<?php echo $leases->payment_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                        <a data-toggle="modal" href="#delete_<?php echo $leases->payment_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                    </td>
                                                    <!-- Print -->
                                                    <div class="modal fade fixed-right" id="print_<?php echo $leases->payment_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog  modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header align-items-center">
                                                                    <div class="text-bold">
                                                                        <h6 class="text-bold">Print Receipt For <?php echo $leases->payment_ref; ?></h6>
                                                                    </div>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="print_receipt">
                                                                        <div class="text-center text-bold">
                                                                            Rental Agreement Ref #<?php echo $leases->rental_ref; ?> Payment Receipt
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="card border border-success">
                                                                                    <div class="card-header">
                                                                                        <h3 class="card-title">
                                                                                            <i class="fas fa-user-tag"></i>
                                                                                            Tenant Details
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <div class="card-body">
                                                                                        <dl class="row">
                                                                                            <dt class="col-sm-4">Name</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->user_name; ?></dd>
                                                                                            <dt class="col-sm-4">IDNO </dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->user_idno; ?></dd>
                                                                                            <dt class="col-sm-4">Phone Number</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->user_phoneno; ?></dd>
                                                                                            <dt class="col-sm-4">Email</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->user_email; ?></dd>
                                                                                        </dl>
                                                                                    </div>
                                                                                    <!-- /.card-body -->
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="card border border-success">
                                                                                    <div class="card-header">
                                                                                        <h3 class="card-title">
                                                                                            <i class="fas fa-hotel"></i>
                                                                                            House Details
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <div class="card-body">
                                                                                        <dl class="row">
                                                                                            <dt class="col-sm-4">Code</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->house_code; ?></dd>
                                                                                            <dt class="col-sm-4">Name</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->house_name; ?></dd>
                                                                                            <dt class="col-sm-4">Category</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->category_name; ?></dd>
                                                                                            <dt class="col-sm-4">Location</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->house_address; ?></dd>
                                                                                        </dl>
                                                                                    </div>
                                                                                    <!-- /.card-body -->
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="card border border-success">
                                                                                    <div class="card-header">
                                                                                        <h3 class="card-title">
                                                                                            <i class="fas fa-edit"></i>
                                                                                            Rental Details
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <div class="card-body">
                                                                                        <dl class="row">
                                                                                            <dt class="col-sm-4">REF</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->rental_ref; ?></dd>
                                                                                            <dt class="col-sm-4">Leased Duration</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->rental_duration; ?> Months</dd>
                                                                                            <dt class="col-sm-4">Payment Status</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->rental_payment_status; ?></dd>
                                                                                            <dt class="col-sm-4">Date Leased</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->rental_date_added; ?></dd>
                                                                                        </dl>
                                                                                    </div>
                                                                                    <!-- /.card-body -->
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="card border border-success">
                                                                                    <div class="card-header">
                                                                                        <h3 class="card-title">
                                                                                            <i class="fas fa-hand-holding-usd"></i>
                                                                                            Payment Details
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <div class="card-body">
                                                                                        <dl class="row">
                                                                                            <dt class="col-sm-4">REF</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->payment_ref; ?></dd>
                                                                                            <dt class="col-sm-4">Amount Paid</dt>
                                                                                            <dd class="col-sm-8">Ksh <?php echo number_format($leases->payment_amount, 2); ?></dd>
                                                                                            <dt class="col-sm-4">Payment Mode</dt>
                                                                                            <dd class="col-sm-8"><?php echo $leases->payment_mode; ?></dd>
                                                                                            <dt class="col-sm-4">Date Paid</dt>
                                                                                            <dd class="col-sm-8"><?php echo date('d M Y g:ia', strtotime($leases->payment_date)); ?></dd>
                                                                                        </dl>
                                                                                    </div>
                                                                                    <!-- /.card-body -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <button class="btn btn-success" id="print" onclick="printContent('print_receipt');"> <i class="fas fa-print"></i> Print</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Print -->
                                                    <!-- Update Modal -->
                                                    <div class="modal fade fixed-right" id="update_<?php echo $leases->payment_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog  modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header align-items-center">
                                                                    <div class="text-bold">
                                                                        <h6 class="text-bold">Update <?php echo $leases->payment_ref; ?> </h6>
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
                                                                                <input type="text" required value="<?php echo $leases->payment_ref; ?>" name="payment_ref_code" readonly class="form-control">
                                                                                <!-- Hidden Values -->
                                                                                <input type="hidden" required name="payment_id" value="<?php echo $leases->payment_id; ?>" readonly class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Amount (Ksh)</label>
                                                                                <input type="text" required value="<?php echo number_format($leases->payment_amount, 2); ?>" name="payment_amount" readonly class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Mode</label>
                                                                                <select name="payment_mode" class="form-control basic">
                                                                                    <option><?php echo $leases->payment_mode; ?></option>
                                                                                    <option>Cash</option>
                                                                                    <option>MPESA</option>
                                                                                    <option>Debit/Credit Card</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_payment" class="btn btn-warning">Update Payment</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete_<?php echo $leases->payment_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <h4>Delete Payment <?php echo $leases->payment_ref; ?></h4>
                                                                        <br>
                                                                        <!-- Hide This -->
                                                                        <input type="hidden" name="payment_id" value="<?php echo $leases->payment_id; ?>">
                                                                        <input type="hidden" name="lease_id" value="<?php echo $leases->rental_id; ?>">
                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                        <input type="submit" name="delete_payment" value="Delete" class="text-center btn btn-danger">
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