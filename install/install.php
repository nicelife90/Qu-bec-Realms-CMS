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

session_start();
if (!isset($_SESSION["INSTALL"])) {
    echo "Unable to directly access the application installation folder!";
    die;
} else {


    if (isset($_POST["install"])) {

        /**
         * Error
         */
        $error = [];

        /**
         * Post Data
         */
        $_SESSION["f"] = $_POST;

        /**
         * MySQL
         */
        $mhost = $_POST["mhost"];
        $mport = $_POST["mport"];
        $muser = $_POST["muser"];
        $mpass = $_POST["mpass"];
        $mdb = $_POST["mdb"];

        /**
         * CMS
         */
        $fname = $_POST["fname"];
        $name = $_POST["name"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $email = $_POST["email"];
        $group = $_POST["group"];

        /**
         * Validate field
         */
        if (empty($mhost) || empty($mport) || empty($muser) || empty($mpass) || empty($mdb) || empty($username) || empty($password) || empty($password2) || empty($group) || empty($fname) || empty($email) || empty($name)) {
            $error[] = "- All fields are required.";
        }

        /**
         * Validate Password Strength
         */
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);

        if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            $error[] = "- The password must contain:<br/>
                        -- A tiny letter.<br/>
                        -- A capital letter.<br/>
                        -- A number.<br/>
                        -- A minimum of 8 characters.";

            unset($_SESSION["f"]["password"]);
            unset($_SESSION["f"]["password2"]);
        }


        /**
         * Validate Password
         */
        if ($password != $password2) {
            $error[] = "- Your password are not identical.";

            unset($_SESSION["f"]["password"]);
            unset($_SESSION["f"]["password2"]);
        }

        /**
         * Drop Database
         */
        try {
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ];

            $dbh = new PDO("mysql:host=$mhost;port=$mport;", $muser, $mpass, $options);
            $dbh->exec("DROP DATABASE IF EXISTS $mdb;");
        } catch (PDOException $e) {
            $error[] = "- " . $e->getMessage() . "(LINE : " . $e->getLine() . ")";
            $_SESSION["error"] = $error;
            header("Location: step2.php");
            exit;
        }

        /**
         * Create Database
         */
        try {
            $install_sql = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/install/sql/install.sql");
            $dbh->exec("CREATE DATABASE $mdb;");
            $dbh->exec("USE $mdb");
            $dbh->exec($install_sql);
        } catch (PDOException $e) {
            $error[] = "- " . $e->getMessage() . "(LINE : " . $e->getLine() . ")";
            $_SESSION["error"] = $error;
            header("Location: step2.php");
            exit;
        }

        /**
         * Insert admin user
         */
        try {

            $query = "	INSERT
					INTO
					  `ae_account`(
						`first_name`,
						`last_name`,
						`username`,
						`password`,
						`email`,
						`account_group`,
						`inscription_date`
					  )
					VALUES(
					 	:first_name,
						:last_name,
						:username,
						:password,
						:email,
						:account_group,
						NOW()
					)";

            $sth = $dbh->prepare($query);


            $sth->execute([
                "first_name" => $fname,
                "last_name" => $name,
                "username" => $username,
                "email" => $email,
                "password" => password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]),
                "account_group" => $group
            ]);
            $dbh = null;
        } catch (PDOException $e) {
            $error[] = "- " . $e->getMessage() . "(LINE : " . $e->getLine() . ")";
            $_SESSION["error"] = $error;
            header("Location: step2.php");
            exit;
        }

        /**
         * Create .env file
         */
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 80; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $myfile = fopen($_SERVER["DOCUMENT_ROOT"] . "/.env", "w");
        $txt = "DEBUG=0
BDD_HOST=$mhost
BDD_USER=$muser
BDD_PASS=$mpass
BDD_NAME=$mdb
ISSUER=\"Threenity CMS\"
AUDIENCE=All
JWT_KEY=$randomString";
        fwrite($myfile, $txt);
        fclose($myfile);

        /**
         * Validate error
         */
        if (count($error) > 0) {
            $_SESSION["error"] = $error;
            header("Location: step2.php");
            exit;
        } else {
            header("Location: step3.php");
            exit;
        }
    }
}
?>
