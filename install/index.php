<?php
session_start();
if (!isset($_SESSION["INSTALL"])) {
	echo "Unable to directly access the application installation folder!";
	die;
}
else {
    header("Location: step1.php");
    exit;
}
?>
