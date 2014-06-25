<?php
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';
require 'src/parser.php';
require 'src/db.php';

$cfg = parse_ini_file('./config/local_config.ini',true);

$db = new DB($cfg['db']);


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
    on('GET','/donate', function () {
        render("donate",[],false);
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
			render("list",['page'=>$page,'title'=>$title,'body'=>$content,'desc'=>$desc],false);
		}else {
			//Edit for stage
			if($GLOBALS['cfg']['env']=='stage'){
				redirect('./'.$page.'&=edit');
			}else {
				redirect('/');
			}
			
		}
	
	});

	

	
	dispatch();



?>



