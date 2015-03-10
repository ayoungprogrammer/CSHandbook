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
	$str = preg_replace('/Source on Git(H|h)ub/','',$str);

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

	// <img src = "\.\/public_html....."> -> \includegraphics
	$str = preg_replace('/<img src="\.\/public_html\/img\/uploads\/(.*?)">/',
		'\vspace{5px}\includegraphics[width=\maxwidth{\textwidth}]{$1}',$str);

	// _ -> \_
	$str = preg_replace('/_/','\_',$str);

	$str = preg_replace('/\\\\includegraphics\\[width=\\\\maxwidth{\\\\textwidth}\\]{(.*?)\\\\_(.*?)}/',
		'\includegraphics[width=\maxwidth{\textwidth}]{$1_$2}',$str);

	// $ -> \$
	$str = preg_replace('/\$/','\\\$',$str);

	// <table> ... </table> -> \begin{tabular} ... \end{tabular}
	$str = preg_replace('/<table>/','\vspace{10px}\begin{tabulary}{0.4\linewidth}{|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l|l}\hline',$str);
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
	$str = preg_replace('/<sup>(.*?)<\/sup>/', '\$^{$1}\$', $str);

	// <sub>base</sub> -> $_{base}$
	$str = preg_replace('/<sub>(.*?)<\/sub>/', '\$_{$1}\$', $str);

	// <tag> -> 
	$str = preg_replace('/<.*?>/','',$str);

	//HTML special chars, escape
	$str = str_replace(['&#42;','&gt;','&lt;','&amp;','&#124;','%'],['=','$>$','$<$','\&','$|$','\%'],$str);
	
	// \begin{lstlisting} $<$, $>$, \_, \%, \end{lstlisting} -> no escape
	$str = preg_replace_callback(
		'/\\\\begin{lstlisting}.*?\\\\end{lstlisting}/s',
		function($matches){
			// $<$ -> <
			$ret = preg_replace('/\$<\$/','<',$matches[0]);
			// $>$ -> >
			$ret = preg_replace('/\$>\$/','>',$ret);
			// \_ -> _
			$ret = preg_replace('/\\\_/','_',$ret);
			$ret = preg_replace('/\\\%/','%',$ret);
			// \& -> &
			$ret = preg_replace('/\\\&/','&',$ret);
			return $ret;
		},
		$str
	);


	$tex = '\documentclass[11pt,oneside]{book}
		\usepackage{listings}
		\usepackage{outlines}
		\usepackage{graphicx}
		\usepackage{tabulary}
		\usepackage{color}
		\usepackage[numbered]{bookmark}
		\usepackage[paperwidth=6.125in, paperheight=9.250in]{geometry}

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
		\frontmatter
		\topskip0pt
		\vspace*{\fill}
		\begin{center}
			Thanks to: \\
			Dr. Yuli Ye, for teaching me\\
			Gord Ridout, for encouraging me to make this book\\
		\end{center}
		\vspace*{\fill}
		
		\mainmatter
		
		\topskip0pt
		\vspace*{\fill}
		\begin{center}
		\LARGE\textsf{The Computer Science Handbook}\par
		\end{center}
		\begin{center}
		\textsf{By: Michael Young}\par
		\end{center}
		\vspace*{\fill}

		\tableofcontents
		'.$str.'\newpage\null\thispagestyle{empty}\newpage';

	return $tex;
}


function getExercises(){
	$output = '';
	foreach($GLOBALS['map'] as $page => $path){
		
		if(!$GLOBALS['db']->article_exists($page)){
			continue;
		}

		$title = preg_replace('/\_/',' ',$page);

		$contents = $GLOBALS['db']->get_article($page);
		$contents = parse($contents);

		$res = preg_match('/<section><h2>Exercises<\/h2>(.*)<\/section>/is',$contents,$matches);

		if($res){
			$output = $output.'<b>'.$title.'</b>'.$matches[1];
		}

	}
	return $output;
}

function makeManifest(){

	$manifest = file_get_contents('manifest.txt');

	$manifest = preg_replace('/``(.+?)``/', '\section{$1}', $manifest);
	$manifest = preg_replace('/`(.+?)`/', '\chapter{$1}', $manifest);
	$manifest = preg_replace('/~(.+?)~/', '\part{$1}', $manifest);

	$book = parse($manifest);

	//$book = str_replace('Exercises', getExercises(), $book);

	file_put_contents('book/book.html',$book);

	file_put_contents('book/book.tex',latexParse($book));
}



$cfg = parse_ini_file('config/local_config.ini',true);
$db = new DB($cfg['db']);
$crumbs = file_get_contents('./data/breadcrumbs.txt');
$map = json_decode($crumbs,true);

makeManifest();
?>