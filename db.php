<?php


$user = "root";
$password = "";


$mysqli = new mysqli("localhost",$user,$password);

/*
Returns if article $page exists
*/
function article_exists($page){
    global $mysqli;
    if ($mysqli->query('SELECT id from articles where id="$page"')>0){
        return false;
    }
    return true;
}

/*
PRE: article $page exists
returns content of article
*/
function get_article($page){
    global $mysqli;
    $content = $mysqli->query('SELECT content from articles where id="$page"');
    return $content;
}

/*
PRE: article $page can exist or not exist
POST: article $page is saved with $content
*/
function save_article($page,$content){
    global $mysqli;
    $mysqli->query("INSERT INTO articles (id,content)
			VALUES ('".$page."','".$content."')");
}


?>