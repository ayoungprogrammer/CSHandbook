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

	$res = preg_match('/<section><h2>Exercises<\/h2>(.*)<\/section>/is',$contents,$matches);

	if($res){
		$output = $output.$matches[1];
	}

}

print($output);

