<?php


$user = "root";
$password = "";


$mysqli = new mysqli("localhost",$user,$password);

/*
Returns if article $page exists
*/
function article_exists($page){
	$path  = 'data/'.$page.'.txt';
	return file_exists($path);
}

/*
PRE: article $page exists
returns content of article
*/
function get_article($page){
	$path = 'data/'.$page.'.txt';
	$content = file_get_contents($path);
	return $content;
}

/*
PRE: article $page can exist or not exist
POST: article $page is saved with $content
*/
function save_article($page,$content){
	$path  = 'data/'.$page.'.txt';
	file_put_contents($path, $content);
}


?>