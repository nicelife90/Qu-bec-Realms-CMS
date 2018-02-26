<?php

function step_1()
{
    global $db;

    if (!empty($_POST['save1'])) {
        $pthost = $_POST['pthost'];
        $mshost = $_POST['mshost'];

        $msuser = $_POST['msuser'];
        $mspass = $_POST['mspass'];

        $cmsdb = $_POST['cmsdb'];
        $accdb = $_POST['accdb'];

        $connect = new mysqli($mshost, $msuser, $mspass);

        $this->connect = "";
        $this->con1 = "";
        $this->con2 = "";

        if (!$connect) {
            $this->connect = '
          <div class="mc">
            <div style="padding:8px;">
              <b>Warning:</b> MySQL Connection Failed. Please go back to <b><a href="./?page=install">Step 1</a></b>.
            </div>
          </div>
          ';
        } else {
            if (!$connect->select_db($cmsdb)) {
                $this->con1 = '
            <div class="mc">
              <div style="padding:8px;">
                <b>Warning:</b> Invalid CMS Database. Please go back to <b><a href="./?page=install">Step 1</a></b>.
              </div>
            </div>
            ';
            } else {
                if (!$connect->select_db($accdb)) {
                    $this->con2 = '
              <div class="mc">
                <div style="padding:8px;">
                  <b>Warning:</b> Invalid Account Database. Please go back to <b><a href="./?page=install">Step 1</a></b>.
                </div>
              </div>
              ';
                } else {
                    $this->host1 = $pthost;
                    $this->host2 = $mshost;
                    $this->msuser = $msuser;
                    $this->mspass = $mspass;
                    $this->db1 = $cmsdb;
                    $this->db2 = $accdb;
                }
            }
        }
    }
}

function step_2()
{
    global $db;

    if (isset($_POST['save2'])) {
        $pthost = $_POST['pthost'];
        $mshost = $_POST['mshost'];

        $msuser = $_POST['msuser'];
        $mspass = $_POST['mspass'];

        $cmsdb = $_POST['cmsdb'];
        $accdb = $_POST['accdb'];

        $this->host1 = $pthost;
        $this->host2 = $mshost;
        $this->msuser = $msuser;
        $this->mspass = $mspass;
        $this->db1 = $cmsdb;
        $this->db2 = $accdb;

        $global_title = $_POST['global_title'];
        $email_act = $_POST['email_act'];
        $login = $_POST['login'];
        $cright = $_POST['cright'];
        $realm = $_POST['realm'];
        $semail = $_POST['semail'];
        $domain = $_POST['domain'];
        $stitle = $_POST['stitle'];
        $expansion = $_POST['expansion'];

        $connect = new mysqli($this->host2, $this->msuser, $this->mspass);

        $connect->query("INSERT INTO $cmsdb.global (global_title, email_activation, login, copyright, realmlist, server_email, domain, server_title, expansion) VALUES ('$global_title', '$email_act', '$login', '$cright', '$realm', '$semail', '$domain', '$stitle', '$expansion')");
    }
}


