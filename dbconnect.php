<?php
date_default_timezone_set('Asia/Calcutta');

$host = 'localhost';
$username = 'id6589821_iitp';
$password  = 'CS355';
$db = 'id6589821_equipments';


// Connect mySql

$mysqli = new mysqli($host, $username, $password, $db);
//Check if Safe connection established
if ($mysqli->connect_error) {
    die("Connect Error:Could not cconnect to database");
}
?>