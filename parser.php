<?php 

use \Michelf\MarkdownExtra;

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
	$str = $pre_str.preg_replace('/<h2>/','</section><br><br><section><h2>',$sub_str);
	$str = '<section>'.$str.'</section>';

	//[======]   =>     <br><hr><br>

	$str = preg_replace('/\[\=+\]/',"",$str);
	$str = preg_replace('/<h3>/','<br><hr><br><h3>',$str);


	//^^n^^
	$str = preg_replace('/\^\^([A-Za-z0-9]+?)\^\^/','<sup>$1</sup>',$str);
	
	//[[link | text]] => <ahref="./link">text</a>
	$str = preg_replace('/\[\[([A-Za-z\_\s\'\-]+?)\|([A-Za-z\_\s\'\-]+?)\]\]/','<a href="./$2">$1</a>',$str);

	//[[link]]  => <a href="./link">link</a>
	$str = preg_replace('/\[\[([A-Za-z\_\s\'\-]+?)\]\]/','<a href="./$1">$1</a>',$str);

	//<a href="one two three"></a> => <a href="one_two_three"></a>
	//$str = preg_replace('/\x20(?=[^"]*"\s*>)/','_',$str);
	$str = preg_replace('~(?>\bhref\s*=\s*["\']|\G(?<!^))[^ "\']*+\K ~','_',$str);
	//$str = preg_replace('/(?<=href\=")(?=[^"]*")/','_',$str);
	

	//$str = preg_replace('/<<<<([^>]|>(?!>>>([^>]|$)))*>>>>/,'<pre class="prettyprint linenums">$1</pre>',$str);

	

	return $str;
}

?>