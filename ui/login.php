<?php
session_start();
require_once '../app/settings/config.php';

/* Handle Login  */
if (isset($_POST['login'])) {
    $user_email = $_POST['user_email'];
    $user_password = sha1(md5($_POST['user_password']));

    $stmt = $mysqli->prepare("SELECT user_name, user_password, user_email, user_access_level, user_id FROM users WHERE user_email =? AND user_password =?");
    $stmt->bind_param('ss', $user_email, $user_password);
    $stmt->execute();
    $stmt->bind_result($user_name, $user_password, $user_email, $user_access_level, $user_id);
    $rs = $stmt->fetch();

    /* Session Variables */
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_access_level'] = $user_access_level;
    $_SESSION['user_name'] = $user_name;

    if ($rs && $user_access_level == "admin") {
        /* Pass This Alert Via Session */
        $_SESSION['success'] = 'You Have Successfully Logged in to Administrator Dashboard';
        header('Location: dashboard');
        exit;
    } elseif ($rs && $user_access_level == "tenant") {
        $_SESSION['success'] = 'You Have Successfully Logged in to Tenant Dashboard';
        header('Location: my_dashboard');
        exit;
    } else {
        $err = "Access Denied Please Check Your Email Or Password";
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
                <p class="login-box-msg">Sign in to start your session</p>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="user_email" required class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text ">
                                <span class="fas fa-envelope text-primary"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="user_password" required class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock text-primary"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <a href="reset_password">I forgot my password</a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <a href="register?access=tenant" class="text-left">Join as tenant</a>
                    </div>
                    <div class="col-6">
                        <a href="register?access=landlord" class="text-right">Join as landlord</a>
                    </div>
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    <?php require_once('../app/partials/scripts.php'); ?>
</body>

</html>