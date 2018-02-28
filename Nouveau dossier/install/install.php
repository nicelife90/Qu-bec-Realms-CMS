<?php

require $_SERVER['DOCUMENT_ROOT'] . '/app/Helpers/Loader.php';

use WoWCMS\Helpers\Request;

class install
{

    public static function now()
    {

        /**
         * Form data
         */
        $pthost = Request::get('pthost');
        $mshost = Request::get('mshost');
        $msuser = Request::get('msuser');
        $mspass = Request::get('mspass');
        $cmsdb = Request::get('cmsdb');
        $accdb = Request::get('accdb');
        $global_title = Request::get('global_title');
        $email_act = Request::get('email_act');
        $login = Request::get('login');
        $cright = Request::get('cright');
        $realm = Request::get('realm');
        $semail = Request::get('semail');
        $domain = Request::get('domain');
        $stitle = Request::get('stitle');
        $expansion = Request::get('expansion');
        $soaphost = Request::get('soaphost');
        $soapuser = Request::get('soapuser');
        $soappass = Request::get('soappass');
        $pemail = Request::get('pemail');
        $pcur = Request::get('pcur');
        $rname = Request::get('rname');
        $rtype = Request::get('rtype');
        $rcdb = Request::get('rcdb');
        $rport = Request::get('rport');
        $soapport = Request::get('soapport');

        /**
         * Create config file
         */
        $config_file = $_SERVER['DOCUMENT_ROOT'] . '/core/config/config.php';
        $copen = fopen($config_file, 'w');
        $config = '<?php
if(!defined(\'ACMS\')){ header("Location: ../../"); }

//Site Settings
$debug = 0;

//Database Connection Info
$port_host = "' . $pthost . '"; 
$db_host = "' . $mshost . '";
$db_user = "' . $msuser . '";
$db_pass = "' . $mspass . '";
$db_data = "' . $cmsdb . '";
$db_acc = "' . $accdb . '";

//Paypal Settings
$palurl = array(
    "1" => "www.paypal.com",
    "2" => "www.sandbox.paypal.com",
);

$palcur = array(
    "1" => "USD",
    "2" => "EURO",
    "3" => "CAD",
);

//Paypal Manual Edit For Security
$palmail = "' . $pemail . '";
$palurl = $palurl[1];
$palcur = $palcur[' . $pcur . '];

//SOAP/Telnet Settings
$soap_host = "' . $soaphost . '"; 
$soap_user = "' . $soapuser . '"; 
$soap_pass = "' . $soappass . '";
';

        fwrite($copen, $config);
        fclose($copen);


        $sqli = "SELECT id, username, staff_id FROM $accdb.account WHERE username='$soapuser'";
        $sqlie = "SELECT id, username, staff_id FROM $accdb.account WHERE username='$soapuser'";
        $sid = rand(10000, 90000);

        $sql = "INSERT INTO $accdb.account_access (id, gmlevel, RealmID) VALUES ('$id', '4', '-1') ";
        $sql12 = "UPDATE $accdb.account SET rank='2', staff_id='$sid' WHERE id='$id'";


        $query = [

            // Add in our columns we need for the CMS to the account table
            "ALTER TABLE $accdb.account ADD COLUMN rank INT(32)",
            "ALTER TABLE $accdb.account ADD COLUMN staff_id INT(32)",
            "ALTER TABLE $accdb.account ADD COLUMN vp VARCHAR(32)",
            "ALTER TABLE $accdb.account ADD COLUMN dp VARCHAR(32)",
            "ALTER TABLE $accdb.account ADD COLUMN isactive INT(32)",
            "ALTER TABLE $accdb.account ADD COLUMN activation VARCHAR(255)",

            // Create table for the ACP Styles
            "CREATE TABLE `acp_styles` (`id` INT(32) NOT NULL AUTO_INCREMENT, `path` VARCHAR(64) DEFAULT NULL, `install` INT(32) DEFAULT NULL, `active` INT(32) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",
            "INSERT INTO `acp_styles` VALUES (1, 'v3-default', 1, 1)",

            // Create table for the cart
            "CREATE TABLE `cart` (`id` INT(32) NOT NULL AUTO_INCREMENT, `realm` INT(32) DEFAULT NULL, `account` VARCHAR(84) DEFAULT NULL, `character` VARCHAR(84) DEFAULT NULL, `item` INT(32) DEFAULT NULL, `parent` INT(32) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create clog table
            "CREATE TABLE `clog` (`id` INT(32) NOT NULL AUTO_INCREMENT, `title` VARCHAR(64) DEFAULT NULL, `author` VARCHAR(64) DEFAULT NULL, `body` LONGTEXT, `date` VARCHAR(32) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create global table to hold global settings
            "CREATE TABLE `global` (`global_title` VARCHAR(64) NOT NULL DEFAULT '', `email_activation` INT(32) DEFAULT '0', `login` INT(32) DEFAULT NULL, `copyright` VARCHAR(64) DEFAULT NULL, `realmlist` VARCHAR(64) DEFAULT NULL, `server_email` VARCHAR(64) DEFAULT NULL, `domain` VARCHAR(64) DEFAULT NULL, `server_title` VARCHAR(64) DEFAULT NULL, `expansion` INT(32) DEFAULT NULL, PRIMARY KEY  (`global_title`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci'",

            // Create login_log table to log logins
            "CREATE TABLE `login_log` (`id` INT(32) NOT NULL AUTO_INCREMENT, `username` VARCHAR(64) DEFAULT NULL, `ip` VARCHAR(64) DEFAULT NULL, `date` VARCHAR(64) DEFAULT NULL, `status` VARCHAR(32) DEFAULT NULL, `lty` VARCHAR(32) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            //Create table to hold Private Messages
            "CREATE TABLE `messages` (`id` INT(32) NOT NULL AUTO_INCREMENT, `title` VARCHAR(84) DEFAULT NULL, `body` LONGTEXT, `sender` VARCHAR(64) DEFAULT NULL, `user` VARCHAR(64) DEFAULT NULL, `date` VARCHAR(64) DEFAULT NULL, `unread` INT(32) DEFAULT '1', `inbox_copy` INT(32) DEFAULT '1', `outbox_copy` INT(32) DEFAULT '1', PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create table to store the news posts, while we're at it, let's steal their first post in the name of WoW CMS! >:)
            "CREATE TABLE `news` (`id` INT(32) NOT NULL AUTO_INCREMENT, `title` VARCHAR(64) DEFAULT NULL, `author` VARCHAR(64) DEFAULT NULL, `body` LONGTEXT, `date` VARCHAR(32) DEFAULT NULL, `avatar` VARCHAR(150) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create the realms table, so that way that the user can store their realm data for the CMS to access
            "CREATE TABLE `realms` (`id` INT(32) NOT NULL AUTO_INCREMENT, `rname` VARCHAR(84) DEFAULT NULL, `type` VARCHAR(84) DEFAULT NULL, `oid` INT(32) DEFAULT NULL, `char_db` VARCHAR(84) DEFAULT NULL, `port` INT(32) DEFAULT NULL, `soap_port` INT(32) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create the table for the shoutbox to store everyone's loud shouting
            "CREATE TABLE `shouts` (`id` INT(32) NOT NULL AUTO_INCREMENT, `author` VARCHAR(64) DEFAULT NULL, `body` LONGTEXT, `date` VARCHAR(64) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create the table to hold our store categories, also put in the basic categories
            "CREATE TABLE `store_categories` (`id` INT(32) NOT NULL AUTO_INCREMENT, `cname` VARCHAR(64) DEFAULT NULL, `oid` INT(32) DEFAULT NULL, `realm` INT(32) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=2",
            "INSERT INTO `store_categories` VALUES (1, 'Vote Items', 1, 1)",
            "INSERT INTO `store_categories` VALUES (2, 'V.I.P Items', 2, 1)",

            // Create the table to hold the items that are being sold in the store. Put some Hearthstones in as example items. (nothing better than home sweet home, huh?)
            "CREATE TABLE `store_items` (`sid` INT(32) NOT NULL AUTO_INCREMENT, `name` VARCHAR(64) DEFAULT NULL, `display` VARCHAR(64) DEFAULT NULL, `item` VARCHAR(128) DEFAULT NULL, `ctype` INT(32) DEFAULT NULL, `cost` VARCHAR(32) DEFAULT NULL, `amount` INT(32) DEFAULT NULL, `parent_category` INT(32) DEFAULT NULL, PRIMARY KEY  (`sid`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=2",
            "INSERT INTO `store_items` VALUES (1, 'Hearthstone', '6948', '6948', 1, '0', 1, 1)",
            "INSERT INTO `store_items` VALUES (2, 'Hearthstone', '6948', '6948', 2, '0', 1, 2)",

            // Create the table to log store purchases
            "CREATE TABLE `store_log` (`id` INT(32) NOT NULL AUTO_INCREMENT, `body` LONGTEXT, `eid` VARCHAR(64) DEFAULT NULL, `acc_id` INT(32) DEFAULT NULL, `char_id` INT(32) DEFAULT NULL, `date` VARCHAR(84) DEFAULT NULL, `trs_id` VARCHAR(255) DEFAULT NULL, `prc_items` VARCHAR(255) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create the styles table, so users can choose which style their instance of the CMS will use. Also add the default style and activate it. (you do want to be able to use the CMS, right?)
            "CREATE TABLE `styles` (`id` INT(32) NOT NULL AUTO_INCREMENT, `path` VARCHAR(64) DEFAULT NULL, `install` INT(32) DEFAULT NULL, `active` INT(32) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",
            "INSERT INTO `styles` VALUES (1, 'v3-default', 1, 1)",

            // Create log table for donations (lucky you)
            "CREATE TABLE `vip_log` (`id` INT(32) NOT NULL AUTO_INCREMENT, `body` LONGTEXT, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create log table for voting (good luck)
            "CREATE TABLE `vote_logs` (`id` INT(32) NOT NULL AUTO_INCREMENT, `user` VARCHAR(84) DEFAULT NULL, `site_name` VARCHAR(64) DEFAULT NULL, `site_id` INT(32) DEFAULT NULL, `site_cost` VARCHAR(32) DEFAULT NULL, `date` VARCHAR(84) DEFAULT NULL, `timer` VARCHAR(64) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create the table needed to hold which sites are used for voting, and how many points they give out per vote
            "CREATE TABLE `vote_sites` (`id` INT(32) NOT NULL AUTO_INCREMENT, `site_name` VARCHAR(64) DEFAULT NULL, `site_url` VARCHAR(84) DEFAULT NULL, `site_img` VARCHAR(255) DEFAULT NULL, `site_cost` VARCHAR(32) DEFAULT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",
        ];

        $query2 = [

            "INSERT INTO $cmsdb.global (global_title, email_activation, login, copyright, realmlist, server_email, domain, server_title, expansion) VALUES ('$global_title', '$email_act', '$login', '$cright', '$realm', '$semail', '$domain', '$stitle', '$expansion')",
            "INSERT INTO $cmsdb.realms (rname, type, oid, char_db, port, soap_port) VALUES ('$rname', '$rtype', '1', '$rcdb', '$rport', '$soapport')",
            "UPDATE $accdb.account SET rank='0', isactive='1'",
        ];
    }
}
