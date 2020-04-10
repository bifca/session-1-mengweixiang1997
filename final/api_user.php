<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "validate" . DIRECTORY_SEPARATOR. "user.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "func" . DIRECTORY_SEPARATOR . "main.func.php";
require_once "common.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "404";
    return;
}


/**
 * handle sign up
 * @method POST
 * @param email
 * @param password
 * @param sign
 */
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["sign"])) {
    $data = [
        'email'    => $_POST["email"],
        'password' => $_POST["password"],
    ];
    // inintialize validate User object
    $validate = new \validate\User;

    // validate sign_up request data
    if (!$validate->check($data)) {
        $res = [
            "code" => -1,
            "msg"  => $validate->getError(),
            "data" => "",
        ];
        echo json_encode($res); // response json
        return;
    }

    // Mailbox does not exist
    $info = $db->getUserByEmail($_POST["email"]);
    if (count($info) !== 0) {
        $res = [
            "code" => -1,
            "msg"  => "Mailbox duplicate!",
            "data" => "",
        ];
        echo json_encode($res); // response json
        return;        
    }

    $pk = $db->addUser($_POST["email"], $_POST["password"]);
    $res = [
        "code" => 1,
        "msg"  => "Register success!",
        "data" => Issue($pk),
    ];
    echo json_encode($res); // response json
    return;
}



/**
 * handle login
 * @method POST
 * @param email
 * @param password
 */
if (isset($_POST["email"]) && isset($_POST["password"]) ) {
    $data = [
        'email'    => $_POST["email"],
        'password' => $_POST["password"],
    ];
    // inintialize validate User object
    $validate = new \validate\User;

    // validate login request data
    if (!$validate->check($data)) {
        $res = [
            "code" => -1,
            "msg"  => $validate->getError(),
            "data" => "",
        ];
        echo json_encode($res); // response json
        return;
    }


    // Mailbox does not exist
    $info = $db->getUserByEmail($_POST["email"]);
    if (count($info) === 0) {
        $res = [
            "code" => -1,
            "msg"  => "Mailbox does not exist!",
            "data" => "",
        ];
        echo json_encode($res); // response json
        return;        
    }


    // The password is incorrect
    if (md5($_POST["password"]) !== $info[0]["password"]) {
        $res = [
            "code" => -1,
            "msg"  => "The password is incorrect!",
            "data" => "",
        ];
        echo json_encode($res); // response json
        return;            
    }
    
    // sign token and response
    $res = [
        "code" => 1,
        "msg"  => "Login success!",
        "data" => Issue($info[0]["id"]),
    ];    
    echo json_encode($res); // response json
    return;
}

echo "missing params";