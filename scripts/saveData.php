<?php


require '../src/db.php';

$config = parse_ini_file('../config/local_config.ini',true);
$db = new DB($config['db']);
$db->dump_db('../data/');





?>