<?php
/*
 * Created on Tue Mar 08 2022
 *
 * Copyright (c) 2022 MartMbithi
 */
/* Handle Login */
require_once('../app/partials/head.php');
?>

<body class="hold-transition login-page" style="background-image: url('../assets/upload/background.jpg'); background-repeat: no-repeat; background-size: cover; ">
    <div class="login-box">
        <div class="login-logo">
            <a href="" class="text-white"><b>HOUSE RENTAL</b> MIS </a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
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
                        <input type="text" required name="user_phone" class="form-control" placeholder="Phone Number">
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
                            <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                </form>
                <a href="login" class="text-center">I already have a membership</a>
            </div>
        </div>
    </div>
    <?php require_once('../app/partials/scripts.php'); ?>
</body>

</html>