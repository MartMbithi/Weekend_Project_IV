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
    $lease_tenant_id = $_SESSION['user_id'];
    $lease_duration = $_POST['lease_duration'];
    $lease_date_added = date('d M Y g:ia');

    /* Persist */
    $sql = "INSERT INTO property_leases (lease_ref, lease_property_id, lease_tenant_id, lease_duration, lease_date_added)
    VALUES(?,?,?,?,?)";
    $property_sql = "UPDATE properties SET property_status = 'Leased' WHERE property_id =?";

    $prepare = $mysqli->prepare($sql);
    $property_prepare  = $mysqli->prepare($property_sql);

    $bind = $prepare->bind_param(
        'sssss',
        $lease_ref,
        $lease_property_id,
        $lease_tenant_id,
        $lease_duration,
        $lease_date_added
    );
    $property_bind  = $property_prepare->bind_param(
        's',
        $lease_property_id
    );

    $prepare->execute();
    $property_prepare->execute();

    if ($prepare  && $property_prepare) {
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
                            <h1 class="m-0 text-dark">Property Leases - Add Lease</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-4">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="my_dashboard">Home</a></li>
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
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Property Landlord</th>
                                                <th>Location</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT * FROM properties p 
                                            INNER JOIN categories c ON c.category_id  = p.property_category_id
                                            INNER JOIN users u ON u.user_id = p.property_landlord_id
                                            WHERE p.property_status ='Vacant'";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($properties = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $properties->property_code; ?></td>
                                                    <td><?php echo $properties->property_name; ?></td>
                                                    <td><?php echo $properties->category_name; ?></td>
                                                    <td><?php echo $properties->user_name; ?></td>
                                                    <td><?php echo $properties->property_address; ?></td>
                                                    <td>
                                                        <a href="tenant_property?view=<?php echo $properties->property_id; ?>" class="badge badge-success"><i class="fas fa-eye"></i> View</a>
                                                        <a data-toggle="modal" href="#update_<?php echo $properties->property_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Lease Property</a>
                                                    </td>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade fixed-right" id="update_<?php echo $properties->property_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog  modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header align-items-center">
                                                                    <div class="text-bold">
                                                                        <h6 class="text-bold">Lease This Property </h6>
                                                                    </div>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-12">
                                                                                <label for="">Lease Duration (Months)</label>
                                                                                <input type="hidden" name="lease_property_id" value="<?php echo $properties->property_id; ?>">
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