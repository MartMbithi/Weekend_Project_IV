<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();

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
                            <h1 class="m-0 text-dark">Revenue Reports</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item"><a href="">Reports</a></li>
                                <li class="breadcrumb-item active">Revenue</li>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group float-right m-t-15">
                                <form class="form-inline" method="POST">
                                    <label class="mr-sm-2" for="inlineFormCustomSelect">Start Date </label>
                                    <input required type="date" class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date">
                                    <label class="mr-sm-2" for="inlineFormCustomSelect">End Date </label>
                                    <input required type="date" class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date">
                                    <button type="submit" name="filter" class="btn btn-primary">Filter Revenue Reports</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <br><br><br>

            <section class="content">
                <div class="container-fluid">
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT * FROM properties p 
                                            INNER JOIN categories c ON c.category_id  = p.property_category_id
                                            INNER JOIN users u ON u.user_id = p.property_landlord_id";
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