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
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>html音乐播放器</title>
    <meta name="keywords" content="HTML5,播放器" />
    <meta name="description" content="" />
    <link rel="stylesheet" type="text/css" href="static/Aplayer.min.css">
</head>

<body>
    <div id="header">
    </div>
    <div id="main" id="app">
        <div class="demo">
            <p><strong>MY MUSIC</strong></p>
            <div id="player3" class="aplayer">
                <pre class="aplayer-lrc-content">
</pre>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./node_modules/vue/dist/vue.min.js"></script>
    <script type="text/javascript" src="./node_modules/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="./node_modules/qs/dist/qs.js"></script>
    <script src="static/Aplayer.min.js"></script>
    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    title: '',
                    author: '',
                    url: 'http://localhost/session/session-1-mengweixiang1997/task5/play.php?play_id=28660009',
                    pic: '',
                    lrc: '',
                }
            },
            created(){
                this.getPlayUrl();
            },
            mounted() {
                this.fetchData();
                this.getLrc();
            },
            methods: {
                fetchData() {
                    let param = this.getUrlParamValue(location.search);
                    if(param.id === "" || param.id === null || param.id === undefined){
                        alert("Cannot Play!");
                        return;
                    }
                    let id = param.id;
                    let data = { info_id: id };
                    axios.post('api.php', Qs.stringify(data)).then(res => {
                        let data = res.data.data.songs[0];
                        this.title = data.name
                        this.author = data.ar[0].name;
                        this.pic = data.al.picUrl;
                        // this.getPlayUrl();

                        this.initPlayer();
                    })
                },
                getPlayUrl(){
                    let id = this.getUrlParamValue(location.search).id;
                    let url = location.href.split("?")[0];
                    // this.url = url + "?play_id=" + id; 
                    console.log(this.url);

                    // this.initPlayer();

                },          
                getLrc(){
                    let id = this.getUrlParamValue(location.search).id;
                    let url = location.href.split("?")[0];
                    axios.get(url + "?lrc_id=" + id).then(res => {
                        this.lrc = res.data;
                    })                                       
                },   
                getUrlParamValue(name){
                    var query = query ? query : document.location.search.substring(1);
                    if (!query) return {};
                    var parts = query.split('&');
                    var params = {};
                    for (var i = 0, ii = parts.length; i < ii; ++i) {
                        var param = parts[i].split('=');
                        var key = param[0].toLowerCase();
                        var value = param.length > 1 ? param[1] : null;
                        params[decodeURIComponent(key)] = decodeURIComponent(value);
                    }
                    return params;
                },
                initPlayer(){
                    let ap3 = new APlayer({
                        element: document.getElementById('player3'),//样式1
                        narrow: false,
                        autoplay: false,
                        showlrc: false,
                        music: {
                            title: this.title,
                            author: this.author,
                            url: this.url,
                            pic: this.pic
                        }
                    });
                    ap3.init();

                }
            },
        })  




    </script>
</body>

</html>