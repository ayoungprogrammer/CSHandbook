<?php
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';
require 'parser.php';
require 'breadcrumbs.php';
require 'db.php';

use \Michelf\MarkdownExtra;



$sections = array(
	'Data Structures',
	'Sorting',
	'Geometry',
	'Graph Theory',
	'Number Theory',
	'Pattern Matching',
	);


function navBar(){
	foreach($GLOBALS['sections'] as $section){
		$section_ref = './'.str_replace(' ','_',$section);
		echo '<li><a href="'.$section_ref.'">'.$section.'</a></li>';
	}
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
    on('GET','/donate', function () {
        //echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        render("donate",[],false);
    });

	on('GET','/links',function($page){
		$map = bfsLinks();
		file_put_contents('breadcrumbs.txt',json_encode($map));
		foreach ($map as $link){
			echo $link.'<br>';
		}
		print_r($map);
	});


	on('GET','/:page&=edit',function($page){
		$path  = 'data/'.$page.'.txt';
		$title = preg_replace('/\_/',' ',$page);

		if (file_exists($path)){
			$content = file_get_contents($path);
			
			render("edit",['page'=>$page,'title'=>$title,'body'=>$content],false);
		}
		else {
			render("edit",['page'=>$page,'title'=>$title,'body'=>''],false);
		}
	});

	on('GET','/:page',function($page){

		
		$title = preg_replace('/\_/',' ',$page);

		if(article_exists($page)){
			$content = get_article($page);
			$content = parse($content);
			render("list",['page'=>$page,'title'=>$title,'body'=>$content],false);
		}else {
			redirect('./'.$page.'&=edit');
		}
	
	});

	on('POST','/:page&=submit',function($page){
		$content = params('content');
		save_article($page,$content);
		redirect('./'.$page);
	});
	

	
	dispatch();



?>



