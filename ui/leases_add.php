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
    $lease_tenant_id = $_POST['lease_tenant_id'];
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
        $success = "Tenant Rental Record Added";
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
                            <h1 class="m-0 text-dark">House Rentals - Add Rental Record</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-4">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">House Rentals</a></li>
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
                                    <form method="post" enctype="multipart/form-data" role="form">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="">House Details</label>
                                                <select class="form-control basic" name="lease_property_id">
                                                    <option>Select House</option>
                                                    <?php
                                                    $ret = "SELECT * FROM properties p 
                                                    INNER JOIN categories c ON c.category_id  = p.property_category_id
                                                    INNER JOIN users u ON u.user_id = p.property_landlord_id
                                                    WHERE p.property_status = 'Vacant'";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($properties = $res->fetch_object()) { ?>
                                                        <option value="<?php echo $properties->property_id; ?>">
                                                            Code: <?php echo $properties->property_code . ', Name: ' . $properties->property_name . ', Location: ' . $properties->property_address; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label for="">Tenant Details</label>
                                                <select class="form-control basic" name="lease_tenant_id">
                                                    <option>Select Tenant</option>
                                                    <?php
                                                    $ret = "SELECT * FROM users WHERE user_access_level = 'tenant' 
                                                    ORDER BY user_name ASC ";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($tenants = $res->fetch_object()) {
                                                    ?>
                                                        <option value="<?php echo $tenants->user_id; ?>">IDNO: <?php echo $tenants->user_idno . ',  Names: ' . $tenants->user_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Rental Duration (Months)</label>
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
                                            <button type="submit" name="add_lease" class="btn btn-warning">Rent House</button>
                                        </div>
                                    </form>
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