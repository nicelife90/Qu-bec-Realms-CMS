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


class Path
{
    /**
     * Return HTTPS or HTTP
     *
     * @return string
     */
    private static function getHttpProtocol()
    {
        return (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
            ? $protocol = 'https://' : $protocol = 'http://';
    }


    /**
     * Return full website URL.
     *
     * @return string
     */
    public static function root()
    {
        return self::getHttpProtocol() . $_SERVER['HTTP_HOST'];
    }

    /**
     * Return module folder URL.
     *
     * @return string
     */
    public static function module()
    {
        return self::getHttpProtocol() . $_SERVER['HTTP_HOST'] . "/views";
    }

    /**
     * Return css path
     *
     * @return string
     */
    public static function css()
    {
        return self::root() . "/dist/css";
    }

    /**
     * Return js path
     *
     * @return string
     */
    public static function js()
    {
        return self::root() . "/dist/js";
    }

    /**
     * Return components path
     *
     * @return string
     */
    public static function comp()
    {
        return self::root() . "/dist/components";
    }

    /**
     * Return images path
     *
     * @return string
     */
    public static function img()
    {
        return self::root() . "/dist/img";
    }


    /**
     * Return images path
     *
     * @return string
     */
    public static function bash()
    {
        return "/var/www/html/app/Bash";
    }


    /**
     * Return profile images path
     *
     * @return string
     */
    public static function profileImg()
    {
        return self::root() . "/dist/img/profiles";
    }

    /**
     * Return PDF path
     *
     * @return string
     */
    public static function pdf()
    {
        return self::root() . "/app/PDF";
    }
}