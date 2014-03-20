<?php
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';

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

function breadcrumbs($link){
	$map = json_decode(file_get_contents('breadcrumbs.txt'),true);
	//print_r($map);
	$tok = strtok($map[$link],'/');
	echo '<p id="breadcrumbs">';
	while($tok !== false){
		$ref = str_replace(' ','_',$tok);
		echo '<a href=./'.$ref.'>'.$tok.'</a>';
		$tok = strtok('/');
	}
}

function bfsLinks(){

	//preg_match_all("/a/","aaaa",$matches,PREG_OFFSET_CAPTURE,1);
	//print_r($matches);

	$head = 0;
	$end = 0;
	$queue = array();
	foreach($GLOBALS['sections'] as $section){
		$queue[$end]='/'.$section;
		$map[str_replace(' ','_',$section)] = $queue[$end];
		$end++;
	}
	
	while($head < $end){
		

		//echo 'pre'.$queue[$head].'<br>';

		$page = substr($queue[$head],strrpos($queue[$head],'/')+1);

		
		//echo 'suf'.$page.'<br>';

		$path = 'data/'.$page.'.txt';
		$path = str_replace(" ","_",$path);

		//echo $path.'<br>';


		
		if(file_exists($path)){
			$content = file_get_contents($path);

			preg_match_all('/\[\[([A-Za-z\_\s]*?)\]\]/',$content,$matches);
			//print_r($matches);
			foreach ($matches[1] as $link){
				
				if(!$map[$link]){

					$queue[$end] = $queue[$head].'/'.$link;
					// $queue[$end].'<br>';
					$map[str_replace(" ","_",$link)]  = $queue[$end];
					$end++;
				}
			}
		}
		$head++;
	}
	file_put_contents('breadcrumbs.txt',json_encode($map));
	foreach ($map as $link){
		echo $link.'<br>';
	}
	print_r($map);
}

function parse($str){

	// < > -> &lt; , %gt;

	//$str = preg_replace('/</','&lt;',$str);
	//$str = preg_replace('/>/','&gt;',$str);
	$str = htmlspecialchars($str,ENT_NOQUOTES);

	//<<<<CODE>>>> => <pre class="prettyprint linenums">CODE</pre>
	$str = preg_replace('/\[{4}([\s\S]*?)\]{4}/','<pre class="prettyprint linenums">$1</pre>',$str);

	//Apply markdown
	$str = MarkdownExtra::defaultTransform($str);
	
	//[[==================]]
	$str = preg_replace('/\[\[\=+\]\]/',"",$str);

	$first_h3 = strpos('<h2>',$str);
	$pre_str = substr($str,0,$first_h3+4);
	$sub_str = substr($str,$first_h3+4);
	$str = $pre_str.preg_replace('/<h2>/','</section><br><hr><br><section><h2>',$sub_str);
	$str = '<section>'.$str.'</section>';

	//[======]   =>     <br><hr><br>

	$str = preg_replace('/\[\=+\]/',"",$str);
	$str = preg_replace('/<h3>/','<br><hr><br><h3>',$str);


	//^^n^^
	$str = preg_replace('/\^\^([A-Za-z0-9]+?)\^\^/','<sup>$1</sup>',$str);
	

	//[[link]]  => <a href="./link">link</a>
	$str = preg_replace('/\[\[([A-Za-z\_\s\']+?)\]\]/','<a href="./$1">$1</a>',$str);

	//<a href="one two three"></a> => <a href="one_two_three"></a>
	//$str = preg_replace('/\x20(?=[^"]*"\s*>)/','_',$str);
	$str = preg_replace('~(?>\bhref\s*=\s*["\']|\G(?<!^))[^ "\']*+\K ~','_',$str);
	//$str = preg_replace('/(?<=href\=")(?=[^"]*")/','_',$str);
	

	//$str = preg_replace('/<<<<([^>]|>(?!>>>([^>]|$)))*>>>>/,'<pre class="prettyprint linenums">$1</pre>',$str);

	

	return $str;
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


	on('GET','/links',function($page){
		bfsLinks('/Topics');
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

		$path  = 'data/'.$page.'.txt';
		$title = preg_replace('/\_/',' ',$page);

		if (file_exists($path)){
			$content = file_get_contents($path);
			$content = parse($content);

			render("list",['page'=>$page,'title'=>$title,'body'=>$content],false);
		}
		else {
			redirect('./'.$page.'&=edit');
		}
	
	});

	on('POST','/:page&=submit',function($page){
		$path  = 'data/'.$page.'.txt';
		file_put_contents($path, params('content'));
		redirect('./'.$page);
	});
	

	
	
	dispatch();



?>



