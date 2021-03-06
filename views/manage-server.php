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

use ThreenityCMS\Helpers\Path;
use ThreenityCMS\Controllers\ManageServer;
use ThreenityCMS\Helpers\Request;

?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1 id="module">Core Management</h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo Path::module(); ?>/manage-server.php"><i class="fa fa-dashboard"></i>Core
                        Management</a>
                </li>

            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Manage</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <?php
                                    if (!ManageServer::valiateServerInstall()) {
                                        ?>
                                        <div class="alert alert-warning">
                                            Unable to detect a TrinityCore installation. <br/>
                                            Press the <strong>Install TrinityCore</strong> button to start the
                                            compilation process.
                                        </div>
                                        <div class="text-center">
                                            <a href="manage-server.php?compile" class="btn btn-success btn-lg btn-flat"><i
                                                        class="fa fa-plus-circle"></i> Install
                                                TrinityCore</a>
                                        </div>
                                    <?php } ?>

                                    <?php
                                    if (!is_null(Request::get("compile"))) {
                                        ?>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">Compilation</div>
                                            <div class="panel-body">
                                                <?php
                                                ManageServer::installTrinityCore();
                                                ?>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/partials/footer.php';