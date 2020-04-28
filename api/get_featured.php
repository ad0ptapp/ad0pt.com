<?php
require("../../inc/account.php");

$offset = 0;
if(isset($_GET['i'])) {
    $offset = max($_GET['i'] * 5, 0);
}
if(!is_numeric($offset)) die("{\"success\":false,\r\n\"message\":\"Invalid offset\"}");

$sql = "SELECT posts.animal_id, posts.body, animals.species, animals.age, animals.name, animals.breed, animals.weight, animals.registered, animals.gender, user_info.full_name, user_info.state, user_info.city, user_info.phone_number
FROM posts 
INNER JOIN animals USING(animal_id)
INNER JOIN user_info ON posts.owner_id = user_info.user_id
LIMIT $offset, 5;
";

if ($res = $db->query($sql)) {
    $out = array("success"=>true, "posts"=>array());
    while($row = $res->fetch_assoc()) {
        array_push($out["posts"], array(
            "animal_id"=>$row["animal_id"],
            "body"=>$row["body"],
            "species"=>$row["species"],
            "age"=>$row["age"],
            "animal_name"=>$row["name"],
            "breed"=>$row["breed"],
            "weight"=>$row["weight"],
            "post_created"=>$row["registered"],
            "poster_name"=>$row["full_name"],
            "state"=>$row["state"],
            "city"=>$row["city"],
            "gender"=>$row["gender"] == 1 ? "Male" : "Female",
            "phone"=>is_logged_in() ? $row["phone_number"] : "Log in to view"
        ));
    }
    echo json_encode($out);
} else {
    echo $db->error;
    die('"success":false,"message":"Error querying database: ' . $db->errno .'"');
}
