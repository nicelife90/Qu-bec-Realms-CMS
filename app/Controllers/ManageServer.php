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
 * User: Yanick Lafontaine
 * Date: 2018-03-04
 * Time: 14:04
 */

namespace ThreenityCMS\Controllers;


class ManageServer
{

    /**
     * Validate if server directory exist
     *
     * @return bool
     */
    public static function valiateServerInstall()
    {
        if (file_exists('/usr/local/WoWServer')) {
            return true;
        } else {
            return false;
        }
    }

}