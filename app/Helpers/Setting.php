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
 * Date: 2017-11-08
 * Time: 11:38
 */

namespace ThreenityCMS\Helpers;

use ThreenityCMS\Models\Threenity\SettingModel;

class Setting
{
    /**
     * Return Setting Value
     *
     * @return string
     */
    public static function get($setting_name)
    {
        return SettingModel::getValueByName($setting_name);
    }
}