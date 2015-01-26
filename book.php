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

	// Source on Github -> 
	$str = preg_replace('/Source on GitHub/','',$str);

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

	// <img src = "\.\/pubicsrc">
	$str = preg_replace('/<img src="\.\/public_html\/img\/uploads\/(.*?)">/',
		'\includegraphics[width=\maxwidth{\textwidth}]{$1}',$str);

	// _ -> \_
	$str = preg_replace('/_/','\_',$str);

	$str = preg_replace('/\\\\includegraphics\\[width=\\\\maxwidth{\\\\textwidth}\\]{(.*?)\\\\_(.*?)}/',
		'\includegraphics[width=\maxwidth{\textwidth}]{$1_$2}',$str);

	// $ -> \$
	$str = preg_replace('/\$/','\\\$',$str);

	// <table> ... </table> -> \begin{tabular} ... \end{tabular}
	$str = preg_replace('/<table>/','\vspace{10pt} \begin{tabulary}{0.4\linewidth}{|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l}\hline',$str);
	$str = preg_replace('/<thead>.*?<tr>/','{',$str);
	$str = preg_replace('/<\/thead>/','\hline',$str);
	$str = preg_replace('/<\/t(d|h)>\s*<\/tr>/','\\\\\\',$str);
	$str = preg_replace('/<\/t(d|h)>/',' &',$str);
	$str = preg_replace('/<\/table>/','\hline\end{tabulary}',$str);

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

	$str = str_replace(['&#42;','&gt;','&lt;','&amp;','&#124;','%'],['=','$>$','$<$','\&','$|$','\%'],$str);
	/*
	$str = preg_replace_callback(
		'/\\\\begin{lstlisting}.*?\\\\end{lstlisting}/s',
		function($matches){
			$ret = preg_replace('/\$<\$/','<',$matches[0]);
			$ret = preg_replace('/\$>\$/','>',$ret);
			$ret = preg_replace('/\\\_/','_',$ret);
			return $ret;
		},
		$str
	);*/


	$tex = '\documentclass[11pt,oneside]{book}
		\usepackage{listings}
		\usepackage{outlines}
		\usepackage{graphicx}
		\usepackage{tabulary}
		\usepackage{color}
		\usepackage[numbered]{bookmark}

		\title{The Computer Science Handbook}
		\author{Michael Young}

		\definecolor{dkgreen}{rgb}{0,0.6,0}
		\definecolor{gray}{rgb}{0.5,0.5,0.5}
		\definecolor{mauve}{rgb}{0.58,0,0.82}
		\lstset{
		  language=Java,
		  aboveskip=3mm,
		  belowskip=3mm,
		  showstringspaces=false,
		  columns=flexible,
		  basicstyle={\small\ttfamily},
		  numbers=none,
		  numberstyle=\tiny\color{gray},
		  keywordstyle=\color{blue},
		  commentstyle=\color{dkgreen},
		  stringstyle=\color{mauve},
		  breaklines=true,
		  breakatwhitespace=true,
		  tabsize=3
		}
		\graphicspath{ {../public_html/img/uploads/} }
		\makeatletter
		\def\maxwidth#1{\ifdim\Gin@nat@width>#1 #1\else\Gin@nat@width\fi}
		\begin{document}
		\maketitle
		\tableofcontents
		'.$str.'\end{document}';

	return $tex;
}


function makeManifest(){

	$manifest = file_get_contents('manifest.txt');

	$manifest = preg_replace('/``(.+?)``/', '\section{$1}', $manifest);
	$manifest = preg_replace('/`(.+?)`/', '\chapter{$1}', $manifest);
	$manifest = preg_replace('/~(.+?)~/', '\part{$1}', $manifest);

	$book = parse($manifest);


	file_put_contents('book/book.html',$book);

	file_put_contents('book/book.tex',latexParse($book));
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

			$rev = $end;
			foreach ($matches[1] as $link){
				if(!array_key_exists($link,$map) && $map[$article]<2){
					$map[$link] = $map[$article]+1;
					$end++;
					$queue[$end] = $link;
				}
			}
			$queue = reverse($queue, $rev, $end);
			if($map[$article] == 1){
				$content = parse($content);
				preg_match('/<section>.*?<\/section>/s',$content,$matches);
				//print_r($matches);
				$content = $matches[0];
				$content = '<h0>'.$article.'</h0>'.$content;
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

$cfg = parse_ini_file('config/local_config.ini',true);
$db = new DB($cfg['db']);

makeManifest();
?>