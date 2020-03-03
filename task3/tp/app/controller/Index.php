<?php
namespace app\controller;

use think\facade\View;
use think\facade\DB;
use app\BaseController;
use think\facade\Request;

class Index extends BaseController
{

    // redirect to spa application
    public function index()
    {
        return redirect("/index.html#/");
    }
    
    // response api
    public function api(){
        $param = Request::post('theme'); // Get post request data
        $arr = []; // defined a array;
        if ($param === "exchange_lonless") {
            // fetch exchange_loneliness datas
            $arr = Db::table('exchange_loneliness')->select();
        }elseif ($param === "regeneration") {
            // fetch regeneration datas
            $arr = Db::table('regeneration')->select();
        }elseif ($param === "petri_dish") {
            // fetch petri_dish datas
            $arr = Db::table('petri_dish')->select();
        }elseif ($param === "miscellanea") {
            // fetch miscellanea datas
            $arr = Db::table('miscellanea')->select();
        }elseif ($param === "mould") {
            // fetch mould datas
            $arr = Db::table('mould')->select();
        }
        // encode to json to response
        return json($arr);
    }


    // migrate data to database
    public function migrate(){
        $flagFile = __DIR__."/bak";
        if(file_exists($flagFile)){
            return redirect("/index.html#/");
        }
        // migrate exchange_loneliness data
        for ($i=1; $i <= 22; $i++) { 
            DB::query("insert into exchange_loneliness(`img`,`alt`) value('http://127.0.0.1:8000/img/exchange_loneliness/".$i.".jpg', 'test');");
        }
        // migrate regeneration data
        for ($i=1; $i <= 11; $i++) { 
            DB::query("insert into regeneration(`img`,`alt`) value('http://127.0.0.1:8000/img/regeneration/".$i.".jpg', 'test');");
        }        
        // migrate petri_dish data
        for ($i=1; $i <= 14; $i++) { 
            DB::query("insert into petri_dish(`img`,`alt`) value('http://127.0.0.1:8000/img/petri_dish/".$i.".jpg', 'test');");
        }     
        // migrate miscellanea data
        for ($i=1; $i <= 6; $i++) { 
            DB::query("insert into miscellanea(`img`,`alt`) value('http://127.0.0.1:8000/img/miscellanea/".$i.".jpg', 'test');");
        }     
        // migrate mould data
        for ($i=1; $i <= 11; $i++) { 
            DB::query("insert into mould(`img`,`alt`) value('http://127.0.0.1:8000/img/mould/".$i.".jpg', 'test');");
        }
        // Create flag
        fopen($flagFile, "w");
        echo "Success";
        return;
    }


    // admin page
    public function admin(){
        return View::fetch();
    }


    // delete data api
    public function del(){
        $target = input('post.theme/s'); // Get post request data
        $id     = input('post.id/d'); // Get post request data
        $target = $target === "exchange_lonless" ? "exchange_loneliness" : ""; // modify wrong parameter;

        $sql = "delete from ". $target ." where id=?"; //PDO prepare statement prevent sql inject
        // response data stuct;

        try {
            $res = DB::query($sql, [$id]); // bind value
        } catch (\Throwable $th) {
            // execute fail
            $response = [
                "code" => 0,
                "msg"  => "执行失败",
            ];            
            return json($response);           
        }   
        // execute success
        $response = [
            "code" => 1,
            "msg"  => "执行成功",
        ];               
        return json($response);
    }



    // upload file
    public function upload(){
        $file = request()->file('image');
        $md5 = md5_file($file);
        $path = __DIR__."/../../public/img/upload/".$md5.".".$file->extension();
        move_uploaded_file($file, $path);
        $data = [
            'path' => "http://127.0.0.1:8000/img/upload/".$md5.".".$file->extension()
        ];
        return json($data);
    }



    // update 
    public function update(){
        $id    = input('post.id/d');
        $img   = input('post.img/s');
        $alt   = input('post.alt/s');
        $theme = input('post.theme/s');
        $theme = $theme === "exchange_lonless" ? "exchange_loneliness" : ""; // modify wrong parameter;
        
        $sql = "update $theme set img=?,alt=? where id=?";
        try {
            $res = DB::query($sql, [$img, $alt, $id]); // bind valu
        } catch (\Throwable $th) {
            // execute fail
            $response = [
                "code" => 0,
                "msg"  => "执行失败",
            ];            
            return json($response);             
        }    
        // execute success
        $data = [
            "code" => 1,
            "msg"  => "执行成功",
        ];
        return json($data);
    }

    // insert
    public function add(){
        $img   = input('post.img/s');
        $alt   = input('post.alt/s');
        $theme = input('post.theme/s');
        $theme = $theme === "exchange_lonless" ? "exchange_loneliness" : ""; // modify wrong parameter;
        
        $sql = "insert into $theme (img,alt) values (?,?)";
        try {
            $res = DB::query($sql, [$img, $alt]); // bind valu
        } catch (\Throwable $th) {
            // execute fail
            $response = [
                "code" => 0,
                "msg"  => "执行失败",
            ];            
            return json($response);             
        }    
        // execute success
        $data = [
            "code" => 1,
            "msg"  => "执行成功",
        ];
        return json($data);
    }




}
