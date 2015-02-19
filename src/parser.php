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
	$str = $pre_str.preg_replace('/<h2>/','</section><section><h2>',$sub_str);
	$str = '<section>'.$str.'</section>';

	//[======]   =>     <br><hr><br>

	//$str = preg_replace('/\[\=+\]/',"",$str);
	
	//<h3> Add <hr>
	$str = preg_replace('/<h3>/','<hr><h3>',$str);

	//^^n^^
	$str = preg_replace('/\^\^([A-Za-z0-9\/]+?)\^\^/','<sup>$1</sup>',$str);
	
	//GITHUB_PATH
	$str = preg_replace('/GITHUB_PATH/','https://github.com/ayoungprogrammer/Algorithms/blob/master/src',$str);

	//$source_matches = preg_replace('/\{\{\{\{(.*?)\}\}\}\}/',

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


	// (((((article))))) -> article contents
	preg_match_all('/\({4}([A-Za-z0-9\_\-\'\s]+?)\){4}/',$str, $matches);
	foreach($matches[1] as $match){
		$page = preg_replace('/ /','_',$match);
		if($GLOBALS['db']->article_exists($page)){
			$content = parse($GLOBALS['db']->get_article($page));
			// Escape $ for preg_replace
			$content = str_replace('$','\$',$content);
			$str = preg_replace('/\({4}'.$match.'\){4}/',$content,$str);
		}else{
			echo $page." does not exist\n";
		}
	}

	// (((((article.section))))) -> article section
	preg_match_all('/\({4}([A-Za-z0-9\_\-\'\s]+?\.[A-Za-z0-9\_\-\'\s]+?)\){4}/',$str, $matches);
	foreach($matches[1] as $match){
		$split = explode('.',$match);
		$page = preg_replace('/ /','_',$split[0]);
		$section = $split[1];
		if($GLOBALS['db']->article_exists($page)){
			$content = parse($GLOBALS['db']->get_article($page));
			// Escape $ for preg_replace
			$content = str_replace('$','\$',$content);
			if(preg_match('/<section><h2>(<a.*?>)?'.$section.'(<\/a>)?<\/h2>(.*?)<\/section>/s',$content,$section_matches)>0){
				$str = preg_replace('/\({4}'.$split[0].'\.'.$section.'\){4}/',$section_matches[3],$str);
			}else{
				echo $section.'.'.$article." does not exist\n";
			}
		}else{
			echo $page." does not exist\n";
		}
	}

	//$str = preg_replace('/<<<<([^>]|>(?!>>>([^>]|$)))*>>>>/,'<pre class="prettyprint linenums">$1</pre>',$str);
	/*$str = preg_replace('/<\/section>/','</section><div class="horzadbox"><ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-3675316136020357"
             data-ad-slot="4442495028"></ins></div><script>
          (adsbygoogle = window.adsbygoogle || []).push({});
          </script>',$str,1);*/

	return $str;
}
//Generate meta description
function getDesc($content,$title){
	/*
	$searchText = '<h2>Introduction</h2>';
	$pText = '<p>';
	$preqText = 'Prereq';
	$nextText = 'Next';

	$pos = strpos($content,$searchText);
	if($pos == FALSE)return $title;
	$pos = strpos($content,$pText,$pos);
	if($pos == FALSE)return $title;
	$pos += strlen($pText);

	$preqPos = strpos($content,$preqText,$pos);
	if($preqPos != FALSE){
		$pos = $preqPos;
		$pos = strpos($content,$pText,$pos);
		if($pos == FALSE)return $title;
		$pos += strlen($pText);
	}

	$nextPos = strpos($content,$nextText,$pos);
	if($nextPos != FALSE){
		$pos = $nextPos;
		$pos = strpos($content,$pText,$pos);
		if($pos == FALSE)return $title;
		$pos += strlen($pText);
	}

	$endpos = strpos($content,'.',$pos);
	if($endpos == FALSE)return $title;*/

	preg_match('/<h2>Introduction<\/h2>.*?<p>([A-Za-z].*?\.)/s',$content,$matches);

	if(array_key_exists(1,$matches)){
		return $matches[1];
	}else{
		return $title;
	}

	return substr($content,$pos,$endpos-$pos);
}

//Generate meta tags
function getTags($content,$title){
	return $title.', data structures, algorithms, learn, computer science, handbook';
}

?>