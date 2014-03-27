<?php


require 'db_init.php';

$mysqli = new mysqli($host,$user,$password);
$mysqli->select_db($db);


if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}


$mysqli->select_db($db) or die("DB does not exist");

$res = $mysqli->query("SELECT * FROM articles");
while ($row = mysqli_fetch_array($res)){
	$path = './data/'.$row['id'].'.txt';
	print_r($row['id']."\n");

	file_put_contents($path,$row['content']);
}







?>