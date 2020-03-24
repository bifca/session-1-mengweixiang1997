<?php
declare (strict_types = 1);
require_once __DIR__ . DS . ".." .DS."vendor" . DS . "autoload.php";


/**
 * load .env configuration
 * @param string $path .env file path
 */
function loadConfig(string $path):void{
    $dotenv = \Dotenv\Dotenv::createImmutable($path);
    $dotenv->load();
}


