<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();
/* Add Expense */
if (isset($_POST['add_expense'])) {
    $expense_ref = $a . $b;
    $expense_name = $_POST['expense_name'];
    $expense_amount = $_POST['expense_amount'];
    $expense_desc = $_POST['expense_desc'];
    $expense_date_added = $_POST['expense_date_added'];

    /* Perisst */
    $sql = "INSERT INTO expenses (expense_ref, expense_name, expense_amount, expense_desc, expense_date_added)
    VALUES(?,?,?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sssss',
        $expense_ref,
        $expense_name,
        $expense_amount,
        $expense_desc,
        $expense_date_added
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Expense Ref #$expense_ref Added";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update Expenses */
if (isset($_POST['update_expense'])) {
    $expense_id = $_POST['expense_id'];
    $expense_name = $_POST['expense_name'];
    $expense_amount = $_POST['expense_amount'];
    $expense_desc = $_POST['expense_desc'];
    $expense_date_added = $_POST['expense_date_added'];

    /* Persist */
    $sql = "UPDATE expenses SET expense_name =?, expense_amount =?, expense_desc =?, expense_date_added =? WHERE 
    expense_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sssss',
        $exepense_name,
        $expense_amount,
        $expense_desc,
        $expense_date_added,
        $expense_id
    );
    $prepare->execute();
    if ($prepare) {
        $success  = "Expense Record Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Delete Expenses */
if (isset($_POST['delete_expenses'])) {
    $expense_id = $_POST['expense_id'];

    /* Delete */
    $sql = "DELETE FROM expenses WHERE expense_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $expense_id);
    if ($prepare) {
        $success = "Expense Deleted";
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
                        <div class="col-sm-7">
                            <h1 class="m-0 text-dark">Expenses Management Module </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-5">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item active">Expenses</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
                <hr>
                <div class="text-right">
                    <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-warning"> Add Expense</button>
                </div>
                <!-- Add Landlord Modal -->
                <!-- Add Modal -->
                <div class="modal fade fixed-right" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog  modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header align-items-center">
                                <div class="text-center">
                                    <h6 class="mb-0 text-bold"> Add Expenses</h6>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data" role="form">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Expense Ref Code</label>
                                            <input type="text" required name="expense_ref" value="<?php echo $a . $b; ?>" readonly class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Expense Amount (Ksh)</label>
                                            <input type="text" required name="expense_amount" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Expense Date</label>
                                            <input type="date" required name="expense_date_added" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="">Expense Name</label>
                                            <input type="text" required name="expense_name" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="">Expense Description</label>
                                            <textarea type="text" required name="expense_desc" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" name="add_expense" class="btn btn-warning">Add Expense</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
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
                                                <th>REF NO</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Desc</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT * FROM expenses";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($exp = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $exp->exepense_ref; ?></td>
                                                    <td><?php echo $exp->expense_name; ?></td>
                                                    <td><?php echo number_format($exp->expense_amount); ?></td>
                                                    <td><?php echo $exp->$expense_desc; ?></td>
                                                    <td>
                                                        <a data-toggle="modal" href="#update_<?php echo $exp->expense_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                        <a data-toggle="modal" href="#delete_<?php echo $exp->expense_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                    </td>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade fixed-right" id="update_<?php echo $exp->expense_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog  modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header align-items-center">
                                                                    <div class="text-bold">
                                                                        <h6 class="text-bold">Update Expense Ref #<?php echo $exp->expense_ref; ?></h6>
                                                                    </div>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Expense Ref Code</label>
                                                                                <input type="text" required name="expense_ref_code" readonly class="form-control">
                                                                                <!-- Hide This -->
                                                                                <input type="hidden" required name="expense_id" readonly class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Expense Amount (Ksh)</label>
                                                                                <input type="text" required name="expense_amount" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-12">
                                                                                <label for="">Expense Description</label>
                                                                                <textarea type="text" required name="expense_desc" class="form-control"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_expense" class="btn btn-warning">Add Expense</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete_<?php echo $exp->expense_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <h4>Delete Expense Ref #<?php echo $exp->expense_ref; ?> </h4>
                                                                        <br>
                                                                        <!-- Hide This -->
                                                                        <input type="hidden" name="expense_id" value="<?php echo $exp->expense_id; ?>">
                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                        <input type="submit" name="delete_expense" value="Delete" class="text-center btn btn-danger">
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