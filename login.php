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

use ThreenityCMS\Controllers\Login;
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
    <link rel="icon" type="image/png" href="<?php echo Path::img(); ?>/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo Path::img(); ?>/favicon.ico">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo Path::css(); ?>/auth.css">
</head>
<body>
<div class="container">
    <div class="card card-container">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (!is_null(Request::post('login')) && Session::getFormId('login') == Request::post('DBLP')) {
                    try {
                        Login::login();
                    } catch (Exception $e) {
                        Messages::error($e->getMessage());
                    }
                }
                ?>
            </div>
        </div>
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png"/>
        <p id="profile-name" class="profile-name-card"></p>
        <form class="form-signin" action="<?php echo Path::root(); ?>/login.php" method="post">
            <input type="hidden" name="DBLP" value="<?php echo Session::setFormId('login'); ?>">
            <span id="reauth-email" class="reauth-email"></span>
            <input type="text" id="inputEmail" class="form-control" placeholder="Username" name="username" required
                   autofocus>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password"
                   required>
            <button name="login" class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Login</button>
        </form>
    </div>
</div>
</body>
</html>