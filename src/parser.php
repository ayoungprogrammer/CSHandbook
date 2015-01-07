<?php 

use \Michelf\MarkdownExtra;

function parse($str){

	// < > -> &lt; , %gt;

	//$str = preg_replace('/</','&lt;',$str);
	//$str = preg_replace('/>/','&gt;',$str);
	$str = htmlspecialchars($str,ENT_NOQUOTES);

	//[[[[{lang}CODE]]]] => <pre class="prettyprint linenums lang">CODE</pre>
	$str = preg_replace('/\[{4}(\{([\s\S]*?)\})?([\s\S]*?)\]{4}/','<pre class="prettyprint linenums $2">$3</pre>',$str);

	//Apply markdown
	$str = MarkdownExtra::defaultTransform($str);
	
	//[[==================]]
	//$str = preg_replace('/\[\[\=+\]\]/',"",$str);

	$first_h3 = strpos('<h2>',$str);
	$pre_str = substr($str,0,$first_h3+4);
	$sub_str = substr($str,$first_h3+4);
	$str = $pre_str.preg_replace('/<h2>/','</section><br><br><section><h2>',$sub_str);
	$str = '<section>'.$str.'</section>';

	//[======]   =>     <br><hr><br>

	//$str = preg_replace('/\[\=+\]/',"",$str);
	
	//<h3> Add <hr>
	$str = preg_replace('/<h3>/','<hr><h3>',$str);


	//^^n^^
	$str = preg_replace('/\^\^([A-Za-z0-9\/]+?)\^\^/','<sup>$1</sup>',$str);
	
	//GITHUB_PATH
	$str = preg_replace('/GITHUB_PATH/','https://github.com/ayoungprogrammer/Algorithms/blob/master/src',$str);

	//Abs link
	//[[text || abs_link]] => <a href="abs_link>text</a>"
	$str = preg_replace('/\[\[([A-Za-z\_\s\'\-]+?)\|\|([A-Za-z\_\s\'\-\/\.\:]+?)\]\]/','<a href="$2" target="_blank">$1</a>',$str);

	//Rel link
	//[[text | link]] => <a href="./link">text</a>
	$str = preg_replace('/\[\[([A-Za-z\_\s\'\-]+?)\|([A-Za-z\_\s\'\-]+?)\]\]/','<a href="./$2" target="_blank">$1</a>',$str);

	//[[link]]  => <a href="./link">link</a>
	$str = preg_replace('/\[\[([A-Za-z\_\s\'\-]+?)\]\]/','<a href="./$1" target="_blank">$1</a>',$str);

	//<a href="one two three"></a> => <a href="one_two_three"></a>
	//$str = preg_replace('/\x20(?=[^"]*"\s*>)/','_',$str);
	$str = preg_replace('~(?>\bhref\s*=\s*["\']|\G(?<!^))[^ "\']*+\K ~','_',$str);
	//$str = preg_replace('/(?<=href\=")(?=[^"]*")/','_',$str);
	
	//{{img_url}} => <img src="./public_html/img/uploads/img_url"
	$str = preg_replace('/\{\{([A-Za-z0-9\_\-\.]+?)\}\}/','<img src="./public_html/img/uploads/$1">',$str);

	//$str = preg_replace('/<<<<([^>]|>(?!>>>([^>]|$)))*>>>>/,'<pre class="prettyprint linenums">$1</pre>',$str);

	

	return $str;
}
//Generate meta description
function getDesc($content,$title){

	$searchText = '<h2>Introduction</h2>';
	$pText = '<p>';
	$pos = strpos($content,$searchText);
	if($pos == FALSE)return $title;
	$pos = strpos($content,$pText,$pos);
	if($pos == FALSE)return $title;
	$pos += strlen($pText);
	$endpos = strpos($content,'.',$pos);
	if($endpos == FALSE)return $title;
	return substr($content,$pos,$endpos-$pos);
}

//Generate meta tags
function getTags($content,$title){
	return $title.', data structures, algorithms';
}

?>