<?php

$data_dir = '../public_html/img/raw/';
$output_dir = '../public_html/img/uploads/';

shell_exec("rm -rf ".$output_dir);
shell_exec("mkdir ".$output_dir);

$dir = new DirectoryIterator($data_dir);
foreach($dir as $fileinfo){

	if($fileinfo->isDot())continue;

	$name = $fileinfo->getFilename();

	$src = $data_dir.$name;
	$output = $output_dir.$name;

	if($fileinfo->getExtension()=='png'){
		echo "Converting: ".$name."\n";
		$command = sprintf("convert %s -filter Catrom -density 3000000 %s", $src, $output);
		shell_exec($command);
	} else{
		echo "Copying: ".$name."\n";
		$command = sprintf("cp %s %s", $src, $output);
		shell_exec($command);
	}
}
