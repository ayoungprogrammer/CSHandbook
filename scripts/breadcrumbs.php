<?php


require "../src/db.php";

$sections = array(
	'Data Structures',
	'Sorting',
	'Geometry',
	'Graph Theory',
	'Number Theory',
	'Pattern Matching',
	'Searches',
	'Dynamic Programming'
	);

function bfsLinks(){

	$head = 0;
	$end = 0;
	$queue = array();
	foreach($GLOBALS['sections'] as $section){
		$queue[$end]='/'.$section;
		$map[str_replace(' ','_',$section)] = $queue[$end];
		$end++;
	}

	$db = new DB('../config/local_config.ini');
	
	while($head < $end){
		

		$page = substr($queue[$head],strrpos($queue[$head],'/')+1);
		$article = str_replace(" ","_",$page);

		if($db->article_exists($article)){
			$content = $db->get_article($article);

			preg_match_all('/\[\[([A-Za-z\_\s\'\-]+?)\]\]/',$content,$matches);

			foreach ($matches[1] as $link){

				$new_link = str_replace(" ","_",$link);
				
				if(!array_key_exists($new_link,$map)){

					$queue[$end] = $queue[$head].'/'.$link;
					$map[$new_link]  = $queue[$end];
					$end++;
				}
			}
			preg_match_all('/\[\[([A-Za-z\_\s\']+?)\|([A-Za-z\_\s\']+?)\]\]/',$content,$matches);

			foreach ($matches[2] as $link){
				
				$new_link = str_replace(" ","_",$link);
				
				if(!array_key_exists($new_link,$map)){

					$queue[$end] = $queue[$head].'/'.$link;
					$map[$new_link]  = $queue[$end];
					$end++;
				}
			}
		}
		$head++;
		
	}
	print_r($map);
	file_put_contents('../data/breadcrumbs.txt',json_encode($map));
	return $map;
}

bfsLinks();
?>