<?php
require_once("db.php");
session_start();

$options = array('cost' => 15);

function try_login($email, $password) {
	global $db, $options;
    assert(is_string($email));
    assert(is_string($password));
    $dbpass = "";
    $user_id = 0;
	if($stmt = $db->prepare("SELECT `user_id`,`password` FROM `users` WHERE `email`=?")) {
		$stmt->bind_param("s", $email);
        $stmt->bind_result($user_id, $dbpass);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();
	} else {
		error_log("MySQL error {$db->errno} while logging in: {$db->error}", 3, "error_log.txt");
		return false;
	}
	if($dbpass == "") {
	    // verify junk to prevent someone from determining whether or not an email is in the database.
	    password_verify("134f613g62472h24h4hqh", '$2y$15$fZ4l6qMdKR1wqEVcR6FUgeNgMH1dVjAiVP6esok3BvKAi9FtFEzH2');
        return false;
    }

	if (password_verify($password, $dbpass)) {
		if(password_needs_rehash($dbpass, PASSWORD_DEFAULT, $options)) {
			$dbpass = password_hash($password, PASSWORD_DEFAULT, $options);
			if($stmt = $db->prepare("UPDATE `users` SET `password`=? WHERE `email`=?")){
				$stmt->bind_param("ss", $dbpass, $email);
				$stmt->execute();
				$stmt->close();
			} else {
				error_log("MySQL error {$db->errno} while upgrading password: {$db->error}", 3, "error_log.txt");
			}
		}
		session_regenerate_id();
		$_SESSION['email'] = $email;
		$_SESSION['user_id'] = $user_id;
		
		return true;
	}
	return false;
}

function is_logged_in() {
    return isset($_SESSION['email']);
}

function try_register($email, $password) {
	global $db, $options;
    if(!is_string($email)) return "Email is not a string";
    if(!is_string($password)) return "Password is not a string";

    $res = null;
	if($stmt = $db->prepare("SELECT COUNT(*) FROM `users` WHERE `email`=?")){
		$stmt->bind_param("s", $email);
		$stmt->bind_result($res);
		$stmt->execute();
		$stmt->fetch();	
		$stmt->close();
	} else {
		error_log("MySQL error {$db->errno} while checking registered users: {$db->error}", 3, "error_log.txt");
		return "Error querying database (1)";
	}
	
	if(is_numeric($res) && $res > 0) {
		return "An account is already registered with that email";
	}

	$inserted_id = null;
	if($stmt = $db->prepare('INSERT INTO `users`(`email`, `password`) VALUES (?,?)')){
        $password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
        $stmt->bind_param("ss", $email, $password_hash);
		$stmt->execute();
		$inserted_id = $stmt->insert_id;
		$stmt->close();
	} else {
		error_log("MySQL error {$db->errno} while inserting user: {$db->error}", 3, "error_log.txt");
		return "Error querying database (2)";
	}
	session_regenerate_id();

	if(!try_login($email, $password)) {
	    return "Error logging into new account.";
    }
}

function logout($reason=null) {
    if(is_string($reason)) {
        setcookie("logoutreason", $reason);
    }
    session_destroy();
    session_regenerate_id();
    header("Location: index.php");
}

if(isset($_SESSION['last_active']) && $_SESSION['last_active'] + 86400*7 < time()) {
	logout("You have been logged out for inactivity");
}
$_SESSION['last_active'] = time();