<?php
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';

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


on('GET','/:page',function($page){
	render("view",['content' => 'Test'],false);
});

dispatch();

?>

