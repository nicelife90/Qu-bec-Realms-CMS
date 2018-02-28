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

namespace ThreenityCMS\Models\Threenity;

use ThreenityCMS\Helpers\Database;
use Exception;
use PDO;

/**
 * Class settingModel
 *
 * @package Threenity\Models\Threenity
 */
class SettingModel
{

    /**
     * Get setting value by name
     *
     * @param $name - Setting Name
     *
     * @return mixed
     */
    public static function getValueByName($name)
    {
        $db = Database::get();

        $data = $db->query("SELECT setting_value FROM ae_setting WHERE setting_name = '$name'")->fetchObject()->setting_value;

        return $data;
    }
}
