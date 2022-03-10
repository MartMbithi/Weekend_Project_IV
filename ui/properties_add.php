<?php
/* Add Property */
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
                            <h1 class="m-0 text-dark">Property Management Module - Register Property</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-4">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Properties</a></li>
                                <li class="breadcrumb-item active">Register</li>
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
                                            <div class="form-group col-md-4">
                                                <label for="">Property Code</label>
                                                <input type="text" required name="property_code" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Property Name</label>
                                                <input type="text" required name="property_name" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Property Category</label>
                                                <select class="form-control basic" name="property_category_id">
                                                    <option>Select Category</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Property Address</label>
                                                <textarea type="text" name="property_address" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="add_property" class="btn btn-warning">Add Property</button>
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