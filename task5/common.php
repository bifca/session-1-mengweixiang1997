<?php
define("DS", DIRECTORY_SEPARATOR);
// require_once __DIR__ . DS ."vendor" . DS . "autoload.php";
require_once __DIR__ . DS ."class" . DS . "DB.class.php";
require_once __DIR__ . DS ."func" . DS . "main.func.php";


// $db = new DB();
$res = loadConfig(__DIR__);

$db = new DB($_ENV["DB_HOST"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_DATABASE"]);


