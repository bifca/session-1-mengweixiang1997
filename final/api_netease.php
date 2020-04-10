<?php
require_once __DIR__. DIRECTORY_SEPARATOR . "class" . DIRECTORY_SEPARATOR. "http.class.php";
require_once "common.php";


$http = new Http("http://api.flac.life:88");

// $respose = $http->get("/netease/song", ["id" => "37239038", "format" => 1]);

// var_dump($_REQUEST);


if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    echo "404";
    return;
}

$respose = "";



/**
 * Search music API
 * @method post
 * @param key {key words}
 * @param page {which page?}
 */
if (isset($_GET["search"])) {
    try {
        $respose = $http->get("/netease/search", ["keyword" => $_GET["search"], "pageSize" => $_GET["pageSize"], "page" => $_GET["page"], "type" => "song"]);
    } catch (\Throwable $th) {
        echo json_encode("params err");
        return;
    }
    echo $respose;
    return;
}




/**
 * Get music play address
 * @method post
 * @param play_id
 */
if (isset($_GET["play_id"])) {
    try {
        $respose = $http->get("/netease/url", ["id" => $_GET["play_id"], "quality" => "flac"]);
    } catch (\Throwable $th) {
        echo json_encode("params err");
        return;
    }
    echo $respose;
    return;
}


/**
 * Get music information
 * @method post
 * @param info_id
 */
if (isset($_GET["info_id"])) {
    try {
        $respose = $http->get("/netease/song", ["id" => $_GET["info_id"]]);
    } catch (\Throwable $th) {
        echo json_encode("params err");
        return;
    }
    echo $respose;
    return;
}

/**
 * Get music lyrcs
 * @method post
 * @param lrc_id {lyrcs id}
 */
if (isset($_GET["lrc_id"]) && !empty($_GET["lrc_id"])) {
    try {
        $respose = $http->get("/netease/lrc", ["id" => $_GET["lrc_id"]]);
    } catch (\Throwable $th) {
        echo json_encode("params err");
        return;
    }
    echo $respose;
    return;

}


