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
                <a type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p>Step 3</p>
            </div>
        </div>
    </div>
    <form role="form" action="install.php" method="post">
        <div class="row setup-content" id="step-2">
            <div class="col-xs-6 col-md-offset-3">
                <div class="col-md-12">
                    <h3>Threenity CMS - Configuration</h3>

					<?php
					if (isset($error) && count($error) > 0) {
						$err = implode("<br/>", $error);
						echo "<div class='alert alert-danger'>$err</div>";
					}
					?>

                    <br/>
                    <h4>MySQL</h4>
                    <hr/>
                    <div class="alert alert-warning">
                        <strong>Note that the database is automatically created by the installation. If this database is
                            present in mysql, it will be deleted before being recreated.</strong>
                    </div>
                    <div class="form-group">
                        <label class="control-label">MySQL Host</label>
                        <input maxlength="200" type="text" required="required" class="form-control"
                               placeholder="Enter MySQL Host" name="mhost"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">MySQL Port</label>
                        <input maxlength="200" type="text" required="required" class="form-control"
                               placeholder="Enter MySQL Port" name="mport"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">MySQL User</label>
                        <input maxlength="200" type="text" required="required" class="form-control"
                               placeholder="Enter MySQL User" name="muser"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">MySQL Password</label>
                        <input maxlength="200" type="text" required="required" class="form-control"
                               placeholder="Enter MySQL Password" name="mpass"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">MySQL Database</label>
                        <input maxlength="200" type="text" required="required" class="form-control"
                               placeholder="Enter MySQL Database" name="mdb"/>
                    </div>
                    <br/>
                    <h4>CMS Administrator</h4>
                    <div class="alert alert-warning">
                        <strong>This account will be the main administrator account of the CMS.</strong>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label">Username</label>
                        <input maxlength="200" type="text" required="required" class="form-control"
                               placeholder="Enter your new username" name="username"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <input maxlength="200" type="text" required="required" class="form-control"
                               placeholder="Enter your new password" name="password"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Repeat Password</label>
                        <input maxlength="200" type="text" required="required" class="form-control"
                               placeholder="Repeat your new password" name="password2"/>
                    </div>
                    <div class="alert alert-warning">
                        <strong>The developer group is only recommended for people who have a strong understanding of
                            programming and databases. The developer option gives rights that can break the
                            CMS.</strong>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Group</label>
                        <select name="group" class="form-control">
                            <option value="1" selected>Administrator</option>
                            <option value="2">Developer (Only for advanced user)</option>
                        </select>
                    </div>
                    <a href="step1.php" class="btn btn-primary pull-left">Previous</a>
                    <input class="btn btn-success pull-right" type="submit" value="Install" name="install">
                </div>
            </div>
        </div>
    </form>
    <br/>
</div>
</body>
</html>
