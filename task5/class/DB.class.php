<?php
declare (strict_types = 1);

class DB{
    private $mysqli; 
    public function __construct(string $host, string $user,string $pwd, string $db){
        //initialization
        $this->mysqli = new mysqli($host, $user, $pwd, $db);
        // connect error
        if ($this->mysqli->connect_error) {
            die("error: ".$this->mysqli->connect_error);
        }
        $this->mysqli->query("set names utf8");
    }







}

