<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/checklogin.php');
/* Head Partial */
require_once('../app/partials/head.php');
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once('../app/partials/nav.php'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once('../app/partials/aside.php');
        $view = $_GET['view'];
        $ret = "SELECT * FROM houses h
        INNER JOIN categories c ON c.category_id  = h.house_category_id
        INNER JOIN users u ON u.user_id = h.house_landlord_id
        WHERE h.house_id = '$view' ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        while ($property = $res->fetch_object()) {
        ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1><?php echo $property->house_name; ?></h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Houses</a></li>
                                    <li class="breadcrumb-item active">Details</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Profile Image -->
                                <div class="card card-warning card-outline card-body">
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                        </ol>
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img src="../data/<?php echo $property->house_img_1; ?>" class="d-block w-100" alt="...">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="../data/<?php echo $property->house_img_2; ?>" class="d-block w-100" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-12">
                                <div class="card card-warning card-outline">
                                    <div class="card-header p-2">
                                        <h5 class="text-center">House Details</h5>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="activity">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <fieldset class="border border-primary p-2">
                                                            <legend class="w-auto text-primary font-weight-light">Rental House Details </legend>
                                                            <div class="card-body">
                                                                <ul class="list-group list-group-unbordered mb-3">
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-tag text-warning"></i> Code: </b> <a class="float-right"><?php echo $property->house_code; ?></a>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-check text-warning"></i> Name: </b> <a class="float-right"><?php echo $property->house_name; ?></a>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-list  text-warning"></i> Category: </b> <a class="float-right"><?php echo $property->category_name; ?></a>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-map-pin text-warning"></i> Location: </b> <a class="float-right"><?php echo $property->house_address; ?></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">
                                                        <fieldset class="border border-primary p-2">
                                                            <legend class="w-auto text-primary font-weight-light">House Owner Details </legend>
                                                            <div class="card-body">
                                                                <ul class="list-group list-group-unbordered mb-3">
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-user-tie text-warning"></i> Names: </b> <a class="float-right"><?php echo $property->user_name; ?></a>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-phone text-warning"></i> Contacts: </b> <a class="float-right"><?php echo $property->user_phoneno; ?></a>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-envelope text-warning"></i> Email: </b> <a class="float-right"><?php echo $property->user_email; ?></a>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-map-pin text-warning"></i> Address: </b> <a class="float-right"><?php echo $property->user_address; ?></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">
                                                        <fieldset class="border border-primary p-2">
                                                            <legend class="w-auto text-primary font-weight-light">Assigned Caretaker (s) Details </legend>
                                                            <?php
                                                            $ret = "SELECT * FROM caretaker_assigns ca 
                                                            INNER JOIN users u ON ca.assignment_caretaker_id = u.user_id
                                                            INNER JOIN houses h ON h.house_id = ca.assignment_house_id 
                                                            WHERE h.house_id = '$view'";
                                                            $stmt = $mysqli->prepare($ret);
                                                            $stmt->execute(); //ok
                                                            $res = $stmt->get_result();
                                                            while ($assn = $res->fetch_object()) {
                                                            ?>
                                                                <div class="card-body">
                                                                    <ul class="list-group list-group-unbordered mb-3">
                                                                        <li class="list-group-item">
                                                                            <b><i class="fas fa-user-tie text-warning"></i> Names: </b> <a class="float-right"><?php echo $assn->user_name; ?></a>
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            <b><i class="fas fa-phone text-warning"></i> Contacts: </b> <a class="float-right"><?php echo $assn->user_phoneno; ?></a>
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            <b><i class="fas fa-envelope text-warning"></i> Email: </b> <a class="float-right"><?php echo $assn->user_email; ?></a>
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            <b><i class="fas fa-map-pin text-warning"></i> Address: </b> <a class="float-right"><?php echo $assn->user_address; ?></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            <?php } ?>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">
                                                        <fieldset class="border border-primary p-2">
                                                            <legend class="w-auto text-primary font-weight-light">Rental History </legend>

                                                            <div class="card-body">
                                                                <div class="timeline">
                                                                    <?php
                                                                    $ret = "SELECT * FROM house_rentals hr
                                                                    INNER JOIN  houses h on h.house_id = hr.rental_house_id
                                                                    INNER JOIN categories c ON c.category_id  = h.house_category_id
                                                                    INNER JOIN users u ON u.user_id = hr.rental_tenant_id 
                                                                    WHERE hr.rental_eviction_status = '0'  AND  h.house_id = '$view'
                                                                    ORDER BY hr.rental_date_added  ASC LIMIT 5
                                                                    ";
                                                                    $stmt = $mysqli->prepare($ret);
                                                                    $stmt->execute(); //ok
                                                                    $res = $stmt->get_result();
                                                                    while ($leases = $res->fetch_object()) {
                                                                    ?>
                                                                        <!-- timeline time label -->
                                                                        <div class="time-label">
                                                                            <span class="bg-success"><?php echo $leases->rental_date_added; ?></span>
                                                                        </div>
                                                                        <div>
                                                                            <i class="fas fa-user-tag bg-blue"></i>
                                                                            <div class="timeline-item">
                                                                                <h3 class="timeline-header">Lease Details</h3>
                                                                                <div class="timeline-body">
                                                                                    <b>Tenant Name: </b> <?php echo $leases->user_name; ?> <br>
                                                                                    <b>Tenant IDNO: </b> <?php echo $leases->user_idno; ?> <br>
                                                                                    <b>Tenant Phone No : </b> <?php echo $leases->user_phoneno; ?> <br>
                                                                                    <b>Tenant Email : </b> <?php echo $leases->user_email; ?> <br>
                                                                                    <b>Rental REF: </b> <?php echo $leases->rental_ref; ?> <br>
                                                                                    <b>Rental Duration: </b> <?php echo $leases->rental_duration; ?> Months <br>
                                                                                    <b>Rental Payment Status: </b> <?php echo $leases->rental_payment_status; ?> <br>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        <?php } ?>
        <!-- Footer -->
        <?php require_once('../app/partials/footer.php'); ?>
    </div>
    <!-- Scripts -->
    <?php require_once('../app/partials/scripts.php'); ?>
</body>

</html>