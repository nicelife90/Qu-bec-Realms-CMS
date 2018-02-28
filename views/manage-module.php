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

use ThreenityCMS\Controllers\ManageModule;
use ThreenityCMS\Helpers\FontAwesome;
use ThreenityCMS\Helpers\Form;
use ThreenityCMS\Helpers\Messages;
use ThreenityCMS\Helpers\Path;
use ThreenityCMS\Helpers\Request;
use ThreenityCMS\Helpers\Session;
use ThreenityCMS\Helpers\Utils;
use ThreenityCMS\Models\Threenity\GroupModel;
use ThreenityCMS\Models\Threenity\MenuModel;
use ThreenityCMS\Models\Threenity\ModuleModel;

?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1 id="module">Module Management</h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo Path::root(); ?>"><i class="fa fa-dashboard"></i>Module Management</a>
                </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (Request::get('action') && Session::getFormId('mng-link') == Request::get('token')) {
                        try {
                            $message = ManageModule::action();
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
                    if (!is_null(Request::post('save-module')) && Session::getFormId('mng-module') == Request::post('DBLP')) {
                        try {

                            if (Form::getReturn('edit_mode') == 1) {

                                //EDIT
                                if (ManageModule::edit()) {
                                    Messages::success("The module has been modified.");
                                }
                            } else {

                                //ADD
                                if (ManageModule::add()) {
                                    Messages::success("The module has been created.");
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

                    <div class="alert alert-warning">
                        <p>This page is for advanced users. Mishandling on this page could prevent the CMS from operating normally.</p>
                    </div>


                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Module</h3>
                        </div>


                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <form action="<?php echo Path::module() ?>/manage-module.php"
                                          method="post">
                                        <input type="hidden" name="DBLP"
                                               value="<?php echo Session::setFormId('mng-module'); ?>">
                                        <label>Description</label>
                                        <div class="input-group"><span class="input-group-addon"><i
                                                        class="fa fa-quote-left"></i></span>
                                            <input class="form-control" name="description" type="text"
                                                   value="<?php Form::get('description') ?>">
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <label>Name</label>
                                                <div class="input-group"><span class="input-group-addon"><i
                                                                class="fa fa-terminal"></i></span>
                                                    <input class="form-control" name="name" type="text"
                                                           value="<?php Form::get('name') ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <label>Icon</label>
                                                <div class="input-group"><span class="input-group-addon"><i
                                                                class="fa fa-file-text-o"></i></span>
                                                    <select name="icon" class="form-control selectpicker"
                                                            data-live-search="true">
                                                        <option value="-1" selected>Choose an icon</option>
                                                        <?php
                                                        $icons = FontAwesome::getIcon();
                                                        foreach ($icons as $key => $value) {
                                                            echo '<option value="' . $key . '" data-Icon="fa ' . $key . '" ' . (Form::getReturn('icon') == $key ? 'selected' : null) . '>' . $key . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <label>Parent menu</label>
                                                <div class="input-group"><span class="input-group-addon"><i
                                                                class="fa fa-sitemap"></i></span>
                                                    <select name="parent" class="form-control selectpicker">
                                                        <option value="0" selected>Choose a menu</option>
                                                        <?php
                                                        $parents = MenuModel::getAll();
                                                        while ($parent = $parents->fetchObject()) {

                                                            echo '<option value="' . $parent->menu_id . '" ' . (Form::getReturn('parent') == $parent->menu_id ? 'selected' : null) . '>' . $parent->title . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">

                                            <div class="col-sm-6 col-md-6">
                                                <label>Active</label>
                                                <div class="input-group"><span class="input-group-addon"><i
                                                                class="fa fa-sitemap"></i></span>
                                                    <select name="active" class="form-control selectpicker">
                                                        <option value="-1" selected>Choose an option</option>
                                                        <option
                                                                value="0" <?php echo !is_null(Form::getReturn('active')) && Form::getReturn('active') == 0 ? 'selected' : null ?>>
                                                            Active
                                                        </option>
                                                        <option
                                                                value="1" <?php echo !is_null(Form::getReturn('active')) && Form::getReturn('active') == 1 ? 'selected' : null ?>>
                                                            Inactive
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6">
                                                <label>Static</label>
                                                <div class="input-group"><span class="input-group-addon"><i
                                                                class="fa fa-sitemap"></i></span>
                                                    <select name="static" class="form-control selectpicker">
                                                        <option value="-1" selected>Choose an option</option>
                                                        <option
                                                                value="0" <?php echo !is_null(Form::getReturn('static')) && Form::getReturn('static') == 0 ? 'selected' : null ?>>
                                                            No
                                                        </option>
                                                        <option
                                                                value="1" <?php echo !is_null(Form::getReturn('static')) && Form::getReturn('static') == 1 ? 'selected' : null ?>>
                                                            Yes
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <table class="table table-bordered table-striped table-condensed">
                                            <thead>
                                            <tr>
                                                <th>Group</th>
                                                <th>Allow</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $current_group = Form::getReturn('access_level');
                                            if (!is_array($current_group)) {
                                                $current_group = explode(";", $current_group);
                                            }

                                            $groups = GroupModel::getAll();
                                            while ($group = $groups->fetchObject()) {

                                                echo '<tr>';
                                                echo '<td>' . $group->group_name . '</td>';

                                                echo '<td>
                                                        <div class="checkbox icheck">
                                                            <label>
                                                                <input type="checkbox" name="access_level[]" value="' . $group->group_id . '" ' . (@in_array($group->group_id, $current_group) ? 'checked' : null) . '>
                                                            </label>
                                                        </div>
                                                       </td>';

                                            }
                                            ?>
                                            </tbody>
                                        </table>

                                        <input class="btn btn-danger btn-flat" type="submit" name="save-module"
                                               value="Save">
                                    </form>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- Tableau -->
                                    <div class="table-responsive">
                                        <table id="mng_module"
                                               class="table table-striped table-bordered table-responsive table-condensed">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Icon</th>
                                                <th>Parent menu</th>
                                                <th>Static</th>
                                                <th>Visits</th>
                                                <th>Last visit</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php

                                            $modules = ModuleModel::getAll();
                                            $token = Session::setFormId('mng-link');

                                            while ($module = $modules->fetchObject()) {

                                                $rm = '?action=delete&id=' . $module->id . '&token=' . $token;
                                                $vim = '?action=edit&id=' . $module->id . '&token=' . $token;

                                                echo '<tr ' . ($module->active == 0 ? "class='bg-red-gradient'" : null) . '>
                                                    <td>' . $module->name . '</td>
                                                    <td>' . $module->description . '</td>
                                                    <td><i class="fa ' . $module->icon . '"></i></td>
                                                    <td>' . ($module->static == 1 ? '<span class="label label-success">Static</span>' : MenuModel::getNameById($module->parent)) . '</td>
                                                    <td>' . ($module->static == 1 ? '<span class="label label-success">Oui</span>' : '<span class="label label-danger">Non</span>') . '</td>
                                                    <td>' . $module->visits . '</td>
                                                    <td>' . Utils::dateFromTimeStamp('d-m-Y', $module->last_visit) . '</td>
                                                    <td>
                                                    <a  class="btn btn-success btn-flat btn-xs" 
                                                        title="Modifier le module" 
                                                        data-toggle="tooltip"
                                                        href="' . $vim . '">
                                                            <i class="fa fa-pencil"></i>
                                                    </a>
                                                    
                                                    <a  class="btn btn-danger btn-flat btn-xs" 
                                                        title="Supprimer le module" 
                                                        data-toggle="tooltip"
                                                        onclick="return iconfirm(\'Attention!\',\'Êtes-vous de vouloir supprimer ce module\', this.href)" 
                                                        href="' . $rm . '">
                                                            <i class="fa fa-trash-o"></i>
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
            $('#mng_module').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': false,
                'autoWidth': true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/French.json"
                }
            })
        })
    </script>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/partials/footer.php';