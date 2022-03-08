<?php
/*
 * Created on Tue Mar 08 2022
 *
 * Copyright (c) 2022 MartMbithi
 */
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];
/* Redirect To Index Under Views */
header('Location: ' . $uri . '/ui/login');
exit;
