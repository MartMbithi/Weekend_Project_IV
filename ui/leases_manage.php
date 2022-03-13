<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();

/* Evict */
if (isset($_POST['evict'])) {
    $lease_id = $_POST['lease_id'];
    $lease_eviction_status = '1';
    $lease_property_id = $_POST['lease_property_id'];

    /* Persist */
    $sql = "UPDATE property_leases SET lease_eviction_status =? WHERE lease_id =?";
    $property_sql = "UPDATE properties SET property_status = 'Vacant' WHERE property_id ='$lease_property_id'";

    $prepare = $mysqli->prepare($sql);
    $property_prepare = $mysqli->prepare($property_sql);

    $bind = $prepare->bind_param('ss', $lease_eviction_status, $lease_id);


    $prepare->execute();
    $property_prepare->execute();

    if ($prepare && $property_prepare) {
        $info = "Tenant Evicted";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update Lease */
if (isset($_POST['update_lease'])) {
    $lease_id = $_POST['lease_id'];
    $lease_duration = $_POST['lease_duration'];

    /* Persist */
    $sql = "UPDATE property_leases SET  lease_duration =? WHERE lease_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ss',
        $lease_duration,
        $lease_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Lease Record Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Delete */
if (isset($_POST['delete_lease'])) {
    $lease_id  = $_POST['lease_id'];
    $lease_property_id = -$_POST['lease_property_id'];

    /* Delete */
    $sql = "DELETE FROM property_leases WHERE lease_id =?";
    $property_sql = "UPDATE properties SET property_status = 'Vacant' WHERE property_id ='$lease_property_id'";


    $prepare = $mysqli->prepare($sql);
    $property_prepare = $mysqli->prepare($property_sql);

    $bind = $prepare->bind_param('s', $lease_id);

    $prepare->execute();
    $property_prepare->execute();

    if ($prepare && $property_prepare) {
        $info = "Lease Record Deleted";
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
                            <h1 class="m-0 text-dark">Property Leases Module - Manage Leases</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-4">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Property Leases</a></li>
                                <li class="breadcrumb-item active">Manage Leases</li>
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
                                            ?> <tr>
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
                                                        <a data-toggle="modal" href="#update_<?php echo $leases->lease_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a> <br>
                                                        <a data-toggle="modal" href="#vacate_<?php echo $leases->lease_id; ?>" class="badge badge-warning"><i class="fas fa-ban"></i> Evict</a> <br>
                                                        <a data-toggle="modal" href="#delete_<?php echo $leases->lease_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                    </td>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade fixed-right" id="update_<?php echo $leases->lease_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog  modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header align-items-center">
                                                                    <div class="text-bold">
                                                                        <h6 class="text-bold">Update <?php echo $leases->lease_ref; ?> </h6>
                                                                    </div>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-9">
                                                                                <label for="">Property Details</label>
                                                                                <!-- Hide This -->
                                                                                <input type="hidden" required name="lease_id" value="<?php echo $leases->lease_id; ?>" class="form-control">
                                                                                <select class="form-control basic" name="lease_property_id">
                                                                                    <option value="<?php echo $leases->lease_property_id; ?>">
                                                                                        Code: <?php echo $leases->property_code . ', Name: ' . $leases->property_name . ', Location: ' . $leases->property_address; ?>
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-3">
                                                                                <label for="">Lease Duration (Months)</label>
                                                                                <select class="form-control basic" name="lease_duration">
                                                                                    <option><?php echo $leases->lease_duration; ?></option>
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
                                                                            <button type="submit" name="update_lease" class="btn btn-warning">Update Lease</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->

                                                    <!-- Vacate Modal -->
                                                    <div class="modal fade" id="vacate_<?php echo $leases->lease_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">CONFIRM EVICTION</h5>
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST">
                                                                    <div class="modal-body text-center text-danger">
                                                                        <h4>Evict Tenant?</h4>
                                                                        <br>
                                                                        <!-- Hide This -->
                                                                        <input type="hidden" name="lease_id" value="<?php echo $leases->lease_id; ?>">
                                                                        <input type="hidden" name="lease_property_id" value="<?php echo $leases->lease_property_id; ?>">
                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                        <input type="submit" name="evict" value="Yes" class="text-center btn btn-danger">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete_<?php echo $leases->lease_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <h4>Delete </h4>
                                                                        <br>
                                                                        <!-- Hide This -->
                                                                        <input type="hidden" name="property_id" value="">
                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                        <input type="submit" name="delete_lease" value="Delete" class="text-center btn btn-danger">
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