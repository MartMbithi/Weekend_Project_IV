<?php
/*
 * Created on Tue Mar 08 2022
 *
 * Copyright (c) 2022 MartMbithi
 */

$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "";
$DB_name = "house_rental_mis";
try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $e->getMessage();
}
