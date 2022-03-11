<?php
session_start();
require_once '../app/settings/config.php';

/* Handle Sign In */
if (isset($_POST['create_account'])) {
    $user_name =  $_POST['user_name'];
    $user_idno = $_POST['user_idno'];
    $user_email = $_POST['user_email'];
    $new_password = sha1(md5($_POST['new_password']));
    $confirm_password = sha1(md5($_POST['confirm_password']));
    $user_phoneno = $_POST['user_phoneno'];
    $user_access_level = $_GET['access'];

    /* Check If Passwords Match */
    if ($new_password != $confirm_password) {
        $err = "Passwords Does Not Match";
    } else {
        /* Avoid Data Replication Exists */
        $sql = "SELECT * FROM  users WHERE user_idno = '$user_idno' 
        || user_phoneno = '$user_phoneno' || user_email = '$user_email'";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $users = mysqli_fetch_assoc($res);
            /* If ID Number Already Exists Exit */
            if (
                $users['user_idno'] == $user_idno
                || $users['user_phoneno'] == $user_phoneno
                || $users['user_email'] == $user_email
            ) {
                $err = "National ID Number, Email Or Phone Number Already Exists";
            }
        } else {
            /* Insert Details */
            $sql = "INSERT INTO users(user_name, user_idno, user_email, user_password, user_phoneno, user_access_level) VALUES(?,?,?,?,?,?)";
            $prepare = $mysqli->prepare($sql);
            $bind = $prepare->bind_param(
                'ssssss',
                $user_name,
                $user_idno,
                $user_email,
                $confirm_password,
                $user_phoneno,
                $user_access_level
            );
            $prepare->execute();
            if ($prepare) {
                /* Pass This Alert Via Session */
                $_SESSION['success'] = 'Your Account Has Been Created, Proceed To Login';
                header('Location: login');
                exit;
            } else {
                $err = "Failed!, Please Try Again";
            }
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
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a <?php echo $_GET['access']; ?> account </p>
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" required name="user_name" class="form-control" placeholder="Full Name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" required name="user_phoneno" class="form-control" placeholder="Phone Number">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" required name="user_email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" required name="user_idno" class="form-control" placeholder="National ID Number">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-tag"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" required name="new_password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" required name="confirm_password" class="form-control" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" checked name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="">terms</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" name="create_account" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                </form>
                <a href="login" class="text-center">I already have a <?php echo $_GET['access']; ?> account</a>
            </div>
        </div>
    </div>
    <?php require_once('../app/partials/scripts.php'); ?>
</body>

</html>