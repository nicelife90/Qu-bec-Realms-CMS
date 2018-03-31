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
use ThreenityCMS\Helpers\Security;

/**
 * Validate access to the current page
 */
Security::validateAccess(true);


/**
 * Redirect to dashboard if user is logged in.
 */
Login::redirectRegister();

?>