<?php
require_once("../../inc/account.php");
if(!is_logged_in()) {
    die(json_encode(array("error" => "not authenticated")));
}
if(!isset($_GET['profile'])) {
    die(json_encode(array("error" => "no profile specified")));
}