<?php 

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD','root');
define('DB_NAME','recipie_haven');
// define('CATEGORY_IMAGES', 'Config')

$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if($db->connect_error){
    die("Unable to connect to database " . $db->connect_error);
}


