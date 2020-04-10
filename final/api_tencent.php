<?php
require_once __DIR__. DIRECTORY_SEPARATOR . "class" . DIRECTORY_SEPARATOR. "http.class.php";

$http = new Http("http://api.flac.life:88");

// $respose = $http->get("/netease/song", ["id" => "37239038", "format" => 1]);

// var_dump($_REQUEST);





if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    echo "404";
    return;
}

$respose = "";


// search music api
if (isset($_GET["search"])) {
    try {
        $respose = $http->get("/tencent/search", ["keyword" => $_GET["search"], "pageSize" => $_GET["pageSize"], "page" => $_GET["page"], "type" => "song"]);
    } catch (\Throwable $th) {
        echo json_encode("params err");
        return;
    }
    echo $respose;
    return;
}


// get song play address
if (isset($_GET["song_mid"])) {
    try {
        $respose = $http->get("/tencent/url", ["id" => $_GET["song_mid"]]);
    } catch (\Throwable $th) {
        echo json_encode("params err");
        return;
    }
    echo $respose;
    return;        
}

// get song pictrue
if (isset($_GET["pic_id"])) {
    try {
        $respose = $http->get("/tencent/pic", ["id" => $_GET["pic_id"]]);
    } catch (\Throwable $th) {
        echo json_encode("params err");
        return;
    }
    echo $respose;
    return; 
}


// get song pictrue
if (isset($_GET["lrc_id"])) {
    try {
        $respose = $http->get("/tencent/lrc", ["id" => $_GET["lrc_id"]]);
    } catch (\Throwable $th) {
        echo json_encode("params err");
        return;
    }
    echo $respose;
    return; 
}




// get song information by song mid
if (isset($_GET["song_id"])) {
    try {
        $respose = $http->get("/tencent/song", ["id" => $_GET["song_id"]]);
    } catch (\Throwable $th) {
        echo json_encode("params err");
        return;
    }
    echo $respose;
    return;    
}



echo "method not exit!";