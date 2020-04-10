<?php
declare (strict_types = 1);
define("DS", DIRECTORY_SEPARATOR);
require_once __DIR__ .DS."vendor".DS."autoload.php";

use GuzzleHttp\Client;
// Get request api
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    /**
    * Get music play address
    * @method post
    * @param play_id {lyrcs id}
    */
    if (isset($_GET["play_id"]) && !empty($_GET["play_id"])) {
        $id = (int)$_GET["play_id"];

        $client = new Client([
            'base_uri' => 'https://v1.itooi.cn/netease/', // Base URI is used with relative requests
            'verify'   => false,                          // Skip https
        ]);
        $response   = $client->request('GET', 'url?id='.$id);
        echo $response->getBody();
        return;
    }

    /**
     * Get music lyrcs
     * @method post
     * @param lrc_id {lyrcs id}
     */
    if (isset($_GET["lrc_id"]) && !empty($_GET["lrc_id"])) {
        $id = (int)$_GET["lrc_id"];

        $client = new Client([
            'base_uri' => 'https://v1.itooi.cn/netease/', // Base URI is used with relative requests
            'verify'   => false,                          // Skip https
        ]);
        $response   = $client->request('GET', 'lrc?id='.$id);
        echo $response->getBody();
        return;
    }



}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" type="text/css"/>	
    <link rel="stylesheet" type="text/css" href="./node_modules/aplayer/dist/Aplayer.min.css">
    <style>
        /* *{border:1px solid #ccc;} */
        input[type="text"]{width:calc(100% - 80px);outline:none;border:none;box-shadow:0px 0px 5px 0px #ccc;text-indent:15px;}
        .container{padding-top:15px;padding-bottom:200px}
        .search{justify-content:space-between;display:flex;}
        .table{margin-top:15px;}
        .avatar{width:50px;height:50px;overflow:hidden;}
        .avatar img{width:100%;height:100%;}

        .result{margin-left:30px;}
        .pagination{flex-wrap:wrap;}

        .author span{display:block}
        a[type="button"]{color:#fff;}

        .player{position:fixed;bottom:0px;right:0px;z-index:9999999999;width:100%;}
    </style>
</head>
<body>

<div class="container" id="app">
    <div class="player">
        <div ref="player" class="aplayer"></div>
    </div>


    <div class="row">
        <div class="search col-12 ">
            <input type="text" v-model="key">
            <button type="submit" class="btn btn-primary" @click="search">Search</button>
            
        </div>
        <div class="row">
            <p class="result mt-3">Number of results: {{ count }}</p>
        </div>
        
        

        <table class="table table-borderless">
            <thead>
                <tr>
                <th scope="col">Cover</th>
                <th scope="col">Name</th>
                <th scope="col">Alias</th>
                <th scope="col">Author</th>
                <th scope="col">Album</th>
                <th scope="col">Listen</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(vo, i) in data" :key="i">
                    <th scope="row">
                        <div class="avatar">
                            <img :src="vo.al.picUrl">
                        </div>
                    </th>
                    <td>{{ vo.name }}</td>
                    <td>{{ vo.alia[0] }}</td>
                    <td class="author">
                        <span v-for="(item, index) in vo.ar" :key="index">{{ item.name }}</span>
                    </td>
                    <td>{{ vo.al.name }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" @click="fetchMusic(vo.id)">Play</button>
                    </td>
                </tr>

            </tbody>
        </table>
    
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item" v-for="index in pages" :key="index">
                    <a class="page-link" @click="jump(index)">{{ index }}</a>
                </li>
            </ul>
        </nav>


    </div>
</div>








<script type="text/javascript" src="./node_modules/vue/dist/vue.min.js"></script>
<script type="text/javascript" src="./node_modules/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="./node_modules/qs/dist/qs.js"></script>
<script type="text/javascript" src="./node_modules/aplayer/dist/Aplayer.min.js"></script>
<script>
new Vue({
    el: '#app',
    data(){
        return{
            key: "Avicci",
            page: 0,     
            count: 0,
            data: [], 
            pages: 0,      

            music_id: 0,
            title: '',
            author: '',
            url: '',
            pic: '',
            lrc: '',            
        }
    },
    mounted() {
        this.fetchData();
        this.newPlayer();
    },
    methods: {
        fetchData(){
            if (this.key === "") {
                return alert("Cannot search empty!");
            }
            let data = {
                key: this.key,
                page: this.page,
            };
            axios.post('api.php', Qs.stringify(data)).then(res => {
                let data = res.data.data;
                this.data = data.songs;   
                this.count = data.songCount;
                this.pages = Math.ceil(data.songCount / 15) - 1;
                // console.log(data);
                                             
            })
        },
        jump(id){
            this.page = id; 
            this.data = [];
            this.fetchData();
        },
        search(){
            this.data = [];
            this.page = 0; 
            this.fetchData();
        },
        fetchMusic(id) {
            this.music_id = id;
            let data = { info_id: id };
            axios.post('api.php', Qs.stringify(data)).then(res => {
                let data = res.data.data.songs[0];
                this.title = data.name
                this.author = data.ar[0].name;
                this.pic = data.al.picUrl;
                this.getPlayUrl();
                this.getLrc();
                this.firePlayer();
            })
        },
        getPlayUrl(){
            let url = location.href.split("?")[0];
            this.url = url + "?play_id=" + this.music_id; 
        },     
        getLrc(){
            let url = location.href.split("?")[0];
            let lrc =  url + "?lrc_id=" + this.music_id;      
            this.lrc = lrc;                             
        },                
        newPlayer(){
            let obj = this.$refs.player;
            let ap = new APlayer({
                container: obj,
                mini: false,
                autoplay: true,
                preload: 'auto',
                volume: 1,
                mutex: true,
                listFolded: false,
                listMaxHeight: 90,
                lrcType: 3,
                audio: [],
            });
            this.ap = ap;
        },
        firePlayer(){
            this.ap.list.clear();
            let data = {
                title: this.title,
                author: this.author,
                url: this.url,
                pic: this.pic,
                lrc: this.lrc,
            };
            this.ap.list.add(data);            
            // // this.ap.option.music = data;
            // // this.ap.music = data;
            this.$nextTick(() => {
                this.ap.play();
            })
            
        }

        
    },
})  
</script>
</body>
</html>










