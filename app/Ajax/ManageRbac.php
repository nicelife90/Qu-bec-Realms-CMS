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
 * Date: 2017-10-17
 * Time: 14:59
 */

require $_SERVER['DOCUMENT_ROOT'] . '/app/Helpers/Loader.php';

use ThreenityCMS\Helpers\Request;
use ThreenityCMS\Helpers\Security;

try {

    $group_id = Request::post("group_id");
    $rbac_id = Request::post("rbac_id");
    $mode = Request::post("mode");
    $jwt = Request::post("jwt");

    Security::validateAccessAjax($jwt);

    if ($mode == "remove") {
        Security::removeAssignment($group_id, $rbac_id);
    } elseif ($mode == "add") {
        Security::addAssignment($group_id, $rbac_id);
    }

    $status = [
        "status" => 200,
        "msg" => "OK",
    ];

} catch (Exception $e) {

    $status = [
        "status" => 400,
        "msg" => $e->getMessage(),
    ];

}


header('Content-type: application/json');
echo json_encode($status);
