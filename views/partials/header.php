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

require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Helpers/Loader.php';

use ThreenityCMS\Helpers\Debugbar;
use ThreenityCMS\Helpers\Path;
use ThreenityCMS\Helpers\Security;
use ThreenityCMS\Helpers\Session;
use ThreenityCMS\Models\Threenity\AccountModel;
use ThreenityCMS\Models\Threenity\GroupModel;

/**
 * Validate access to the current page
 */
Security::validateAccess();

?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Threenity CMS | Portal</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" href="<?php echo Path::img(); ?>/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo Path::img(); ?>/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo Path::comp(); ?>/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo Path::comp(); ?>/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo Path::comp(); ?>/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo Path::css(); ?>/AdminLTE.css">
        <link rel="stylesheet" href="<?php echo Path::css(); ?>/skins/skin-black.css">
        <link rel="stylesheet" href="<?php echo Path::css(); ?>/threenity.css">
        <link rel="stylesheet"
              href="<?php echo Path::comp(); ?>/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <script src="<?php echo Path::comp(); ?>/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo Path::comp(); ?>/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo Path::comp(); ?>/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo Path::comp(); ?>/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo Path::js(); ?>/adminlte.min.js"></script>

        <!-- Alertify -->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/themes/bootstrap.min.css"/>

        <!-- Lightbox2 -->
        <script src="<?php echo Path::comp(); ?>/lightbox2/js/lightbox.js"></script>
        <link rel="stylesheet" href="<?php echo Path::comp(); ?>/lightbox2/css/lightbox.css">

        <!-- CKEDITOR -->
        <script type="text/javascript" src="<?php echo Path::comp(); ?>/ckeditor/ckeditor.js"></script>

        <!-- Select -->
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

        <script>

        </script>

        <!-- Pace -->
        <link rel="stylesheet" href="<?php echo Path::comp(); ?>/PACE/themes/red/pace-theme-loading-bar.css">
        <script data-pace-options='{ "startOnPageLoad": false }'
                src="<?php echo Path::comp(); ?>/PACE/pace.min.js"></script>


        <!-- Debug Bar -->
        <?php
        if (Security::can(3)) {
            Debugbar::getHeaderHTML();
        }
        ?>
    </head>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="<?php echo Path::root(); ?>" class="logo">
            <span class="logo-mini"><img src="<?php echo Path::img(); ?>/logo-small.png" height="40"
                                         width="40"/></span>
            <span class="logo-lg"><img src="<?php echo Path::img(); ?>/logo-header.png"/></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>


            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">


                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="<?php echo Path::profileImg(); ?>/<?php echo AccountModel::getProfileImg(Session::get("account_id")); ?>"
                                 class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><?php
                                echo AccountModel::getFullName(Session::get("account_id")) ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="<?php echo Path::profileImg(); ?>/<?php echo AccountModel::getProfileImg(Session::get("account_id")); ?>"
                                     class="img-circle" alt="User Image"/>
                                <p>
                                    <?php
                                    echo AccountModel::getFullName(Session::get("account_id")); ?>
                                    <small>
                                        <?php echo GroupModel::getNameById(AccountModel::getAccountGroup(Session::get("account_id"))); ?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo Path::root(); ?>/views/profile.php"
                                       class="btn btn-default btn-flat">My account</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo Path::root(); ?>/logout.php"
                                       class="btn btn-danger btn-flat">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/partials/menu.php';