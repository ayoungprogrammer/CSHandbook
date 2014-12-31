<?php
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';
require 'src/parser.php';
require 'src/db.php';

$cfg = parse_ini_file('./config/local_config.ini',true);

$db = new DB($cfg['db']);

$crumbs = file_get_contents('./data/breadcrumbs.txt');

$map = json_decode($crumbs,true);

$topics = [];

foreach($map as $topic=>$value){
	$topics[] = preg_replace('/\_/',' ',$topic);
}

$topics = json_encode($topics);

function breadcrumbs($link){
	
	//print_r($map);
	//if(!$map.contains($link))return;
	if(!array_key_exists($link, $GLOBALS['map']))return;

	$tok = strtok($GLOBALS['map'][$link],'/');
	echo '<ul class="breadcrumbs">';
	while($tok !== false){
		$ref = str_replace(' ','_',$tok);
		echo '<li><a href=./'.$ref.'>'.$tok.'</a></li>';
		$tok = strtok('/');
	}
    echo '</ul>';
}
function navBar(){
	foreach($GLOBALS['cfg']['sections'] as $section){
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



on('GET','/', function () {
    render("main",[],false);
});

on('GET','/topics',function(){
	echo $GLOBALS['topics'];
});

/*
on('GET','/donate', function () {
    render("donate",[],false);
});*/
on('GET','/about', function () {
    render("about",[],false);
});

on('GET','/404',function(){
	render(
		"list",
		['page'=>'Error 404','title'=>'Error 404','body'=>'The page you are looking for could not be found.','desc'=>'','tags'=>''],
		false	
	);
});

on('GET','/(e|E)xercises',function(){

	$output = '';

	foreach($GLOBALS['map'] as $page => $path){
		
		if(!$GLOBALS['db']->article_exists($page)){
			continue;
		}

		$title = preg_replace('/\_/',' ',$page);

		$contents = $GLOBALS['db']->get_article($page);
		$contents = parse($contents);

		$res = preg_match('/<section><h2>Exercises<\/h2>(.*)<\/section>/is',$contents,$matches);

		if($res){
			$output = $output.'<b>'.$title.'</b>'.$matches[1];
		}

	}

	render("list",['page'=>'Exercises','title'=>'Exercises','body'=>$output,'desc'=>'Exercises','tags'=>'Exercises'],false);
});


//EDIT and SUBMIT is for stage
if($GLOBALS['cfg']['env']=='stage'){
	on('GET','/:page&=edit',function($page){
		$title = preg_replace('/\_/',' ',$page);

		if ($GLOBALS['db']->article_exists($page)){
            $content = $GLOBALS['db']->get_article($page);
			
			render("edit",['page'=>$page,'title'=>$title,'body'=>$content,'desc'=>$page],false);
		}
		else {
			render("edit",['page'=>$page,'title'=>$title,'body'=>'','desc'=>$page],false);
		}
	});
	on('POST','/:page&=submit',function($page){
		$content = params('content');
		$GLOBALS['db']->save_article($page,$content);
		redirect('./'.$page);
	});
}


//Get articles
on('GET','/:page',function($page){
	$title = preg_replace('/\_/',' ',$page);

	if($GLOBALS['db']->article_exists($page)){
		$content = $GLOBALS['db']->get_article($page);
		$content = parse($content);
		$desc = getDesc($content,$title);
		$tags = getTags($content,$title);
		render(
			"list",
			['page'=>$page,'title'=>$title,'body'=>$content,'desc'=>$desc,'tags'=>$tags],
			false
		);
	}else {
		//Edit for stage
		if($GLOBALS['cfg']['env']=='stage'){
			redirect('./'.$page.'&=edit');
		}else {
			redirect('./404');
		}
		
	}

});



dispatch();



?>



