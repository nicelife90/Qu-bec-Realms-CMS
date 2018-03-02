<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/partials/header.php';

use ThreenityCMS\Helpers\Path;

?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1 id="module">Core Management</h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo Path::module(); ?>/manage-server.php"><i class="fa fa-dashboard"></i>Core Management</a>
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

                                    <!-- CONTENT HERE -->
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