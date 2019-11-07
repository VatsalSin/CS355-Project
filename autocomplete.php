<?php
require("dbconnect.php");
	$arr = array();
	$query = $_GET['term'];
	$sql = "SELECT name,MATCH(name,specifications) AGAINST('$query') as rel FROM equipments WHERE name LIKE '%$query%' OR specifications LIKE '%$query%' ORDER BY rel DESC LIMIT 7";
	$res = $mysqli->query($sql);
	if(mysqli_num_rows($res)==0)
	{
		$sql = "SELECT name,MATCH(name,specifications) AGAINST('$query') as rel FROM equipments ORDER BY rel DESC LIMIT 7";
		$res = $mysqli->query($sql);
	}
	while($row = mysqli_fetch_assoc($res)){
		$arr[] = array('lable' => $row['name'], 'value' => $row['name']);
	}
	echo json_encode($arr);
?>