<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR ."vendor" . DIRECTORY_SEPARATOR. "autoload.php";

use \Firebase\JWT\JWT;

const KEY = "i_love_bifca";

// Sign token
function Issue(int $uid):string{
    $time = time(); //Crrent time
    $token = [
    'iss' => 'http://localhost', //Iusser
    'aud' => 'http://localhost', //audi
    'iat' => $time, //Issuing time
    'nbf' => $time , //(Not Before)：
    'exp' => $time + 7200, //Expiry time, set here 2 hours
        'data' => [ //Extra data
            'uid' => $uid,
        ]
    ];        
    return JWT::encode($token, KEY); // output token
}


// validate token
function verification(string $token):array{
    try {
        JWT::$leeway = 60;// The current time minus 60, leaving time for room
        $decoded = JWT::decode($token, KEY, ['HS256']); // HS256 mode, here it corresponds to when it is issued
        $arr     = (array)$decoded;
        return $arr;
    }catch(\Firebase\JWT\SignatureInvalidException $e) {  
        throw new Exception($e->getMessage(), 1);
    }catch(\Firebase\JWT\BeforeValidException $e) {  // The signature can only be used after a certain time
        throw new Exception($e->getMessage(), 1);
    }catch(\Firebase\JWT\ExpiredException $e) {  // token expired
        throw new Exception($e->getMessage(), 1);
    }catch(Exception $e) {  // other error
        throw new Exception($e->getMessage(), 1);
    }
    return [];
}