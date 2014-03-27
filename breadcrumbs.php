<?php
function breadcrumbs($link){
	$map = json_decode(file_get_contents('breadcrumbs.txt'),true);
	//print_r($map);
	$tok = strtok($map[$link],'/');
	echo '<ul class="breadcrumbs">';
	while($tok !== false){
		$ref = str_replace(' ','_',$tok);
		echo '<li><a href=./'.$ref.'>'.$tok.'</a></li>';
		$tok = strtok('/');
	}
    echo '</ul>';
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

			preg_match_all('/\[\[([A-Za-z\_\s\']+?)\]\]/',$content,$matches);
			//print_r($matches);
			foreach ($matches[1] as $link){
				
				if(!array_key_exists($link,$map)){

					$queue[$end] = $queue[$head].'/'.$link;
					// $queue[$end].'<br>';
					$map[str_replace(" ","_",$link)]  = $queue[$end];
					$end++;
				}
			}
		}
		$head++;
	}
	
}
?>