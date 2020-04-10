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

    /**
     * Get user infomation by email
     * @param $email user email address
     * @return object
     */
    public function getUserByEmail(string $email):array{
        $arr = [];
        $result = $this->mysqli->query("select * from user where email = '$email'");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($arr, $row);
            }
        }  
        return $arr;
    }


    /**
     * Add user
     * @param $email user email address
     * @param $email raw password
     * @return int user's pk;
     */    
    public function addUser(string $email, string $password):int{
        // prepare statement
        $stmt = $this->mysqli->prepare("INSERT INTO user (`email`, `password`, `status`) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $param1, $param2, $param3);
        $param1 = $email;
        $param2 = md5($password);
        $param3 = 1;
        $stmt->execute();
        // get pk;
        $rows = $this->getUserByEmail($email);
        return (int)$rows[0]["id"];
    }


    /**
     * Get user liked list
     * @param uid int
     * @return array
     */
    public function getUserLikedList(int $uid){
        $arr = [];
        $result = $this->mysqli->query("select mid from liked where uid=$uid and status=1");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($arr, $row);
            }
        }  
        return $arr;        
    }


    /**
     * add liked music
     * @param $uid user's id;
     * @param $mid music's mid
     * @return bool
     */
    public function addLikedMusic(int $uid, string $mid){
        $currentTime = time();
        if($this->hasLikedExist($uid, $mid)){
            $result = $this->mysqli->query("update liked set status = 1, update_time=$currentTime where uid=$uid and mid='$mid'");
            return;
        }
        $this->mysqli->query("insert into liked(`uid`,`mid`,`status`, `update_time`, `create_time`) value($uid, '$mid', 1, '$currentTime', '$currentTime');");
    }


    
    /**
     * add liked music
     * @param $uid user's id;
     * @param $mid music's mid
     * @return bool
     */
    public function cancelLikedMusic(int $uid, string $mid){
        $currentTime = time();
        if($this->hasLikedExist($uid, $mid)){
            $result = $this->mysqli->query("update liked set status = 2, update_time=$currentTime where uid=$uid and mid='$mid'");
            return;
        }
    }


    /**
     * has liked music exist?
     * @param $uid user's id;
     * @param $mid music's mid
     * @return bool
     */
    public function hasLikedExist(int $uid, string $mid):bool{
        $arr = [];
        $result = $this->mysqli->query("select count(*) from liked where uid=$uid and mid='$mid'");
        $row = $result->fetch_assoc();
        if ((int)$row["count(*)"] === 0) {
            return false;
        }
        return true;
    }




}

