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
 * Date: 2017-10-26
 * Time: 16:38
 */

namespace ThreenityCMS\Helpers;

use ThreenityCMS\Controllers\Login;
use ThreenityCMS\Models\Threenity\AccountModel;
use ThreenityCMS\Models\Threenity\ModuleModel;
use ThreenityCMS\Models\Threenity\RbacModel;
use Exception;

class Security
{
    /**
     * Validate rbac item.
     *
     * @param $rbac_item_id - Item ID
     *
     * @return bool
     */
    public static function can($rbac_item_id)
    {
        if (RbacModel::can($rbac_item_id, Session::get('account_group')))
            return true;

        return false;
    }

    /**
     * Get all rbac items.
     *
     * @return \PDOStatement
     */
    public static function getItems()
    {
        return RbacModel::getItems();
    }

    /**
     * Add rbac item.
     *
     * @param $description - Description
     *
     * @return string
     */
    public static function addItem($description)
    {
        return RbacModel::addItem($description);
    }

    /**
     * Assign group to rbac item.
     *
     * @param $group_id - GroupModel
     * @param $rbac_item_id - Item
     */
    public static function addAssignment($group_id, $rbac_item_id)
    {
        RbacModel::addAssignment($group_id, $rbac_item_id);
    }

    /**
     * Remove assignment of a group to item.
     *
     * @param $group_id - GroupModel
     * @param $rbac_item_id - Item
     */
    public static function removeAssignment($group_id, $rbac_item_id)
    {
        RbacModel::removeAssignment($group_id, $rbac_item_id);
    }

    /**
     * Validate if user can access this PDF.
     */
    public static function havePdfAccess()
    {
        if (Session::get("account_id") == null) {
            session_destroy();
            Redirect::to("login.php");
        }

        if (Session::get("account_group") == null) {
            session_destroy();
            Redirect::to("login.php");
        }

    }

    /**
     * Validate login and access group for the current page
     *
     * @param $access_group
     */
    public static function validateAccess($register = false)
    {

        if ($register){
            if (empty($module) || $module == 'index') {
                Login::redirectRegister();
            }
        }

        /**
         * Validate login information
         */
        if (Session::get("account_id") == null) {
            session_destroy();
            Redirect::to("login.php");
        }

        if (Session::get("account_group") == null) {
            session_destroy();
            Redirect::to("login.php");
        }

        /**
         * Account value
         */
        $account_id = Session::get("account_id");
        $account_group = Session::get("account_group");


        /**
         * Generate / Update JSON Web Token for API access.
         */
        try {
            if (is_null(Session::get("account_jwt"))) {
                throw new Exception("GOTO : Generate Token");
            }

            $valid = JWToken::decode(Session::get("account_jwt"));
            if (!$valid['valid']) {
                throw new Exception("GOTO : Regenerate Token");
            }
        } catch (Exception $e) {
            $token = JWToken::encode($account_id, AccountModel::getFullName($account_id));
            Session::set("account_jwt", $token);
        }

        /**
         * Validate module access
         */
        $module = $_SERVER["SCRIPT_NAME"];
        $module = pathinfo($module)['filename'];


        if (empty($module) || $module == 'index') {
            Login::redirect();
        }

        $groups_authorized = ModuleModel::getAccessGroupArray($module);


        if (!in_array($account_group, $groups_authorized)) {
            Redirect::module('denied');
        }


        /**
         * Add visit
         */
        ModuleModel::addVisit($module);

    }


    /**
     * Validate Ajax Request Login
     *
     * @param $jwt - JSON Web Token
     *
     * @throws Exception
     */
    public static function validateAccessAjax($jwt)
    {
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            throw new Exception("Authentification Ajax invalide.");
        }

        $valid = JWToken::decode($jwt);
        if (!$valid['valid']) {
            throw new Exception("Authentification Ajax invalide (Token).");
        }
    }
}