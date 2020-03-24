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

    /**
     * get tables' datas;
     * @param string $table [table name]
     * @return array
     */
    public function getList(string $table):array{
        $arr = [];
        $result = $this->mysqli->query("select * from " . $table);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($arr, $row);
            }
        }  
        return $arr;
    }




}

