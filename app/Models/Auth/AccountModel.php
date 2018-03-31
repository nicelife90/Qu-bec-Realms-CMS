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
 * Date: 2017-10-13
 * Time: 22:06
 */

namespace ThreenityCMS\Models\Auth;

use ThreenityCMS\Helpers\Database;
use ThreenityCMS\Helpers\Password;
use PDO;

/**
 * Class AccountModel
 *
 * @package Threenity\Models
 */
class AccountModel
{

    /**
     * Prepare password for Trinity Core
     *
     * @param $username
     * @param $password
     * @return string
     */
    private static function encrypt($username, $password)
    {
        $password = sha1(strtoupper($username) . ":" . strtoupper($password));
        $password = strtoupper($password);
        return $password;
    }


    /**
     * Create AccountModel
     *
     * @param $data - AccountModel Data
     */
    public static function create($data)
    {
        $db = Database::getAuth();


        $query = "INSERT
                    INTO
                       account(
                            username,
                            sha_pass_hash,
                            expansion
                        )
                    VALUES(
                        :username,
                        :sha_pass_hash,
                        :expansion
                       
                    )";

        $sth = $db->prepare($query);

        $sth->execute([
            "username" => strtoupper($data['username']),
            "sha_pass_hash" => self::encrypt($data['username'], $data['password']),
            "expansion" => $data['expansion']
        ]);
    }
}


