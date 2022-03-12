<?php
session_start();
require_once('../app/settings/config.php');
require_once('../app/settings/codeGen.php');
require_once('../app/settings/checklogin.php');
check_login();

/* Add */
if (isset($_POST['add_category'])) {
    $category_code = $_POST['category_code'];
    $category_name = $_POST['category_name'];

    /* Persist */
    $sql = "INSERT INTO categories(category_code, category_name) VALUES(?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ss',
        $category_code,
        $category_name
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Property Category Added";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update */
if (isset($_POST['update_category'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];

    /* Persit */
    $sql = "UPDATE categories SET category_name =? WHERE category_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('ss', $category_name, $category_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Property Category Added";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Delete */
if (isset($_POST['delete_category'])) {
    $category_id = $_POST['category_id'];

    /* Delete */
    $sql = "DELETE FROM categories WHERE category_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $category_id);
    $prepare->execute();
    if ($prepare) {
        $info = "Property Category Deleted";
    } else {
        $err = "Failed, Please Try Again";
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
                                            <input type="text" required name="category_code" value="<?php echo $a . $b; ?>" readonly class="form-control" id="exampleInputEmail1">
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
                                            <?php
                                            $ret = "SELECT * FROM categories  ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($cat = $res->fetch_object()) {
                                                $category_id = $cat->category_id;
                                                /* Number Of Properties Per Category */
                                                $query = "SELECT COUNT(*)  FROM properties WHERE property_category_id  = '$category_id' ";
                                                $stmt = $mysqli->prepare($query);
                                                $stmt->execute();
                                                $stmt->bind_result($registered_properties);
                                                $stmt->fetch();
                                                $stmt->close();
                                            ?>
                                                <tr>
                                                    <td><?php echo $cat->category_code; ?></td>
                                                    <td><?php echo $cat->category_name; ?></td>
                                                    <td><?php echo $registered_properties; ?></td>
                                                    <td>
                                                        <a data-toggle="modal" href="#update_<?php echo $cat->category_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                        <a data-toggle="modal" href="#delete_<?php echo $cat->category_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                    </td>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade fixed-right" id="update_<?php echo $cat->category_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog  modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header align-items-center">
                                                                    <div class="text-bold">
                                                                        <h6 class="text-bold">Update <?php echo $cat->category_name; ?> </h6>
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
                                                                                <input type="hidden" value="<?php echo $cat->category_id; ?>" required name="category_id" readonly class="form-control" id="exampleInputEmail1">
                                                                                <input type="text" value="<?php echo $cat->category_code; ?>" required name="category_code" readonly class="form-control" id="exampleInputEmail1">
                                                                            </div>
                                                                            <div class="form-group col-md-8">
                                                                                <label for="">Category Name</label>
                                                                                <input type="text" required value="<?php echo $cat->category_name; ?>" name="category_name" class="form-control" id="exampleInputEmail1">
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_category" class="btn btn-warning">Update Category</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete_<?php echo $cat->category_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <h4>Delete <?php echo $cat->category_name; ?></h4>
                                                                        <br>
                                                                        <!-- Hide This -->
                                                                        <input type="hidden" name="category_id" value="<?php echo $cat->category_id; ?>">
                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                        <input type="submit" name="delete_category" value="Delete" class="text-center btn btn-danger">
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