function step_3()
{
    global $db;

    if (isset($_POST['save3'])) {
        $pthost = $_POST['pthost'];
        $mshost = $_POST['mshost'];

        $msuser = $_POST['msuser'];
        $mspass = $_POST['mspass'];

        $cmsdb = $_POST['cmsdb'];
        $accdb = $_POST['accdb'];

        $soaphost = $_POST['soaphost'];
        $soapuser = $_POST['soapuser'];
        $soappass = $_POST['soappass'];

        $pemail = $_POST['pemail'];
        $pcur = $_POST['pcur'];

        $rname = $_POST['rname'];
        $rtype = $_POST['rtype'];
        $rcdb = $_POST['rcdb'];
        $rport = $_POST['rport'];
        $soapport = $_POST['soapport'];

        $connect = new mysqli($mshost, $msuser, $mspass);

        //
        $config_file = "./core/config/config.php";
        $copen = fopen($config_file, 'w');

        $config = '<?php
if(!defined(\'ACMS\')){ header("Location: ../../"); }

//- Site Settings
  $debug = 0; #- Debug Mode Enabled? (0 = No | 1 = Yes)

//- Database Connection Info
  $port_host = "' . $pthost . '"; #- Domain without http:// or IP Address
  $db_host = "' . $mshost . '"; #- Database Host
  $db_user = "' . $msuser . '"; #- Database User
  $db_pass = "' . $mspass . '"; #- Database Pass
  $db_data = "' . $cmsdb . '"; #- Database DB
  $db_acc = "' . $accdb . '"; #- Account Database
  
//- Paypal Settings |:| Do Not Edit
  $palurl = array(
  "1" => "www.paypal.com",
  "2" => "www.sandbox.paypal.com",
  );
  
  $palcur = array(
  "1" => "USD",
  "2" => "EURO",
  "3" => "Other Currency Here", // Other Currency - https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes
  );
  
//- Paypal Manual Edit For Security
  $palmail = "' . $pemail . '";
  $palurl = $palurl[1]; // 1 = Paypal, 2 = SandBox
  $palcur = $palcur[' . $pcur . ']; // 1 = USD, 2 = EURO, 3 = Other
  
//- SOAP/Telnet Settings - Manual Edit
  $soap_host = "' . $soaphost . '"; #- World Server Host
  $soap_user = "' . $soapuser . '"; #- Account Username (Access = 4)
  $soap_pass = "' . $soappass . '"; #- Account Password (Access = 4)
?>';

        fwrite($copen, $config);
        fclose($copen);
        //
        $sql13 = $connect->query("UPDATE $accdb.account SET rank='0', isactive='1'");

        $sqli = $connect->query("SELECT id, username, staff_id FROM $accdb.account WHERE username='$soapuser'");

        $sqlie = $connect->prepare("SELECT id, username, staff_id FROM $accdb.account WHERE username='$soapuser'");
        $sqlie->execute();
        $sqlie->store_result();
        $numi = $sqlie->num_rows();
        $get = $sqli->fetch_assoc();
        $id = $get['id'];
        $sid = $get['staff_id'];

        if ($numi == 1) {
            $sid = rand(10000, 90000);
            $this->sid = $sid;

            $sql = $connect->query("INSERT INTO $accdb.account_access (id, gmlevel, RealmID) VALUES ('$id', '4', '-1') ");
            $sql12 = $connect->query("UPDATE $accdb.account SET rank='2', staff_id='$sid' WHERE id='$id'");
        } else {
            $sid = rand(10000, 90000);
            $this->sid = $sid;
            $sha1 = encrypt($soapuser, $soappass);

            $sql2 = $connect->query("INSERT INTO $accdb.account (username, sha_pass_hash, rank, staff_id, isactive) VALUES ('$soapuser', '$sha1', '2', '$sid', '1')");
            $sqll = $connect->query("SELECT id, username FROM $accdb.account WHERE username='$soapuser'");
            $getl = $sqll->fetch_assoc();
            $id1 = $getl['id'];

            $sql1 = $connect->query("INSERT INTO $accdb.account_access (id, gmlevel, RealmID) VALUES ('$id1', '4', '-1') ");
        }

        $rsql = $connect->query("INSERT INTO $cmsdb.realms (rname, type, oid, char_db, port, soap_port) VALUES ('$rname', '$rtype', '1', '$rcdb', '$rport', '$soapport')");
    }


}


$step_3 = array(
    "staff_id" => $step_3->sid,
);



function tables()
{
    global $db;

    $connect = new mysqli($this->host2, $this->msuser, $this->mspass);
    $accdb = $this->db2;

    // Add in our columns we need for the CMS to the account table
    $connect->query("ALTER TABLE $accdb.account ADD COLUMN rank INT(32)");
    $connect->query("ALTER TABLE $accdb.account ADD COLUMN staff_id INT(32)");
    $connect->query("ALTER TABLE $accdb.account ADD COLUMN vp VARCHAR(32)");
    $connect->query("ALTER TABLE $accdb.account ADD COLUMN dp VARCHAR(32)");
    $connect->query("ALTER TABLE $accdb.account ADD COLUMN isactive INT(32)");
    $connect->query("ALTER TABLE $accdb.account ADD COLUMN activation VARCHAR(255)");

    $connect->select_db($this->db1);

    // Create table for the ACP Styles
    $connect->query("CREATE TABLE `acp_styles` (`id` int(32) NOT NULL auto_increment, `path` varchar(64) default NULL, `install` int(32) default NULL, `active` int(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");
    $connect->query("INSERT INTO `acp_styles` VALUES (1, 'v3-default', 1, 1)");

    // Create table for the cart
    $connect->query("CREATE TABLE `cart` (`id` int(32) NOT NULL auto_increment, `realm` int(32) default NULL, `account` varchar(84) default NULL, `character` varchar(84) default NULL, `item` int(32) default NULL, `parent` int(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");

    // Create clog table
    $connect->query("CREATE TABLE `clog` (`id` int(32) NOT NULL auto_increment, `title` varchar(64) default NULL, `author` varchar(64) default NULL, `body` longtext, `date` varchar(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");
    $connect->query("INSERT INTO `clog` VALUES (1, 'Test', 'Azer', 'Test Post', 'November 30, 2012')");

    // Create global table to hold global settings
    $connect->query("CREATE TABLE `global` (`global_title` varchar(64) NOT NULL default '', `email_activation` int(32) default '0', `login` int(32) default NULL, `copyright` varchar(64) default NULL, `realmlist` varchar(64) default NULL, `server_email` varchar(64) default NULL, `domain` varchar(64) default NULL, `server_title` varchar(64) default NULL, `expansion` int(32) default NULL, PRIMARY KEY  (`global_title`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci'");

    // Create login_log table to log logins
    $connect->query("CREATE TABLE `login_log` (`id` int(32) NOT NULL auto_increment, `username` varchar(64) default NULL, `ip` varchar(64) default NULL, `date` varchar(64) default NULL, `status` varchar(32) default NULL, `lty` varchar(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");

    //Create table to hold Private Messages
    $connect->query("CREATE TABLE `messages` (`id` int(32) NOT NULL auto_increment, `title` varchar(84) default NULL, `body` longtext, `sender` varchar(64) default NULL, `user` varchar(64) default NULL, `date` varchar(64) default NULL, `unread` int(32) default '1', `inbox_copy` int(32) default '1', `outbox_copy` int(32) default '1', PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");

    // Create table to store the news posts, while we're at it, let's steal their first post in the name of Azer CMS! >:)
    $connect->query("CREATE TABLE `news` (`id` int(32) NOT NULL auto_increment, `title` varchar(64) default NULL, `author` varchar(64) default NULL, `body` longtext, `date` varchar(32) default NULL, `avatar` varchar(150) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");
    $connect->query("INSERT INTO `news` VALUES (1, 'Welcome to Azer CMS V3.0', 'Azer', 'First Post.', 'November 30, 2012', 'a3')");

    // Create the realms table, so that way that the user can store their realm data for the CMS to access
    $connect->query("CREATE TABLE `realms` (`id` int(32) NOT NULL auto_increment, `rname` varchar(84) default NULL, `type` varchar(84) default NULL, `oid` int(32) default NULL, `char_db` varchar(84) default NULL, `port` int(32) default NULL, `soap_port` int(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");

    // Create the table for the shoutbox to store everyone's loud shouting
    $connect->query("CREATE TABLE `shouts` (`id` int(32) NOT NULL auto_increment, `author` varchar(64) default NULL, `body` longtext, `date` varchar(64) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");

    // Create the table to hold our store categories, also put in the basic categories
    $connect->query("CREATE TABLE `store_categories` (`id` int(32) NOT NULL auto_increment, `cname` varchar(64) default NULL, `oid` int(32) default NULL, `realm` int(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=2");
    $connect->query("INSERT INTO `store_categories` VALUES (1, 'Vote Items', 1, 1)");
    $connect->query("INSERT INTO `store_categories` VALUES (2, 'V.I.P Items', 2, 1)");

    // Create the table to hold the items that are being sold in the store. Put some Hearthstones in as example items. (nothing better than home sweet home, huh?)
    $connect->query("CREATE TABLE `store_items` (`sid` int(32) NOT NULL auto_increment, `name` varchar(64) default NULL, `display` varchar(64) default NULL, `item` varchar(128) default NULL, `ctype` int(32) default NULL, `cost` varchar(32) default NULL, `amount` int(32) default NULL, `parent_category` int(32) default NULL, PRIMARY KEY  (`sid`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=2");
    $connect->query("INSERT INTO `store_items` VALUES (1, 'Hearthstone', '6948', '6948', 1, '0', 1, 1)");
    $connect->query("INSERT INTO `store_items` VALUES (2, 'Hearthstone', '6948', '6948', 2, '0', 1, 2)");

    // Create the table to log store purchases
    $connect->query("CREATE TABLE `store_log` (`id` int(32) NOT NULL auto_increment, `body` longtext, `eid` varchar(64) default NULL, `acc_id` int(32) default NULL, `char_id` int(32) default NULL, `date` varchar(84) default NULL, `trs_id` varchar(255) default NULL, `prc_items` varchar(255) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");

    // Create the styles table, so users can choose which style their instance of the CMS will use. Also add the default style and activate it. (you do want to be able to use the CMS, right?)
    $connect->query("CREATE TABLE `styles` (`id` int(32) NOT NULL auto_increment, `path` varchar(64) default NULL, `install` int(32) default NULL, `active` int(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");
    $connect->query("INSERT INTO `styles` VALUES (1, 'v3-default', 1, 1)");

    // Create log table for donations (lucky you)
    $connect->query("CREATE TABLE `vip_log` (`id` int(32) NOT NULL auto_increment, `body` longtext, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");

    // Create log table for voting (good luck)
    $connect->query("CREATE TABLE `vote_logs` (`id` int(32) NOT NULL auto_increment, `user` varchar(84) default NULL, `site_name` varchar(64) default NULL, `site_id` int(32) default NULL, `site_cost` varchar(32) default NULL, `date` varchar(84) default NULL, `timer` varchar(64) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");

    // Create the table needed to hold which sites are used for voting, and how many points they give out per vote
    $connect->query("CREATE TABLE `vote_sites` (`id` int(32) NOT NULL auto_increment, `site_name` varchar(64) default NULL, `site_url` varchar(84) default NULL, `site_img` varchar(255) default NULL, `site_cost` varchar(32) default NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE='utf8mb4_unicode_ci' AUTO_INCREMENT=1");

    return "";

}


?>