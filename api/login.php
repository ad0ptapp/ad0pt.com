<?php
require_once("../../inc/account.php");
if(is_logged_in()) {
    die(json_encode(array("success" => true, "message" => "You are already logged in, redirecting to dashboard.")));
}

if(!isset($_POST['email'])) {
    die(json_encode(array("success" => false, "message" => "No email specified.")));
}

if(!isset($_POST['password'])) {
    die(json_encode(array("success" => false, "message" => "No password specified.")));
}

if(!is_string($_POST['email'])) {
    die(json_encode(array("success" => false, "message" => "email is not a string.")));
}

if(!is_string($_POST['password'])) {
    die(json_encode(array("success" => false, "message" => "password is not a string.")));
}

if(!try_login($_POST['email'], $_POST['password'])) {
    die(json_encode(array("success" => false, "message" => "Login failed, try again.")));
} else {
    die(json_encode(array("success" => true, "message" => "Logged in successfully, redirecting to dashboard.")));
}