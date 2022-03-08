<?php
/*
 * Created on Tue Mar 08 2022
 *
 * Copyright (c) 2022 MartMbithi
 */
function check_login()
{
	if ((strlen($_SESSION['user_id']) == 0)) {
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = "../index";
		$_SESSION["user_id"] = "";
		header("Location: http://$host$uri/$extra");
	}
}
