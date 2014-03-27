<?php

require 'db_init.php';

$mysqli = new mysqli($host,$user,$password);
$mysqli->select_db($db);

/*
Returns if article $page exists
*/
function article_exists($page){
    global $mysqli;
    $stmt = $mysqli->prepare('SELECT id FROM articles WHERE id= ?');
    $stmt->bind_param('s',$page);
    $stmt->execute();
   	$stmt->bind_result($res);
   	$stmt->fetch();
   	$stmt->close();
    if($res)return true;
    return false;
}

/*
PRE: article $page exists
returns content of article
*/
function get_article($page){
    global $mysqli;
    $stmt = $mysqli->prepare('SELECT content from articles where id= ?');
    $stmt->bind_param('s',$page);
    $stmt->execute();
    $stmt->bind_result($res);
    $stmt->fetch();
    $stmt->close();
    return $res;
}

/*
PRE: article $page can exist or not exist
POST: article $page is saved with $content
*/
function save_article($page,$content){
    global $mysqli;
    $stmt = $mysqli->prepare(
    	    "INSERT INTO articles (id,content)
			VALUES (?,?)
			ON DUPLICATE KEY UPDATE
			   content = VALUES(content)");
    $stmt->bind_param('ss',$page,$content);
    $stmt->execute();
    $stmt->close();

}


?>