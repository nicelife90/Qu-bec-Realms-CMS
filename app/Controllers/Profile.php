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
use ThreenityCMS\Helpers\Request;
use ThreenityCMS\Helpers\Session;
use ThreenityCMS\Helpers\Upload;
use ThreenityCMS\Models\Threenity\AccountModel;
use Exception;

class Profile
{


    public static function update()
    {
        /**
         * Prepare password
         */
        $pwd = Request::post('pwd');
        $pwd_hash = Password::hash($pwd);

        /**
         * Prepare image
         */
        $img = Request::file('img');
        if (!empty($img['name'])) {

            $img_result = Upload::profile_image($img, $_SERVER["DOCUMENT_ROOT"] . '/dist/img/profiles/');
            if ($img_result["uploaded"]) {
                $img_path = $img_result["msg"];
            } else {
                throw new Exception("Une erreur s'est produit avec le traitement de votre photo : " . $img_result["msg"]);
            }
        }

        try {

            if (!empty($pwd)) {
                AccountModel::setPassword(Session::get('account_id'), $pwd_hash);
            }

            if (!empty($img['name'])) {
                AccountModel::setProfileImg(Session::get('account_id'), $img_path);
            }

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}