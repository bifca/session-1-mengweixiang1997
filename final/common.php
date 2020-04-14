<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "class". DIRECTORY_SEPARATOR . "db.class.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "func". DIRECTORY_SEPARATOR . "main.func.php";

// initialize DB class;
$db = new DB("localhost", "root", "123456", "s1624230229");



$path = explode("/", $_SERVER["PHP_SELF"]);
$file = $path[count($path) - 1];

$whiteList = [
    "sign_up.php", "login.php", "api_user.php"
];

array_pop($path); // get root path;1
$landing = implode("/", $path) . "/login.php"; // loading page url;
$indexPage = implode("/", $path) . "/index.php"; // loading page url;

// Is not in white list?
if(!in_array($file, $whiteList)){
    // if user dont have cookies
    if (!isset($_COOKIE["music_token"])) {
        header("Location: " . $landing);
    }
    try {
        // validate token
        verification($_COOKIE["music_token"]);
    } catch (\Throwable $th) {
        unset($_COOKIE["music_token"]);
        header("Location: " . $landing);
    }
    return;
}

// user with cookies in white list page
if (isset($_COOKIE["music_token"])) {
    try {
        // validate token
        verification($_COOKIE["music_token"]);
    } catch (\Throwable $th) {
        unset($_COOKIE["music_token"]);
        return;
    }
    header("Location: " . $indexPage);
    return;    
}