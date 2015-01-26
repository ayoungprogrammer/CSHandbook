<?php

$cfg = parse_ini_file('../config/local_config.ini',true);

$config = $cfg['db'];
$user = $config['user'];
$password = $config['password'];
$db = $config['database'];
$host = $config['host']; 

$mysqli = new mysqli($host,$user,$password);


if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if(!$mysqli->select_db($db)){
    $mysqli->query("Create database if not exists algorithms");
    echo "DB does not exists, creating...\n";
}else {
    echo "DB exists\n";
}
$mysqli->select_db($db);

$res = $mysqli->query("SHOW TABLES like db");

$mysqli->query("CREATE TABLE articles (
    id varchar(100) NOT NULL PRIMARY KEY, 
    content varchar(65000) NOT NULL
    )");
