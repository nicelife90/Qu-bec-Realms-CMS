<?php
/**
 * Copyright (C) 2014 - 2017 Threenity CMS - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary  and confidential
 * Written by : nicelife90 <yanicklafontaine@gmail.com>
 * Last edit : 2018
 */

namespace ThreenityCMS\Controllers;

use ThreenityCMS\Helpers\Database;
use ThreenityCMS\Helpers\Form;
use ThreenityCMS\Helpers\Password;
use ThreenityCMS\Helpers\Request;
use ThreenityCMS\Helpers\Utils;
use ThreenityCMS\Models\Threenity\AccountModel;
use ThreenityCMS\Models\Threenity\GroupModel;
use Exception;

class ManageAccount
{

	/**
	 * Handle multiples actions in account management.
	 *
	 * @return null|string
	 */
	public static function action()
	{

		$action = Request::get('action');

		$msg = null;
		switch ($action) {

			case "edit_group" :

				$group_data = GroupModel::getByGroupId(Request::get('group_id'), true);
				Form::save($group_data, true);
				$msg = "The group has been loaded.";

				break;

			case "delete_group":

				GroupModel::delete(Request::get('group_id'));

				$msg = "The group has been deleted.";

				break;


			case "edit_account" :

				$account_data = AccountModel::getById(Request::get('id'), true);
				Form::save($account_data, true);
				$msg = "The account has been loaded.";

				break;

			case "delete_account":

				AccountModel::delete(Request::get('id'));

				$msg = "The account has been deleted.";

				break;

			case "reset_pwd":

				AccountModel::setPassword(Request::get('id'), Password::hash('threenity213!'));
				AccountModel::setLoginAttempt(Request::get('id'), 0);

				$msg = "The password has been reset with the following password : threenity213!";

				break;


			case "unlock":

				AccountModel::setLoginAttempt(Request::get('id'), 0);

				$msg = "The account has been unlocked.";

				break;
		}

		return $msg;
	}

	/**
	 * Add new account group
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function addGroup()
	{

		/**
		 * Save form data
		 */
		Form::save(Request::post());

		/**
		 * Form value
		 */
		$group_name = Request::post('group_name');
		$dashboard = Request::post('dashboard');

		/**
		 * GroupModel name validate
		 */
		if (empty($group_name)) {
			Form::remove('group_name');
			throw new Exception("You must enter a group name.");
		}

		/**
		 * Dashboard validate
		 */
		if ($dashboard == -1) {
			Form::remove('dashboard');
			throw new Exception("You must enter a homepage.");
		}

		/**
		 * Check if MenuModel already have same name.
		 */
		if (!empty($group_name) && !Database::fieldIsUnique('ae_group', 'group_name', $group_name)) {
			Form::remove('group_name');
			throw new Exception("Another group already has the same name.");
		}

		/**
		 * Prepare data
		 */
		$group = [
			"group_name" => $group_name,
			"dashboard"  => $dashboard,
		];

