<?php
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';

// Load the configuration file
config('source', 'config.ini');

// The front page of the blog.
// This will match the root url
get('/index', function () {

   
});

// The post page
get('/:year/:month/:name',function($year, $month, $name){

    $post = find_post($year, $month, $name);

    if(!$post){
        not_found();
    }

    render('post', array(
        'title' => $post->title .' ⋅ ' . config('blog.title'),
        'p' => $post
    ));
});

// The JSON API
get('/api/json',function(){

    header('Content-type: application/json');

    // Print the 10 latest posts as JSON
    echo generate_json(get_posts(1, 10));
});

// Show the RSS feed
get('/rss',function(){

   // header('Content-Type: application/rss+xml');

    // Show an RSS feed with the 30 latest posts
    //echo generate_rss(get_posts(1, 30));
});

// If we get here, it means that
// nothing has been matched above

//get('.*',function(){
//    not_found();
//});

// Serve the blog
dispatch();

?>