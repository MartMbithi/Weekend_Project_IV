<?php
session_start();
require_once '../app/settings/config.php';
require_once '../app/settings/codeGen.php';

/* Handle Password Reset */
if (isset($_POST['reset_password'])) {
    $user_email = $_POST['user_email'];
    /* Check If User Exists */
    $sql = "SELECT * FROM  users WHERE user_email = '$user_email'";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        /* Redirect User To Confirm Password */
        $_SESSION['success'] = 'Password Reset Token Generated, Proceed To Confirm Password';
        $_SESSION['user_email'] = $user_email;
        header('Location: confirm_password');
        exit;
    } else {
        $err = "Nationa ID Number Does Not Exist";
    }
}
require_once('../app/partials/head.php');
?>

<body class="hold-transition login-page" style="background-image: url('../assets/upload/background.jpg'); background-repeat: no-repeat; background-size: cover; ">
    <div class="login-box">
        <div class="login-logo">
            <a href="" class="text-white"><b>HOUSE RENTAL</b> MIS </a>
        </div>
        <!-- /.login-logo -->
        <div class="card border border-success">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Enter your email to reset password</p>
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="user_email" required class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope text-primary"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <a href="login">I remembered password</a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="reset_password" class="btn btn-primary btn-block">Reset</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    <?php require_once('../app/partials/scripts.php'); ?>
</body>

</html>