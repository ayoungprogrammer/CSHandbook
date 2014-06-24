<?php

class DB{


    private $mysqli;

    public function __construct($config){

        $user = $config['user'];
        $password = $config['password'];
        $db = $config['database'];
        $host = $config['host'];

        $this->mysqli = new mysqli($host,$user,$password);
        $this->mysqli->select_db($db);

    }

    /*
    Returns if article $page exists
    */
    function article_exists($page){
        $stmt = $this->mysqli->prepare('SELECT id FROM articles WHERE id= ?');
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
        $stmt = $this->mysqli->prepare('SELECT content from articles where id= ?');
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
        $stmt = $this->mysqli->prepare(
        	    "INSERT INTO articles (id,content)
    			VALUES (?,?)
    			ON DUPLICATE KEY UPDATE
    			   content = VALUES(content)");
        $stmt->bind_param('ss',$page,$content);
        $stmt->execute();
        $stmt->close();

    }

    function dump_db($base_path){

        $res = $this->mysqli->query("SELECT * FROM articles");
        while ($row = mysqli_fetch_array($res)){
            $path = $base_path.$row['id'].'.txt';
            echo $row['id']."\n" ;
            file_put_contents($path,$row['content']);
        }

    }
}

?>