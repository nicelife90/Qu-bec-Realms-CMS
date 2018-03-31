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
 * Date: 2017-10-16
 * Time: 11:12
 */

namespace ThreenityCMS\Controllers;

use ThreenityCMS\Helpers\Database;
use ThreenityCMS\Models\Auth;
use ThreenityCMS\Helpers\Request;
use Exception;

class Register
{

    public static function register()
    {

        /**
         * Form value
         */
        $username = Request::post('username');
        $password = Request::post('password');
        $password2 = Request::post('password2');

        if (empty($username) || empty($password) || empty($password2)) {
            throw new Exception("All fields are requireds.");
        }

        if ($password != $password2) {
            throw new Exception("Password must be identical.");
        }

        if (!Database::fieldIsUniqueAuth('account', 'username', $username)){
            throw new Exception("This username is already taken.");
        }

        Auth\AccountModel::create([
            "username" => $username,
            "password" => $password,
            "expansion" => 2
        ]);

    }
}