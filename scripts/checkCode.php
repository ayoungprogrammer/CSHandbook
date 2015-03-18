<?php

require '../vendor/autoload.php';
require '../src/db.php';
require '../src/parser.php';


$map = json_decode(file_get_contents('../data/breadcrumbs.txt'),true);

$cfg = parse_ini_file('../config/local_config.ini',true);

$db = new DB($cfg['db']);


$output = "";

foreach($map as $page => $path){
	
	if(!$db->article_exists($page)){
		continue;
	}

	$contents = $db->get_article($page);
	$contents = parse($contents);

	$matches = [];

	$str = preg_match(
		'/<pre.*?>(.*?)<\/pre>/s',
		$contents,
		$matches
	);

	if($matches){
		preg_match('/\)\{/',$matches[0],$brackets);
		if($brackets){
			print($page."\n");
		}
		preg_match('/\t/', $matches[0], $tabs);
		if($tabs){
			print($page."\n");
		}
	}

}


