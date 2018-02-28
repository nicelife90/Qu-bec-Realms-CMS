<?php
session_start();
if (!isset($_SESSION["INSTALL"])) {
	echo "Unable to directly access the application installation folder!";
	die;
} else {

	if (isset($_POST["install"])) {

		/**
		 * Error
		 */
		$error = [];

		/**
		 * MySQL
		 */
		$mhost = $_POST["mhost"];
		$mport = $_POST["mport"];
		$muser = $_POST["muser"];
		$mpass = $_POST["mpass"];
		$mdb = $_POST["mdb"];

		/**
		 * CMS
		 */
		$username = $_POST["username"];
		$password = $_POST["password"];
		$password2 = $_POST["password2"];
		$group = $_POST["group"];

		/**
		 * Validate error
		 */
		if (count($error) > 0) {
			header("Location: step2.php");
			exit;
		} else {
			header("Location: step3.php");
			exit;
		}
	}
}
?>
