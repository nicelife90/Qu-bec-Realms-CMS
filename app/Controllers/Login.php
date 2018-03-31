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

use ThreenityCMS\Helpers\Password;
use ThreenityCMS\Helpers\Redirect;
use ThreenityCMS\Helpers\Request;
use ThreenityCMS\Helpers\Session;
use ThreenityCMS\Helpers\Utils;
use ThreenityCMS\Models\Threenity\AccountModel;
use ThreenityCMS\Models\Threenity\GroupModel;
use Exception;

class Login
{

    public static function login()
    {

        /**
         * Form value
         */
        $username = Request::post('username');
        $password = Request::post('password');

        if (empty($username) || empty($password)) {
            throw new Exception("You must enter a username and password.");
        }

        /**
         * AccountModel ID
         */
        $account_id = AccountModel::getIdByUsername($username);


        /**
         * Validate AccountModel
         */
        if (is_null($account_id)) {
            throw new Exception("This username is not valid.");
        }

        /**
         * Login attempt
         */
        $login_attempt = AccountModel::getLoginAttempt($account_id);
        if ($login_attempt >= 5) {
            throw new Exception("Your account has been suspended for security.");
        }


        /**
         * Validate password
         */
        $pwd_hash = AccountModel::getPassword($account_id);
        if (!Password::isValid($password, $pwd_hash)) {

            AccountModel::setLoginAttempt($account_id, $login_attempt + 1);
            $remaining = 5 - AccountModel::getLoginAttempt($account_id);
            if ($remaining == 0) {
                throw new Exception("Your account has been suspended for security.");
            } else {
                throw new Exception("Username or password incorrect. <br/>You have $remaining attempts before your account is suspended.");
            }
        }

        /**
         * Rehash password as needed
         */
        $rehash = Password::needsRehash($password, $pwd_hash);
        if ($rehash != false) {
            AccountModel::setPassword($account_id, $rehash);
        }

        /**
         * Check if account is deleted
         */
        $deleted = AccountModel::isDeleted($account_id);
        if ($deleted) {
            throw new Exception("This account is invalid.");
        }

        /**
         * Reset login attempt
         */
        AccountModel::setLoginAttempt($account_id, 0);

        /**
         * Set Session value
         */
        Session::set("account_id", $account_id);
        Session::set("account_group", AccountModel::getAccountGroup($account_id));

        /**
         * Update user account
         */
        AccountModel::setLastIp($account_id, Utils::getIP());
        AccountModel::setLastLoginDate($account_id);

        /**
         * Redirect to Dashboard
         */
        self::redirect();

    }

    /**
     * Redirect to dashboard
     */
    public static function redirect()
    {
        $account_group = Session::get("account_group");
        $module = GroupModel::getDashboardById($account_group);
        Redirect::module($module);
    }


    public static function redirectRegister()
    {

        Redirect::to('register.php');
    }

    /**
     * Logout current user.
     */
    public static function logout()
    {
        Session::kill();
        Redirect::to("index.php");
    }
}