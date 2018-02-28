<?php

define("ACMS", TRUE);

header('Content-Type: text/html; charset=utf-8');

/**
 * Install
 */
if (file_exists("./install") && !file_exists("./setup.done")) {
    header("Location: install/index.php");
    exit;
} /**
 * Load CMS
 */
else {
    $mtime = microtime();
    $mtime = explode(" ", $mtime);
    $mtime = $mtime[1] + $mtime[0];
    $starttime = $mtime;

    #- Includes Needed
    $includes = array(
        "./core/config/config.php",
        "./core/lib/sql.php",
        "./core/lib/global.php",
        "./core/inc/login.php",
        "./core/inc/sys.php",
        "./core/inc/functions.php",
        "./core/parser/template.php",
        "./core/parser/replace.php",
    );

    if (!empty($includes) AND is_array($includes)) {
        $error_inc = array();

        foreach ($includes as $nr => $include) {
            $inc = (!empty($include) ? include($include) : false);

            if ($include == "./core/config/config.php") {
                if ($debug == 0) {
                    $value = 0;
                } else {
                    $value = -1;
                }
                error_reporting($value);

                $connect = new mysqli($db_host, $db_user, $db_pass);

                if ($connect->connect_errno) {
                    if ($debug == 0) {
                        die("Mysql Connect Error: Oops, something went wrong. (Enable debug mode for an error list).");
                    } else {
                        die($connect->connect_error);
                    }
                }
            }

            if (!$inc) {
                $error_inc[] = $include;
            }
        }

        if (!empty($error_inc)) {
            $content = "One or more Core files are missing:<br /><table><tr><td><b>Path:</b></td></tr>";

            foreach ($error_inc as $nr_e => $error) {
                $content .= '<tr><td>' . $error . '</td></tr>';
            }

            $content .= '</table>';

            die($content);
        }
    }

    $sql = $db->query("SELECT id, path, install, active FROM $db_data.styles WHERE install='1' AND active='1' ORDER BY id DESC LIMIT 1");
    $get = $db->get($sql);

    $style = "./styles/" . $get['path'] . "/index.php";

    if ($get['path'] == FALSE) {
        die("No style selected.");
    }

    if (file_exists($style)) {
        if ($get['path'] != "global") {
            $file = acp(logged(file_get_contents($style)));
            echo $replace->parse($file, $data);
        } else {
            die("The global folder is a CMS file, please install a valid style.");
        }
    } else {
        die("The style @ " . $style . " doesn't exist or is missing the index file.");
    }

}
?>