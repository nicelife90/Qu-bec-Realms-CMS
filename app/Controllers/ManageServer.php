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

use ThreenityCMS\Helpers\Path;

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


    public static function installTrinityCore()
    {

        chmod(Path::bash() . '/install.sh', 0750);
        ob_implicit_flush(true);
        ob_end_flush();
        $cmd = Path::bash() . '/install.sh';

        $descriptorspec = array(
            0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
            2 => array("pipe", "w")    // stderr is a pipe that the child will write to
        );

        flush();

        $process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());

        echo "<pre>";
        if (is_resource($process)) {
            while ($s = fgets($pipes[1])) {
                print $s;
                flush();
            }
            proc_close($process);
        }
        echo "</pre>";
    }

}