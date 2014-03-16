<?php
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';

echo "wtf";

// Load the configuration file
//config('source', 'local_config.ini');
config([
    'dispatch.views' => 'templates',
    'dispatch.url' => 'http://localhost/wikialg'
    ]);


// The front page of the blog.
// This will match the root url
on('GET','/', function () {
    echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    render("main");
});


on('GET','*',function($id){
    echo "Test2";
});

dispatch();

?>

