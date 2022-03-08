<?php
/*
 * Created on Tue Mar 08 2022
 *
 * Copyright (c) 2022 MartMbithi
 */
/* Handle Password Confirmations */
require_once('../app/partials/head.php');
?>

<body class="hold-transition login-page" style="background-image: url('../assets/upload/background.jpg'); background-repeat: no-repeat; background-size: cover; ">
    <div class="login-box">
        <div class="login-logo">
            <a href="" class="text-white"><b>HOUSE RENTAL</b> MIS </a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Enter your new password</p>
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="password" name="new_password" required class="form-control" placeholder="New Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="confirm_password" required class="form-control" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" name="confirm_password" class="btn btn-primary btn-block">Confirm Password</button>
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