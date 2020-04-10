<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR ."vendor" . DIRECTORY_SEPARATOR. "autoload.php";

use \Firebase\JWT\JWT; //导入JWT

const KEY = "i_love_bifca";

// Sign token
function Issue(int $uid):string{
    $time = time(); //当前时间
    $token = [
    'iss' => 'http://localhost', //签发者 可选
    'aud' => 'http://localhost', //接收该JWT的一方，可选
    'iat' => $time, //签发时间
    'nbf' => $time , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
    'exp' => $time + 7200, //过期时间,这里设置2个小时
        'data' => [ //自定义信息，不要定义敏感信息
            'uid' => $uid,
        ]
    ];        
    return JWT::encode($token, KEY); //输出Token
}


// validate token
function verification(string $token):array{
    try {
        JWT::$leeway = 60;//当前时间减去60，把时间留点余地
        $decoded = JWT::decode($token, KEY, ['HS256']); //HS256方式，这里要和签发的时候对应
        $arr     = (array)$decoded;
        return $arr;
    }catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
        throw new Exception($e->getMessage(), 1);
    }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
        throw new Exception($e->getMessage(), 1);
    }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
        throw new Exception($e->getMessage(), 1);
    }catch(Exception $e) {  //其他错误
        throw new Exception($e->getMessage(), 1);
    }
    return [];
}