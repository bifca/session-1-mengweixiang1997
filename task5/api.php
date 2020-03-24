<?php
declare (strict_types = 1);
require_once __DIR__ .DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."class" . DIRECTORY_SEPARATOR . "DB.class.php";

use GuzzleHttp\Client;

// Must post request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $result = [
        "code" => -1,
        "msg"  => "Only Post request",
    ];    
    echo json_encode($result);
    return;
}


/**
 * Search music API
 * @method post
 * @param key {key words}
 * @param page {which page?}
 */
if (isset($_POST["key"]) && !empty($_POST["key"])) {
    $key = (string)$_POST["key"];
    $page = isset($_POST["page"]) && !empty($_POST["page"]) ? $_POST["page"] : 0;

    $client = new Client([
        'base_uri' => 'https://v1.itooi.cn/netease/', // Base URI is used with relative requests
        'verify'   => false,                          // Skip https
    ]);
    $response   = $client->request('GET', 'search?keyword='. $key .'&type=song&pageSize=20&page=' . $page);
    echo $response->getBody();
    return;
}


/**
 * Get music play address
 * @method post
 * @param play_id {lyrcs id}
 */
if (isset($_POST["play_id"]) && !empty($_POST["play_id"])) {
    $id = (int)$_POST["play_id"];

    $client = new Client([
        'base_uri' => 'https://v1.itooi.cn/netease/', // Base URI is used with relative requests
        'verify'   => false,                          // Skip https
    ]);
    $response   = $client->request('GET', 'url?id='.$id.'&quality=flac');
    echo $response->getBody();
    return;
}


/**
 * Get music information
 * @method post
 * @param play_id {lyrcs id}
 */
if (isset($_POST["info_id"]) && !empty($_POST["info_id"])) {
    $id = (int)$_POST["info_id"];

    $client = new Client([
        'base_uri' => 'https://v1.itooi.cn/netease/', // Base URI is used with relative requests
        'verify'   => false,                          // Skip https
    ]);
    $response   = $client->request('GET', 'song?id='.$id);
    echo $response->getBody();
    return;
}


/**
 * Get musics information
 * @method post
 * @param play_id {lyrcs id}
 */
if (isset($_POST["info_ids"]) && !empty($_POST["info_ids"])) {
    $ids = (string)$_POST["info_ids"];

    $client = new Client([
        'base_uri' => 'https://v1.itooi.cn/netease/', // Base URI is used with relative requests
        'verify'   => false,                          // Skip https
    ]);
    $response   = $client->request('GET', 'song?id='.$ids);
    echo $response->getBody();
    return;
}








/**
 * Get my favorite music
 * @method post
 * @param get_favo {}
 */
if (isset($_POST["get_favo"]) && !empty($_POST["get_favo"])) {

    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $db = new DB($_ENV["DB_HOST"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_DATABASE"]);

    $arr = $db->getList("favorite");
    echo json_encode($arr);
    return;
}


