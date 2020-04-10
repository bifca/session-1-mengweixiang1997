<?php
require_once "common.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "404";
    return;
}

// Get uid from $_COOKIE;
try {
    // validate token
    $token = verification($_COOKIE["music_token"]);
} catch (\Throwable $th) {
    $res = [
        "code" => -1,
        "msg"  => "invalid token",
        "data" => "",
    ];
    echo json_encode($res);
    return;
}
$uid = $token["data"]->uid;



/**
 * get user liked list
 * @method POST
 * @param get_list
 * @param sign
 */
if (isset($_POST["get_list"])) {
    // get data
    echo json_encode($db->getUserLikedList($uid));
    return;
}


/**
 * Add liked music;
 * @method POST
 * @param mid song's mid
 * @param type actions type 1 means add, 0 means cancel
 */
if (isset($_POST["mid"])  && isset($_POST["type"]) && (int)$_POST["type"] === 1) {
    $db->addLikedMusic($uid, $_POST["mid"]);

    $arr = [
        "code" => 1,
        "msg"  => "success"
    ];
    echo json_encode($arr);
    return;
}


/**
 * Cancel liked music;
 * @method POST
 * @param mid song's mid
 * @param type actions type 1 means add, 0 means cancel
 */
if (isset($_POST["mid"])  && isset($_POST["type"]) && (int)$_POST["type"] === 0) {
    $db->cancelLikedMusic($uid, $_POST["mid"]);

    $arr = [
        "code" => 1,
        "msg"  => "success"
    ];
    echo json_encode($arr);
    return;
}




echo "missing params";