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
        $ret = "SELECT * FROM properties p 
        INNER JOIN categories c ON c.category_id  = p.property_category_id
        INNER JOIN users u ON u.user_id = p.property_landlord_id
        WHERE property_id = '$view' ";
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
                                <h1><?php echo $property->property_name; ?> Details</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Properties</a></li>
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
                                                <img src="../data/<?php echo $property->property_img_1; ?>" class="d-block w-100" alt="...">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="../data/<?php echo $property->property_img_2; ?>" class="d-block w-100" alt="...">
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
                                        <h5 class="text-center">Property Details</h5>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="activity">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <fieldset class="border border-primary p-2">
                                                            <legend class="w-auto text-primary font-weight-light">Rental Property Details </legend>
                                                            <div class="card-body">
                                                                <ul class="list-group list-group-unbordered mb-3">
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-tag text-warning"></i> Code: </b> <a class="float-right"><?php echo $property->property_code; ?></a>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-check text-warning"></i> Name: </b> <a class="float-right"><?php echo $property->property_name; ?></a>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-list  text-warning"></i> Category: </b> <a class="float-right"><?php echo $property->category_name; ?></a>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b><i class="fas fa-map-pin text-warning"></i> Location: </b> <a class="float-right"><?php echo $property->property_address; ?></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">
                                                        <fieldset class="border border-primary p-2">
                                                            <legend class="w-auto text-primary font-weight-light">Property Owner Details </legend>
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
                                                </div>
                                            </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="caretaker">

                                            </div>
                                            <div class="tab-pane" id="lease">

                                            </div>
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.nav-tabs-custom -->
                            </div>
                            <!-- /.col -->
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