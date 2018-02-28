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
 * Date: 2017-11-22
 * Time: 16:50
 */

namespace ThreenityCMS\Helpers;

use Milon\Barcode\DNS1D;

class Barcode
{

    /**
     * Get barcode HTML
     *
     * @param $barcode - Numeric barcode
     */
    public static function getHTML($barcode, $weight = 2, $height = 30)
    {
        $d = new DNS1D();
        $d->setStorPath(__DIR__ . "/cache/");
        if (!empty($barcode)) {
            echo $d->getBarcodeHTML($barcode, "C128", $weight, $height);
        }
    }

    /**
     * Get barcode PNG
     *
     * @param $barcode - Numeric barcode
     */
    public static function getPNG($barcode, $weight = 2, $height = 30)
    {
        $d = new DNS1D();
        $d->setStorPath(__DIR__ . "/cache/");
        if (!empty($barcode)) {
            echo $d->getBarcodePNG($barcode, "C128", $weight, $height);
        }
    }

    /**
     * Get base 64 barcode PNG
     *
     * @param $barcode - Numeric barcode
     */
    public static function getBase64PNG($barcode, $weight = 2, $height = 30)
    {
        $d = new DNS1D();
        $d->setStorPath(__DIR__ . "/cache/");

        if (!empty($barcode)) {
            echo "data:image/png;base64," . $d->getBarcodePNG($barcode, "C128", $weight, $height);
        }
    }
}