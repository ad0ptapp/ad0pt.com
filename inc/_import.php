<?php
require_once("db.php");
$lines = file("names.csv");
array_shift($lines);
$csv = array_map('str_getcsv', $lines);
$assoc = array();

if($res = $db->query("SELECT user_id, email FROM users")) {
    while($row = $res->fetch_assoc()) {
        $assoc[$row['email']] = $row['user_id'];
    }
}

if($stmt = $db->prepare("INSERT INTO user_info VALUES (?,?,?,?,?,?,?)")) {
    $country = "US";
    foreach ($csv as $item) {
        if(!isset($assoc[$item[10]]))
            continue;
        $full_name = "$item[3] $item[5]";
        $phone = rand(1000000000, 9999999999);
        $stmt->bind_param("issssss", $assoc[$item[10]], $full_name, $country, $item[8], $item[7], $item[9], $phone);
        $stmt->execute();
    }
    $stmt->close();
}
