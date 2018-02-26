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
            "CREATE TABLE `acp_styles` (`id` int(32) NOT NULL auto_increment, `path` varchar(64) default NULL, `install` int(32) default NULL, `active` int(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",
            "INSERT INTO `acp_styles` VALUES (1, 'v3-default', 1, 1)",

            // Create table for the cart
            "CREATE TABLE `cart` (`id` int(32) NOT NULL auto_increment, `realm` int(32) default NULL, `account` varchar(84) default NULL, `character` varchar(84) default NULL, `item` int(32) default NULL, `parent` int(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create clog table
            "CREATE TABLE `clog` (`id` int(32) NOT NULL auto_increment, `title` varchar(64) default NULL, `author` varchar(64) default NULL, `body` longtext, `date` varchar(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create global table to hold global settings
            "CREATE TABLE `global` (`global_title` varchar(64) NOT NULL default '', `email_activation` int(32) default '0', `login` int(32) default NULL, `copyright` varchar(64) default NULL, `realmlist` varchar(64) default NULL, `server_email` varchar(64) default NULL, `domain` varchar(64) default NULL, `server_title` varchar(64) default NULL, `expansion` int(32) default NULL, PRIMARY KEY  (`global_title`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci'",

            // Create login_log table to log logins
            "CREATE TABLE `login_log` (`id` int(32) NOT NULL auto_increment, `username` varchar(64) default NULL, `ip` varchar(64) default NULL, `date` varchar(64) default NULL, `status` varchar(32) default NULL, `lty` varchar(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            //Create table to hold Private Messages
            "CREATE TABLE `messages` (`id` int(32) NOT NULL auto_increment, `title` varchar(84) default NULL, `body` longtext, `sender` varchar(64) default NULL, `user` varchar(64) default NULL, `date` varchar(64) default NULL, `unread` int(32) default '1', `inbox_copy` int(32) default '1', `outbox_copy` int(32) default '1', PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create table to store the news posts, while we're at it, let's steal their first post in the name of Azer CMS! >:)
            "CREATE TABLE `news` (`id` int(32) NOT NULL auto_increment, `title` varchar(64) default NULL, `author` varchar(64) default NULL, `body` longtext, `date` varchar(32) default NULL, `avatar` varchar(150) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create the realms table, so that way that the user can store their realm data for the CMS to access
            "CREATE TABLE `realms` (`id` int(32) NOT NULL auto_increment, `rname` varchar(84) default NULL, `type` varchar(84) default NULL, `oid` int(32) default NULL, `char_db` varchar(84) default NULL, `port` int(32) default NULL, `soap_port` int(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create the table for the shoutbox to store everyone's loud shouting
            "CREATE TABLE `shouts` (`id` int(32) NOT NULL auto_increment, `author` varchar(64) default NULL, `body` longtext, `date` varchar(64) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create the table to hold our store categories, also put in the basic categories
            "CREATE TABLE `store_categories` (`id` int(32) NOT NULL auto_increment, `cname` varchar(64) default NULL, `oid` int(32) default NULL, `realm` int(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=2",
            "INSERT INTO `store_categories` VALUES (1, 'Vote Items', 1, 1)",
            "INSERT INTO `store_categories` VALUES (2, 'V.I.P Items', 2, 1)",

            // Create the table to hold the items that are being sold in the store. Put some Hearthstones in as example items. (nothing better than home sweet home, huh?)
            "CREATE TABLE `store_items` (`sid` int(32) NOT NULL auto_increment, `name` varchar(64) default NULL, `display` varchar(64) default NULL, `item` varchar(128) default NULL, `ctype` int(32) default NULL, `cost` varchar(32) default NULL, `amount` int(32) default NULL, `parent_category` int(32) default NULL, PRIMARY KEY  (`sid`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=2",
            "INSERT INTO `store_items` VALUES (1, 'Hearthstone', '6948', '6948', 1, '0', 1, 1)",
            "INSERT INTO `store_items` VALUES (2, 'Hearthstone', '6948', '6948', 2, '0', 1, 2)",

            // Create the table to log store purchases
            "CREATE TABLE `store_log` (`id` int(32) NOT NULL auto_increment, `body` longtext, `eid` varchar(64) default NULL, `acc_id` int(32) default NULL, `char_id` int(32) default NULL, `date` varchar(84) default NULL, `trs_id` varchar(255) default NULL, `prc_items` varchar(255) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create the styles table, so users can choose which style their instance of the CMS will use. Also add the default style and activate it. (you do want to be able to use the CMS, right?)
            "CREATE TABLE `styles` (`id` int(32) NOT NULL auto_increment, `path` varchar(64) default NULL, `install` int(32) default NULL, `active` int(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",
            "INSERT INTO `styles` VALUES (1, 'v3-default', 1, 1)",

            // Create log table for donations (lucky you)
            "CREATE TABLE `vip_log` (`id` int(32) NOT NULL auto_increment, `body` longtext, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create log table for voting (good luck)
            "CREATE TABLE `vote_logs` (`id` int(32) NOT NULL auto_increment, `user` varchar(84) default NULL, `site_name` varchar(64) default NULL, `site_id` int(32) default NULL, `site_cost` varchar(32) default NULL, `date` varchar(84) default NULL, `timer` varchar(64) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",

            // Create the table needed to hold which sites are used for voting, and how many points they give out per vote
            "CREATE TABLE `vote_sites` (`id` int(32) NOT NULL auto_increment, `site_name` varchar(64) default NULL, `site_url` varchar(84) default NULL, `site_img` varchar(255) default NULL, `site_cost` varchar(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1",
        ];

        $query2 = [

            "INSERT INTO $cmsdb.global (global_title, email_activation, login, copyright, realmlist, server_email, domain, server_title, expansion) VALUES ('$global_title', '$email_act', '$login', '$cright', '$realm', '$semail', '$domain', '$stitle', '$expansion')",
            "INSERT INTO $cmsdb.realms (rname, type, oid, char_db, port, soap_port) VALUES ('$rname', '$rtype', '1', '$rcdb', '$rport', '$soapport')",
            "UPDATE $accdb.account SET rank='0', isactive='1'",
        ];
    }
}
