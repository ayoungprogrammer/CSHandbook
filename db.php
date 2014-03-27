<?php


$user = "root";
$password = "";


$mysqli = new mysqli("localhost",$user,$password,"algorithms");

/*
Returns if article $page exists
*/
function article_exists($page){
    global $mysqli;
    return true;
    $content = $mysqli->prepare('SELECT id FROM articles WHERE id= :page');
    return ($content->num_rows > 0);
}

/*
PRE: article $page exists
returns content of article
*/
function get_article($page){
    global $mysqli;
    $content = $mysqli->query('SELECT content from articles where id="'.$page.'"');
    $content = mysqli_fetch_array($content);
    return $content[0];
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