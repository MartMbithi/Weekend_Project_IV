<?php
session_start();
require_once '../app/settings/config.php';
require_once '../app/settings/codeGen.php';
/* Handle Password Reset */
if (isset($_POST['reset_password'])) {
    $user_email = $_SESSION['user_email'];
    $new_password = sha1(md5($_POST['new_password']));
    $confirm_password = sha1(md5($_POST['confirm_password']));

    /* Check If They Match */
    if ($new_password != $confirm_password) {
        $err = "Passwords Does Not Match";
    } else {
        $sql = "UPDATE users SET user_password =? WHERE user_email = ?";
        $prepare = $mysqli->prepare($sql);
        $bind  = $prepare->bind_param(
            'ss',
            $confirm_password,
            $user_email
        );
        $prepare->execute();
        if ($prepare) {
            /* Pass This Alert Via Session */
            $_SESSION['success'] = 'Your Password Has Been Reset Proceed To Login';
            header('Location: login');
            exit;
        } else {
            $err = "Failed!, Please Try Again";
        }
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
                <p class="login-box-msg">Enter your new password</p>
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="password" name="new_password" required class="form-control" placeholder="New Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock text-primary"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="confirm_password" required class="form-control" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock text-primary"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" name="reset_password" class="btn btn-primary btn-block">Confirm Password</button>
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