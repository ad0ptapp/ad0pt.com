<?php
require_once("../inc/account.php");
if(!is_logged_in()){
	header("Location: login.html");
	echo "Redirecting you to the login page, click <a href='login.php'>here</a> if you are not automatically redirected.";
	exit;
}
header("Location: featured.html");