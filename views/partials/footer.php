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
 * Date: 2017-10-10
 * Time: 13:47
 */

use ThreenityCMS\Helpers\Debugbar;
use ThreenityCMS\Helpers\Path;
use ThreenityCMS\Helpers\Security;

?>

<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014 - 2017 <a href="<?php echo Path::root(); ?>">Threenity CMS</a></strong> -
    All rights reserved.

    <?php
    if (Security::can(1)) {
        ?>
        <div class="pull-right hidden-xs">
            <?php
            echo "\n Generated in <strong>" . number_format(microtime(true) - $start_time, 2) . "</strong> seconds.";
            ?>
        </div>
    <?php } ?>
</footer>


</div>
<!-- ./wrapper -->
<script src="<?php echo Path::comp(); ?>/moment/moment.js"></script>
<link href="<?php echo Path::comp(); ?>/iCheck/all.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo Path::comp(); ?>/iCheck/icheck.min.js" type="text/javascript"></script>
<script src="<?php echo Path::js(); ?>/threenity.js"></script>

<!-- Date range picker -->
<script type="text/javascript" src="<?php echo Path::comp(); ?>/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?php echo Path::comp(); ?>/daterangepicker/daterangepicker-bs3.css">

<!-- Debug Bar -->
<?php
if (Security::can(3)) {
    Debugbar::getBodyHTML();
}
?>

</body>
</html>
