<?php


require 'db_init.php';

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

$data_dir = 'data/';
$dir = new DirectoryIterator($data_dir);
foreach($dir as $fileinfo){
	if(!$fileinfo->isDot() && $fileinfo->getExtension()=='txt'){
		$title = mysql_real_escape_string($fileinfo->getBasename('.txt'));
		$content = file_get_contents($data_dir.$fileinfo->getBasename());
		$content = mysql_real_escape_string($content);
		echo $fileinfo->getBasename('.txt')."\n";
		$mysqli->query("INSERT INTO articles (id,content)
			VALUES ('".$title."','".$content."')");
	}
}

$mysqli->close();

?>