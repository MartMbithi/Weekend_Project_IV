<?php
/* Add Category */
/* Update Category */
/* Delete Category */
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
                            <h1 class="m-0 text-dark">Property Categories Management Module</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item active">Property Categories</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
                <hr>
                <div class="text-right">
                    <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-warning"> Register New Category</button>
                </div>
                <!-- Add Landlord Modal -->
                <!-- Add Modal -->
                <div class="modal fade fixed-right" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog  modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header align-items-center">
                                <div class="text-center">
                                    <h6 class="mb-0 text-bold">Register New Category</h6>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data" role="form">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Category Code</label>
                                            <input type="text" required name="category_code" readonly class="form-control" id="exampleInputEmail1">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label for="">Category Name</label>
                                            <input type="text" required name="category_name" class="form-control" id="exampleInputEmail1">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" name="add_category" class="btn btn-warning">Register Category</button>
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
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Number Of Properties</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>Code</td>
                                                <td>Name</td>
                                                <td>5</td>
                                                <td>
                                                    <a data-toggle="modal" href="#update_" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                    <a data-toggle="modal" href="#delete_" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
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
                                                                            <label for="">Category Code</label>
                                                                            <input type="text" required name="category_code" readonly class="form-control" id="exampleInputEmail1">
                                                                        </div>
                                                                        <div class="form-group col-md-8">
                                                                            <label for="">Category Name</label>
                                                                            <input type="text" required name="category_name" class="form-control" id="exampleInputEmail1">
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <button type="submit" name="add_category" class="btn btn-warning">Register Category</button>
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
                                                                    <h4>Delete </h4>
                                                                    <br>
                                                                    <!-- Hide This -->
                                                                    <input type="hidden" name="category_id" value="">
                                                                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                    <input type="submit" name="delete_category" value="Delete" class="text-center btn btn-danger">
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