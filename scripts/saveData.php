<?php


require '../src/db.php';

$config = parse_ini_file('../config/local_config.ini');
$db = new DB($config);
$db->dump_db('../data/');





?>