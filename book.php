<?php

require 'vendor/autoload.php';
require 'src/parser.php';
require 'src/db.php';

function latexParse($str){

	// <div>whatever</div> -> 
	$str = preg_replace('/<div.*?><\/div>/s','',$str);

	// <pre>code</pre> 
	$str = preg_replace('/<pre(.*?)>(.*?)<\/pre>/s','\begin{lstlisting}$2\end{lstlisting}',$str);

	$str = preg_replace('/<h2>Introduction<\/h2>/','',$str);

	$str = preg_replace('/<h1>(.*?)<\/h1>/','\chapter{$1}',$str);

	// <h2>header2</h2> -> \section{header2}
	$str = preg_replace('/<h2>(.*?)<\/h2>/','\section{$1}',$str);

	// <h3>header3</h3> -> \subsection{header3}
	$str = preg_replace('/<h3>(.*?)<\/h3>/','\subsection{$1}',$str);

	$str = preg_replace('/_/','\_',$str);

	$str = preg_replace('/\$/','\\\$',$str);


	$str = preg_replace('/&#124;/','|',$str);

	$str = preg_replace('/<sup>(.*?)<\/sup>/','\$^{$1}\$',$str);

	$str = preg_replace('/<.*?>/','',$str);

	$str = str_replace(['&#42;','&gt;','&lt;','&amp;'],['=','>','<','\&'],$str);

	// &gt; -> $>$
	//$str = preg_replace('/&gt;/','$ > $',$str);

	// &lt; -> $<$
	//$str = preg_replace('/&lt;/','$ < $',$str);
	//$str = str_replace('&lt;','<',$str);

	//$str = preg_replace('/(&|&amp;)/','\&',$str);

	// <tag> -> 


	/*

	$str = preg_replace('/<a href=.*?>.*?<\/a>/','',$str);

	$str = preg_replace('/<\/?section>/','',$str);

	$str = preg_replace('/<\/?p>/','',$str);

	$str = preg_replace('/<hr>/','',$str);

	$str = preg_replace('/<\/h(2|3)>','',$str);*/

	$tex = '\documentclass[11pt]{book}\usepackage{listings}\usepackage{outlines}\begin{document}'.$str.'\end{document}';

	return $tex;
}

function makeBook(){

	$cfg = parse_ini_file('config/local_config.ini',true);
	$head = 0;
	$end = 0;
	$queue = array();
	$map = [];

	foreach($cfg['sections'] as $section){
		$queue[$end]=$section;
		$map[$section] = 1;
		$end++;
	}
	
	$db = new DB($cfg['db']);
	$book = '';
	
	while($head < $end){

		$article = $queue[$head];
		$page = $article;
		echo $article."\n";
		$page = preg_replace('/ /','_',$article);

		if($db->article_exists($page)){

			$content = $db->get_article($page);

			preg_match_all('/\[\[([A-Za-z\_\s\'\-]+?)\]\]/',$content,$matches);

			foreach ($matches[1] as $link){
				
				if(!array_key_exists($link,$map)){
					$map[$link] = 1;
					$queue[$end] = $link;
					$end++;
				}
			}

			$content = '<h1>'.$page.'</h1>'.parse($content);

			$book = $book . $content;
		}
		$head++;	
	}
	file_put_contents('book/book.html',$book);

	file_put_contents('book/book.tex',latexParse($book));
}
makeBook();
?>