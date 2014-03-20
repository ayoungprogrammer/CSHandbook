<?php
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';

use \Michelf\MarkdownExtra;


function bfsLinks($map,$current_path){
	$head = 0;
	$end = 1;
	$queue = array(0=>'/topics');
	$map = array('/topics'=>'/');
	while($head < $end){
		
		$page = substr($queue[$head],strrchr($queue[$head],'/'));
		
		if(file_exists($page)){
			$content = file_get_contents($page);
			preg_match('/\[\[([\s\S]*)\]\]/',$content,$matches);
			foreach ($matches as $link){
				if($map[$link]){
					$queue[$end] = $queue[$head].$link;
					$map[$link]  = $queue[$end];
					$end++;
				}
			}
		}
		$head++;
	}
	echo $map;
}

function parse($str){

	// < > -> &lt; , %gt;

	//$str = preg_replace('/</','&lt;',$str);
	//$str = preg_replace('/>/','&gt;',$str);
	$str = htmlspecialchars($str,ENT_NOQUOTES);

	//<<<<CODE>>>> => <pre class="prettyprint linenums">CODE</pre>
	$str = preg_replace('/\[{4}([\s\S]*)\]{4}/','<pre class="prettyprint linenums">$1</pre>',$str);

	//Apply markdown
	$str = MarkdownExtra::defaultTransform($str);
	
	//[[==================]]
	$str = preg_replace('/\[\[\=+\]\]/',"</article><article>",$str);
	$str = '<article>'.$str.'</article>';

	//[======]   =>     <br><hr><br>
	$str = preg_replace('/\[\=+\]/',"<br><hr><br>",$str);

	

	//[[link]]  => <a href="./link">link</a>
	$str = preg_replace('/\[\[([A-Za-z\_\s\']+)\]\]/','<a href="./$1">$1</a>',$str);

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



