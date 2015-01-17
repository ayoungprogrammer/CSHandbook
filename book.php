<?php

require 'vendor/autoload.php';
require 'src/parser.php';
require 'src/db.php';

function reverse($array, $start, $end){
	$mid = ($start + $end) / 2;
	for($i = $start; $i <= $mid; $i++){
		$tmp = $array[$i];
		$array[$i] = $array[$end - $i + $start];
		$array[$end - $i + $start] = $tmp;
	}
	return $array;
}

function latexParse($str){

	// <div>whatever</div> -> 
	$str = preg_replace('/<div.*?><\/div>/s','',$str);

	// <pre>code</pre> 
	$str = preg_replace('/<pre(.*?)>(.*?)<\/pre>/s','\begin{lstlisting}$2\end{lstlisting}',$str);

	// <h2>Introduction</h2> ->
	$str = preg_replace('/<h2>Introduction<\/h2>/','',$str);

	// <h0>Header</h0> -> \chapter{header}
	$str = preg_replace('/<h0>(.*?)<\/h0>/','\chapter{$1}',$str);

	// <h1>Header</h1> -> \section{header}
	$str = preg_replace('/<h1>(.*?)<\/h1>/','\section{$1}',$str);

	// <h2>header2</h2> -> \subsection{header2}
	$str = preg_replace('/<h2>(.*?)<\/h2>/','\subsection{$1}',$str);

	// <h3>header3</h3> -> \subsection{header3}
	$str = preg_replace('/<h3>(.*?)<\/h3>/','\subsubsection{$1}',$str);

	// _ -> \_
	$str = preg_replace('/_/','\_',$str);

	// $ -> \$
	$str = preg_replace('/\$/','\\\$',$str);

	// <table> ... </table> -> \begin{tabular} ... \end{tabular}
	$str = preg_replace('/<table>/','\begin{tabular}{|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l}\hline',$str);
	$str = preg_replace('/<thead>.*?<tr>/','{',$str);
	$str = preg_replace('/<\/thead>/','\hline',$str);
	$str = preg_Replace('/<\/t(d|h)>\s*<\/tr>/','\\\\\\',$str);
	$str = preg_replace('/<\/t(d|h)>/',' &',$str);
	$str = preg_replace('/<\/table>/','\hline\end{tabular}',$str);

	// <ol> ... <\ol> -> \begin{enumerate} ... \end{enumerate}
	$str = preg_replace('/<ol>/','\begin{enumerate}',$str);
	$str = preg_replace('/<\/ol>/','\end{enumerate}',$str);
	// <ul> ... <\ul> -> \begin{itemize} ... \end{itemize}
	$str = preg_replace('/<ul>/','\begin{itemize}',$str);
	$str = preg_replace('/<\/ul>/','\end{itemize}',$str);

	// <li> -> \item
	$str = preg_replace('/<li>/','\item ',$str);

	// <script>...</script> -> 
	$str = preg_replace('/<script>.*?<\/script>/s','',$str);

	// <sup>exp</sup> -> $^{exp}$
	$str = preg_replace('/<sup>(.*?)<\/sup>/','\$^{$1}\$',$str);

	// <tag> -> 
	$str = preg_replace('/<.*?>/','',$str);

	$str = str_replace(['&#42;','&gt;','&lt;','&amp;','&#124;','%'],['=','>','<','\&','|','\%'],$str);

	$tex = '\documentclass[11pt]{book}\usepackage{listings}\usepackage{outlines}\begin{document}'.$str.'\end{document}';

	return $tex;
}

function makeBook(){

	$cfg = parse_ini_file('config/local_config.ini',true);
	$head = 0;
	$end = 1;
	$queue = array();
	$map = [];

	foreach($cfg['sections'] as $section){
		$queue[$end]=$section;
		$map[$section] = 1;
		$end++;
	}
	$end--;
	$queue = reverse($queue, 1, $end);
	
	$db = new DB($cfg['db']);
	$book = '';
	while($end > 0){

		$article = $queue[$end];
		$page = $article;
		echo $article."\n";
		$page = preg_replace('/ /','_',$article);

		if($db->article_exists($page)){

			$content = $db->get_article($page);

			preg_match_all('/\[\[([A-Za-z\_\s\'\-]+?)\]\]/',$content,$matches);

			foreach ($matches[1] as $link){
				$rev = $end;
				if(!array_key_exists($link,$map)){
					$map[$link] = $map[$article]+1;
					$end++;
					$queue[$end] = $link;
				}
				$queue = reverse($queue, $rev, $end);
				/*
				for($i = $rev; $i < $end; $i++){
					$tmp = $queue[$i];
					$queue[$i] = $queue[$end-$i+$rev];
					$queue[$end-$i+$tmp];
				}*/
			}
			if($map[$article] == 1){
				$content = '<h0>'.$article.'</h0>'.parse($content);
				$content = preg_replace('/<h2>/','<h3>',$content);
				$content = preg_replace('/<\/h2>/','</h3>',$content);
			}else{
				$content = '<h1>'.$article.'</h1>'.parse($content);
			}

			$book = $book . $content;
		}
		$end--;	
	}
	file_put_contents('book/book.html',$book);

	file_put_contents('book/book.tex',latexParse($book));
}
makeBook();
?>