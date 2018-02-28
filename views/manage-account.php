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

require $_SERVER['DOCUMENT_ROOT'] . '/views/partials/header.php';

use ThreenityCMS\Controllers\ManageAccount;
use ThreenityCMS\Helpers\Form;
use ThreenityCMS\Helpers\Messages;
use ThreenityCMS\Helpers\Path;
use ThreenityCMS\Helpers\Request;
use ThreenityCMS\Helpers\Session;
use ThreenityCMS\Models\Threenity\AccountModel;
use ThreenityCMS\Models\Threenity\GroupModel;
use ThreenityCMS\Models\Threenity\ModuleModel;
use ThreenityCMS\Helpers\Popover;

?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1 id="module">Account Management</h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo Path::root(); ?>"><i class="fa fa-dashboard"></i>Account Management</a>
                </li>

            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="row">
                <div class="col-md-12">
					<?php
					if (Request::get('action') && Session::getFormId('manage-link') == Request::get('token')) {
						try {
							$message = ManageAccount::action();
							Messages::success($message);
						} catch (Exception $e) {
							Messages::error($e->getMessage());
						}
					}
					?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
					<?php
					if (!is_null(Request::post('save-group')) && Session::getFormId('mng-group') == Request::post('DBLP')) {
						try {

							if (Form::getReturn('edit_mode') == 1) {

								//EDIT
								if (ManageAccount::editGroup()) {
									Messages::success("The group has been modified.");
								}
							} else {

								//ADD
								if (ManageAccount::addGroup()) {
									Messages::success("The group has been created.");
								}
							}

						} catch (Exception $e) {
							Messages::error($e->getMessage());
						}
					}
					?>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
					<?php
					if (!is_null(Request::post('save-account')) && Session::getFormId('mng-account') == Request::post('DBLP')) {
						try {

							if (Form::getReturn('edit_mode') == 1) {

								//EDIT
								if (ManageAccount::editAccount()) {
									Messages::success("The account has been modified.");
								}
							} else {

								//ADD
								if (ManageAccount::addAccount()) {
									Messages::success("The account has been created.");
								}
							}

						} catch (Exception $e) {
							Messages::error($e->getMessage());
						}
					}
					?>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Groups</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <form action="<?php echo Path::module() ?>/manage-account.php"
                                                  method="post">
                                                <input type="hidden" name="DBLP"
                                                       value="<?php echo Session::setFormId('mng-group'); ?>">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label>Group Name</label>
                                                        <div class="input-group"><span class="input-group-addon"><i
                                                                        class="fa fa-quote-left"></i></span>
                                                            <input class="form-control" name="group_name" type="text"
                                                                   value="<?php Form::get('group_name') ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label>Homepage</label>
                                                        <div class="input-group"><span class="input-group-addon"><i
                                                                        class="fa fa-tachometer"></i></span>
                                                            <select name="dashboard" class="form-control">
                                                                <option value="-1" selected>Select Homepage
                                                                </option>
																<?php
																$modules = ModuleModel::getAll();
																while ($module = $modules->fetchObject()) {
																	echo '<option value="' . $module->name . '" ' . (Form::getReturn('dashboard') == $module->name ? 'selected' : null) . '>' . $module->name . '</option>';
																}
																?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/>
                                                <input class="btn btn-danger btn-flat"
                                                       type="submit" name="save-group" value="Save">
                                            </form>

                                            <!-- Tableau -->
                                            <br/>

                                            <div class="table-responsive">
                                                <table id="mng_group" class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Group Name</th>
                                                        <th>Home Page</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
													<?php
													$groups = GroupModel::getAll();
													$token = Session::setFormId('manage-link');
													while ($group = $groups->fetchObject()) {

														$rm = '?action=delete_group&group_id=' . $group->group_id . '&token=' . $token;
														$vim = '?action=edit_group&group_id=' . $group->group_id . '&token=' . $token;

														if ($group->group_id != -1) {
															echo '<tr>
                                                            <td>' . $group->group_name . '</td>
                                                            <td>' . $group->dashboard . '</td>
                                                            <td>
                                                            <a  class="btn btn-success btn-xs btn-flat" 
                                                                title="Modify Group" 
                                                                data-toggle="tooltip"
                                                                href="' . $vim . '">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a  class="btn btn-danger btn-xs btn-flat" 
                                                                title="Delete Group" 
                                                                data-toggle="tooltip"
                                                                onclick="return iconfirm(\'Warning!\',\'Are you sure you want to delete this group?\', this.href)" 
                                                                href="' . $rm . '">
                                                                <i class="fa fa-trash-o"></i>
                                                            </a>
                                                            </td>
                                                            </tr>';
														} else {
															echo '<tr>
                                                            <td>' . $group->group_name . '</td>
                                                            <td>' . $group->dashboard . '</td>
                                                            <td></td>
                                                            </tr>';
														}
													}
													?>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Accounts</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <form action="<?php echo Path::module() ?>/manage-account.php"
                                                  method="post">
                                                <input type="hidden" name="DBLP"
                                                       value="<?php echo Session::setFormId('mng-account'); ?>">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label>First Name</label>
                                                        <div class="input-group"><span class="input-group-addon"><i
                                                                        class="fa fa-user"></i></span>
                                                            <input class="form-control" name="first_name" type="text"
                                                                   value="<?php Form::get('first_name') ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label>Last Name</label>
                                                        <div class="input-group"><span class="input-group-addon"><i
                                                                        class="fa fa-user"></i></span>
                                                            <input class="form-control pointer" name="last_name"
                                                                   type="text"
                                                                   value="<?php Form::get('last_name') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label>Username</label>
                                                        <div class="input-group"><span class="input-group-addon"><i
                                                                        class="fa fa-tag"></i></span>
                                                            <input class="form-control" name="username" type="text"
                                                                   value="<?php Form::get('username') ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label>Group</label>
                                                        <div class="input-group"><span class="input-group-addon"><i
                                                                        class="fa fa-group"></i></span>
                                                            <select name="account_group" class="form-control">
                                                                <option value="0" selected>Select Group
                                                                </option>
																<?php
																$groups = GroupModel::getAll();
																while ($group = $groups->fetchObject()) {
																	echo '<option value="' . $group->group_id . '" ' . (Form::getReturn('account_group') == $group->group_id ? 'selected' : null) . '>' . $group->group_name . '</option>';
																}
																?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label>Password<?php Popover::help("To keep current password, leave this field empty!") ?></label>
                                                        <div class="input-group"><span class="input-group-addon"><i
                                                                        class="fa fa-key"></i></span>
                                                            <input class="form-control" name="password" type="password"
                                                                   autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Email</label>
                                                        <div class="input-group"><span class="input-group-addon"><i
                                                                        class="fa fa-envelope"></i></span>
                                                            <input id="email" class="form-control" name="email"
                                                                   type="text"
                                                                   value="<?php Form::get('email') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/>
                                                <input class="btn btn-danger btn-flat" type="submit" name="save-account"
                                                       value="Save">
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Tableau -->
                                    <br/>
                                    <div class="table-responsive">
                                        <table id="mng_user" class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Username</th>
                                                <th>Group</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php

											$accounts = AccountModel::getAll();
											while ($account = $accounts->fetchObject()) {

												$rm = '?action=delete_account&id=' . $account->id . '&token=' . $token;
												$vim = '?action=edit_account&id=' . $account->id . '&token=' . $token;
												$rst = '?action=reset_pwd&id=' . $account->id . '&token=' . $token;
												$unl = '?action=unlock&id=' . $account->id . '&token=' . $token;

												echo '<tr>
                                                        <td>' . $account->first_name . '</td>
                                                        <td>' . $account->last_name . '</td>
                                                        <td>' . $account->username . '</td>
                                                        <td>' . GroupModel::getNameById($account->account_group) . '</td>
                                                        <td>' . $account->email . '</td>
                                                        <td>
                                                            <a  class="btn btn-success btn-xs btn-flat" 
                                                                title="Modify Account" 
                                                                data-toggle="tooltip"
                                                                href="' . $vim . '">
                                                                <i class="fa fa-pencil fa-fw"></i>
                                                            </a>
                                                            
                                                            <a  class="btn btn-primary btn-xs btn-flat" 
                                                                title="Reset Password : threenity213!" 
                                                                data-toggle="tooltip"
                                                                onclick="return iconfirm(\'Attention!\',\'Are you sure you want to reset the password?\',this.href)" 
                                                                href="' . $rst . '">
                                                                <i class="fa fa-key fa-fw"></i>
                                                            </a>
                                                            
                                                            <a  class="btn btn-warning btn-xs btn-flat" 
                                                                title="Unlock Account" 
                                                                data-toggle="tooltip"
                                                                onclick="return iconfirm(\'Attention!\',\'Are you sure you want to unlock the account?\',this.href)" 
                                                                href="' . $unl . '">
                                                                <i class="fa fa-unlock-alt fa-fw"></i>
                                                            </a>
                                                            <a  class="btn btn-danger btn-xs btn-flat" 
                                                                title="Delete Account" 
                                                                data-toggle="tooltip"
                                                                onclick="return iconfirm(\'Attention!\',\'Are you sure you want to delete this user?\',this.href)" 
                                                                href="' . $rm . '">
                                                                <i class="fa fa-trash-o fa-fw"></i>
                                                            </a>
                                                        </td>
                                                        </tr>';
											}
											?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>

    <script>
        $(function () {
            $('#mng_user').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': false,
                'autoWidth': true,
                "lengthMenu": [[50, 100, -1], [50, 100, "Toutes"]]
            })
        })
    </script>

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/partials/footer.php';