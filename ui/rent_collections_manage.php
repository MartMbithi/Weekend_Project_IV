<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();

/* Update Payments */
if (isset($_POST['update'])) {
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
                            <h1 class="m-0 text-dark">Rent Payments Management Module</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
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
                            <div class="card card-warning card-outline">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Lease Details</th>
                                                <th>Payment Details</th>
                                                <th>Date Paid</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>Code</td>
                                                <td>Code</td>
                                                <td>Code</td>
                                                <td>
                                                    <a data-toggle="modal" href="#print_" class="badge badge-success"><i class="fas fa-receipt"></i> Print Receipt</a>
                                                    <a data-toggle="modal" href="#update_" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                    <a data-toggle="modal" href="#delete_" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                                <!-- Print -->
                                                <div class="modal fade fixed-right" id="print_" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog  modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header align-items-center">
                                                                <div class="text-bold">
                                                                    <h6 class="text-bold">Print Receipt</h6>
                                                                </div>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Print -->
                                                <!-- Update Modal -->
                                                <div class="modal fade fixed-right" id="update_" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog  modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header align-items-center">
                                                                <div class="text-bold">
                                                                    <h6 class="text-bold">Update </h6>
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
                                                                            <input type="text" required name="payment_ref_code" readonly class="form-control">
                                                                            <!-- Hidden Values -->
                                                                            <input type="hidden" required name="payment_id" readonly class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="">Amount (Ksh)</label>
                                                                            <input type="text" required name="payment_amount" readonly class="form-control">
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
                                                                        <button type="submit" name="update_payment" class="btn btn-warning">Update Payment</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="delete_" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                    <h4>Delete Payment </h4>
                                                                    <br>
                                                                    <!-- Hide This -->
                                                                    <input type="hidden" name="property_id" value="">
                                                                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                    <input type="submit" name="delete_payment" value="Delete" class="text-center btn btn-danger">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </tr>

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