		try {

			GroupModel::add($group);

			Form::destroy();

			return true;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * Edit account group
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function editGroup()
	{

		/**
		 * Update form data
		 */
		Form::update(Request::post());

		/**
		 * Form value
		 */
		$row_id = Form::getReturn('id');
		$group_id = Form::getReturn('group_id');
		$group_name = Request::post('group_name');
		$dashboard = Request::post('dashboard');

		/**
		 * GroupModel name validate
		 */
		if (empty($group_name)) {
			Form::remove('group_name');
			throw new Exception("You must enter a group name.");
		}

		/**
		 * Dashboard validate
		 */
		if ($dashboard == -1) {
			Form::remove('dashboard');
			throw new Exception("You must enter a homepage.");
		}

		/**
		 * Check if MenuModel already have same name.
		 */
		if (!empty($group_name) && !Database::fieldIsUnique('ae_group', 'group_name', $group_name, [$row_id])) {
			Form::remove('group_name');
			throw new Exception("Another group already has the same name.");
		}

		/**
		 * Prepare data
		 */
		$group = [
			"group_id"   => $group_id,
			"group_name" => $group_name,
			"dashboard"  => $dashboard,
		];

		try {

			GroupModel::update($group);

			Form::destroy();

			return true;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

	}

	/**
	 * Add new account
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function addAccount()
	{

		/**
		 * Save form data
		 */
		Form::save(Request::post());

		/**
		 * Form value
		 */
		$first_name = Request::post('first_name');
		$last_name = Request::post('last_name');
		$username = Request::post('username');
		$account_group = Request::post('account_group');
		$password = Request::post('password');
		$email = Request::post('email');

		/**
		 * Validate first name
		 */
		if (empty($first_name)) {
			Form::remove('first_name');
			throw new Exception("You must enter a first name.");
		}


		/**
		 * Validate last name
		 */
		if (empty($last_name)) {
			Form::remove('last_name');
			throw new Exception("You must enter a name.");
		}


		/**
		 * Validate username
		 */
		if (empty($username)) {
			Form::remove('username');
			throw new Exception("You must enter a username.");
		}

		if (!empty($username) && !Database::fieldIsUnique('ae_account', 'username', $username)) {
			Form::remove('username');
			throw new Exception("This username is not available.");
		}

		/**
		 * Validate group
		 */
		if (empty($account_group)) {
			Form::remove('account_group');
			throw new Exception("You must choose a group.");
		}

		/**
		 * Validate password
		 */
		if (empty($password)) {
			Form::remove('password');
			throw new Exception("You must enter a password.");
		}

		if (!Password::validateStrength($password)) {
			Form::remove('password');
			throw new Exception("The password must contain:<br/>
											- A tiny letter.<br/>
											- A capital letter.<br/>
											- A number.<br/>
											- A minimum of 8 characters.");
		}


		/**
		 * Validate email
		 */
		if (!Utils::isEmail($email)) {
			Form::remove('email');
			throw new Exception("You must enter a valid email.");
		}


		/**
		 * Prepare data
		 */
		$account = [
			"first_name"    => $first_name,
			"last_name"     => $last_name,
			"username"      => $username,
			"email"         => $email,
			"password"      => Password::hash($password),
			"account_group" => $account_group,
		];

		try {

			AccountModel::create($account);

			Form::destroy();

			return true;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * Edit account
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function editAccount()
	{

		/**
		 * Save form data
		 */
		Form::update(Request::post());

		/**
		 * Form value
		 */
		$first_name = Request::post('first_name');
		$last_name = Request::post('last_name');
		$username = Request::post('username');
		$account_group = Request::post('account_group');
		$password = Request::post('password');
		$email = Request::post('email');
		$account_id = Form::getReturn('id');

		/**
		 * Validate first name
		 */
		if (empty($first_name)) {
			Form::remove('first_name');
			throw new Exception("You must enter a first name.");
		}


		/**
		 * Validate last name
		 */
		if (empty($last_name)) {
			Form::remove('last_name');
			throw new Exception("You must enter a name.");
		}


		/**
		 * Validate username
		 */
		if (empty($username)) {
			Form::remove('username');
			throw new Exception("You must enter a username.");
		}

		if (!empty($username) && !Database::fieldIsUnique('ae_account', 'username', $username, [$account_id])) {
			Form::remove('username');
			throw new Exception("This username is not available.");
		}

		/**
		 * Validate group
		 */
		if (empty($account_group)) {
			Form::remove('account_group');
			throw new Exception("You must choose a group.");
		}

		/**
		 * Validate Password
		 */
		if (!empty($password) && !Password::validateStrength($password)) {
			Form::remove('password');
			throw new Exception("The password must contain:<br/>
											- A tiny letter.<br/>
											- A capital letter.<br/>
											- A number.<br/>
											- A minimum of 8 characters.");
		}

		/**
		 * Validate email
		 */
		if (!Utils::isEmail($email)) {
			Form::remove('email');
			throw new Exception("You must enter a valid email.");
		}


		/**
		 * Prepare data
		 */
		$account = [
			"id"            => $account_id,
			"first_name"    => $first_name,
			"last_name"     => $last_name,
			"username"      => $username,
			"email"         => $email,
			"password"      => $password,
			"account_group" => $account_group,
		];

		try {

			AccountModel::update($account);

			Form::destroy();

			return true;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

	}
}

