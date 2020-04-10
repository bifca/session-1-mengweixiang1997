<?php
declare (strict_types = 1);
require_once __DIR__. DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR. "autoload.php";

use GuzzleHttp\Client;

class Http{
    private $client;
    private $uid = "4";
    private $token = "3AE0FF9CB39153151036E9E738576F7C1ADA1FB5";
    public function __construct(string $url){
        $client = new Client([
            'base_uri' => $url, // Base URI is used with relative requests
            'verify'   => false, // Skip https
        ]);
        $this->client = $client;
    }


    /**
     * Do GET request
     * @param $path  request url path
     * @param $params request parameters
     * @return json  
     */
    public function get(string $path, array $params):string{
        $auth = [
            'uid'   => $this->uid,
            'token' => $this->token,
        ];

        $arr = array_merge($params, $auth);
        
        $response = $this->client->request('GET', $path, ['query' => $arr]);
        return (string)$response->getBody();
    }


    /**
     * Do POST request
     * @param $path  request url path
     * @param $params request parameters
     * @return json  
     */
    public function post(string $path, array $params):string{
        $auth = [
            'uid'   => $this->uid,
            'token' => $this->token,
        ];

        $arr = array_merge($params, $auth);
        $response = $this->client->request('POST',  $path, ['query' => $arr]);
        return $response->getBody();
    }





}