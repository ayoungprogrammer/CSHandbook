<?php
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';

use \Michelf\MarkdownExtra;


function parse($str){
	//[======]   =>     <br><hr><br>
	$str = preg_replace('/\[\=+\]/',"<br><hr><br>",$str);

	$str = preg_replace('/\[\[[A-Za-z\_\s]+\]\]/','$1',$str);

	return MarkdownExtra::defaultTransform($str);
}


// Load the configuration file
//config('source', 'local_config.ini');
config([
    'dispatch.views' => 'templates',
    'dispatch.url' => 'http://localhost/wikialg'
    ]);


// The front page of the blog.
// This will match the root url
on('GET','/', function () {
    //echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    render("main",[],false);
});


on('GET','/view/:page',function($page){

	$content = file_get_contents('data/view/'.$page.'.txt');

	$content = parse($content);
	
	render("view",['title'=>$page,'body' => $content],false);
});

on('GET','/list/:page',function($page){


	$content = file_get_contents('data/list/'.$page.'.txt');
	$content = parse($content);

	render("list",['title'=>$page,'body'=>$content],false);
});

dispatch();



?>



