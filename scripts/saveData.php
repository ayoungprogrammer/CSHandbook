<?php


require '../src/db.php';

$db = new DB('../config/local_config.ini');
$db->dump_db('../data/');





?>