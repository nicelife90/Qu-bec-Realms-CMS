<?php
session_start();
if (!isset($_SESSION["INSTALL"])) {
	echo "Unable to directly access the application installation folder!";
	die;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="js/jquery-1.11.1.js"></script>
    <link href="css/boostrap3.css" rel="stylesheet" id="bootstrap-css">
    <script src="js/boostrap3.js"></script>
    <link href="css/install.css" rel="stylesheet" id="bootstrap-css">
    <title>Threenity CMS - Install</title>
</head>
<body>
<div class="container">
    <div class="stepwizard col-md-offset-3">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step">
                <a type="button" class="btn btn-primary btn-circle">1</a>
                <p>Step 1</p>
            </div>
            <div class="stepwizard-step">
                <a type="button" class="btn btn-primary btn-circle">2</a>
                <p>Step 2</p>
            </div>
            <div class="stepwizard-step">
                <a type="button" class="btn btn-primary btn-circle">3</a>
                <p>Step 3</p>
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-1">
        <div class="col-xs-6 col-md-offset-3">
            <div class="col-md-12">
                <h3>Threenity CMS - Welcome</h3>
                <br/>
                <p>Threenity CMS is proud to count you as a new user.</p>
                <p>This wizard will guide you through the installation of the CMS.</p>
                <p>Press <strong>Next</strong> to begin.</p>
                <a href="../index.php" class="btn btn-success pull-right">Go to Threenity CMS</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
