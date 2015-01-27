<?php

require '../src/db.php';

echo "Overwrite ALL data in database? (y/n): ";

$stdin = fopen('php://stdin','r');

do {
	$ch = fgetc($stdin);
}while( $ch != 'y' && $ch != 'n');

if($ch == 'n'){
	echo "Aborting script\n";
	exit;
}

$config = parse_ini_file('../config/local_config.ini',true);
$db = new DB($config['db']);

$data_dir = '../data/';
$dir = new DirectoryIterator($data_dir);
foreach($dir as $fileinfo){
	if(!$fileinfo->isDot() && $fileinfo->getExtension()=='txt'){
		$title = $fileinfo->getBasename('.txt');
		$content = file_get_contents($data_dir.$fileinfo->getBasename());
		$content = $content;
		echo $fileinfo->getBasename('.txt')."\n";

		$db->save_article($title,$content);
	}
}


?>