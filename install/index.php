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

session_start();
if (!isset($_SESSION["INSTALL"])) {
	echo "Unable to directly access the application installation folder!";
	die;
}
else {

    if (!file_exists($_SERVER["DOCUMENT_ROOT"] . "/vendor")) {
        echo "Composer package are not installed!<br/>Your need to run : <strong>composer install</strong> from your website root directory before trying to install the CMS.<br/>";
        echo "Documentation for composer can be foud <a href=\"https://getcomposer.org/download/\">here</a>";
        die;
    }

    header("Location: step1.php");
    exit;
}
?>
