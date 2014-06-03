<?php

require '../src/db.php';

$db = new DB('../config/local_config.ini');

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