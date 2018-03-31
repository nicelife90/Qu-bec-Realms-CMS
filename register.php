<?php
/**
 * Copyright (C) 2014 - 2017 Threenity CMS - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary  and confidential
 * Written by : nicelife90 <yanicklafontaine@gmail.com>
 * Last edit : 2018
 *
 *
 */

/**
 * Created by PhpStorm.
 * User: ylafontaine
 * Date: 2017-10-10
 * Time: 13:47
 */

require $_SERVER['DOCUMENT_ROOT'] . '/app/Helpers/Loader.php';

use ThreenityCMS\Controllers\Register;
use ThreenityCMS\Helpers\Messages;
use ThreenityCMS\Helpers\Path;
use ThreenityCMS\Helpers\Request;
use ThreenityCMS\Helpers\Session;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Threenity CMS</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?php echo Path::img(); ?>/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo Path::img(); ?>/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo Path::comp(); ?>/bootstrap/dist/css/bootstrap.min.css">
    <script src="<?php echo Path::comp(); ?>/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo Path::comp(); ?>/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo Path::css(); ?>/auth.css">
</head>
<body>

<div class="bg"></div>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (!is_null(Request::post('register')) && Session::getFormId('register') == Request::post('DBLP')) {
                    try {
                        Register::register();
                        Messages::success("Your account as been created.");
                    } catch (Exception $e) {
                        Messages::error($e->getMessage());
                    }
                }
                ?>
            </div>
        </div>
        <br/>
        <!-- Icon -->
        <div class="fadeIn first">
            <img src="<?php echo Path::img(); ?>/login.png" id="icon" alt="User Icon"/>
        </div>
        <br/>
        <!-- Login Form -->
        <form class="form-signin" action="<?php echo Path::root(); ?>/register.php" method="post">
            <input type="hidden" name="DBLP" value="<?php echo Session::setFormId('register'); ?>">
            <input type="text" id="login" class="fadeIn second" placeholder="Username" name="username" required
                   autofocus>
            <input type="password" id="password" class="fadeIn third" placeholder="Password" name="password" required>
            <input type="password" id="password" class="fadeIn third" placeholder="Password" name="password2" required>
            <br/><br/>
            <input type="submit" class="fadeIn fourth" value="Register" name="register">
        </form>


    </div>
</div>
</body>
</html>