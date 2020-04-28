<?php

$db = mysqli_connect("localhost", 'id13225359_adopt_admin', 'uOZwUEIaMcO85~w}', "id13225359_ad0pt");

if(!$db) {
    http_response_code(500);
    error_log("Error connecting to mysql database " . mysqli_connect_errno() . ": " . mysqli_connect_error(), 3, "error_log.txt");
    
    die("Error connecting to database.");
}