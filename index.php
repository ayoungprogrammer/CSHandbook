<?php
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';
require 'src/parser.php';
require 'src/db.php';


$db = new DB('./config/local_config.ini');


$sections = array(
	'Data Structures',
	'Sorting',
	'Geometry',
	'Graph Theory',
	'Number Theory',
	'Pattern Matching',
	'Searches',
	'Dynamic Programming'
	);

function breadcrumbs($link){
	$map = json_decode(file_get_contents('./data/breadcrumbs.txt'),true);
	//print_r($map);
	$tok = strtok($map[$link],'/');
	echo '<ul class="breadcrumbs">';
	while($tok !== false){
		$ref = str_replace(' ','_',$tok);
		echo '<li><a href=./'.$ref.'>'.$tok.'</a></li>';
		$tok = strtok('/');
	}
    echo '</ul>';
}
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



	on('GET','/', function () {
	    render("main",[],false);
	});
    on('GET','/donate', function () {
        render("donate",[],false);
    });


	on('GET','/:page&=edit',function($page){
		$title = preg_replace('/\_/',' ',$page);

		if ($GLOBALS['db']->article_exists($page)){
            $content = $GLOBALS['db']->get_article($page);
			
			render("edit",['page'=>$page,'title'=>$title,'body'=>$content],false);
		}
		else {
			render("edit",['page'=>$page,'title'=>$title,'body'=>''],false);
		}
	});

	on('GET','/:page',function($page){

		
		$title = preg_replace('/\_/',' ',$page);

		if($GLOBALS['db']->article_exists($page)){
			$content = $GLOBALS['db']->get_article($page);
			$content = parse($content);
			$desc = getDesc($content,$title);
			render("list",['page'=>$page,'title'=>$title,'body'=>$content,'desc'=>$desc],false);
		}else {
			redirect('./'.$page.'&=edit');
		}
	
	});

	on('POST','/:page&=submit',function($page){
		$content = params('content');
		$GLOBALS['db']->save_article($page,$content);
		redirect('./'.$page);
	});
	

	
	dispatch();



?>



