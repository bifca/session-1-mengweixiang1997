<?php
require_once "common.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/aplayer/dist/Aplayer.min.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/animate.css/animate.min.css">
    <style>
        :root{
            --color: rgb(31,211,173);
        }
        body{font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;background-color:rgb(246,246,246);padding-bottom:120px;}
        .table td, .table th{border-top:none;}
        td[scope="col"]{font-size:14px;color:#818181;}
        .page-link{color:var(--color);}
        .page-link:focus{box-shadow:none;}
        .pagination a{display:block;padding:.5rem .75rem;margin-left:-1px;line-height:1.25;color:var(--color);cursor:pointer;}
        .pagination a:hover{color:var(--color);}
        .pagination .active{background-color:var(--color);}
        .pagination .active a{color:#fff;}
        
        .table-hover tbody tr:hover{background-color:rgb(239,239,239);}

        .album{max-width:200px;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;}
        .song{max-width:350px;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;cursor:pointer;}
        .like{cursor:pointer;width:40px;}

        .player{position:fixed;bottom:0px;right:0px;z-index:9999999999;width:100%;}
        .playing{color:var(--color);background-color:rgb(239,239,239);}
        .playing:hover{color:var(--color)!important;}

        /* skeleton style */
        .skeleton{display:block;margin-top:50px;}
        .skeleton .block{width:100%;height:60px;animation:blink 1s infinite;}
        .skeleton .tbody.row{margin-bottom:15px;}
        .skeleton .th{margin-bottom:15px;}
        .skeleton .th .block{height:35px;width:30%;}
        .skeleton .search{margin-bottom:30px;}
        .skeleton .search .block{height:50px;}

        .music_list{overflow:hidden;}
        .music_list .search{margin-right:0px;margin-left:0px;padding:0px;margin-top:15px;font-size:32px;font-weight:800;}
        .music_list .search .input{width:100%;height:40px;background-color:rgb(227,227,227);border-radius:30px;display:flex;justify-content:space-between;overflow:hidden;}
        .music_list .search .input input{width:calc(100% - 50px);height:100%;width:100%;background-color:transparent;border:none;outline:none;text-indent:15px;}
        .music_list .search .input .submit{height:40px;width:50px;display:flex;justify-content:center;align-items:center;cursor:pointer;}
        .music_list .search .input .submit path{fill:rgb(175,175,175)}
        .music_list .search .input .submit:hover path{fill:var(--color);}
        
        .words{margin-top:100px;text-align:center;margin-bottom:30px;font-size:42px;color:#fff;}

        @keyframes blink{
            0% {
                background-color:rgb(230,230,230,.5);
            }
            50% {
                background-color:rgb(230,230,230,1);
            }
            100% {
                background-color:rgb(230,230,230,.5);
            }
        }
        @media (max-width:576px){
            .skeleton{display:block;margin-top:15px;}
            .skeleton .th .block{height:35px;width:60%;}
            .skeleton .search{margin-bottom:15px;}
        }
        /* *{border:1px solid #ccc;} */
    </style>
</head>
<body>
    
    <div class="container" id="app">

        <!-- skeleton begin -->
        <div class="skeleton" v-if="isLoading">
            <div class="row search">
                <div class="col-10"><div class="block"></div></div>
                <div class="col-2"><div class="block"></div></div>
            </div>
            <div class="row th">
                <div class="col-6"><div class="block"></div></div>
                <div class="col-3"><div class="block"></div></div>
                <div class="col-3"><div class="block"></div></div>
            </div>
            <div class="row tbody" v-for="(item, index) in 5" :key="index">
                <div class="col-6"><div class="block"></div></div>
                <div class="col-3"><div class="block"></div></div>
                <div class="col-3"><div class="block"></div></div>
            </div>
        </div>
        <!-- skeleton end -->

        <div :class="[isLoading === false ? 'd-block' : 'd-none', 'table-responsive', 'music_list']">
            <div class="row search">
                My favorite
            </div>

            <table class="table table-hover" v-if="isSearched">
                <thead>
                    <tr>
                        <td scope="col"></td>
                        <td scope="col">Song</td>
                        <td scope="col">Singer</td>
                        <td scope="col">Album</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in list" :key="i" :class="music_id === item.songmid ? 'playing' : ''">
                        <td class="like" @click="liked(item.mid)">
                            <svg t="1586507659614" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5713" width="25" height="25">
                                <path d="M694 170.8c-71.6 0-138.2 69.6-182 121.8-43.8-52.3-110.3-121.8-182-121.8-129 0-234 101.2-234 225.7 0 74.3 37.6 126.4 67.8 168.2 87.9 121.6 308.8 273 318.1 279.3 9 6.1 19.6 9.2 30.1 9.2s21.1-3.1 30.1-9.2c9.4-6.4 230.3-157.7 318.1-279.3 30.2-41.9 67.9-94 67.9-168.2C928 272 823 170.8 694 170.8z m0 0" p-id="5714" fill="rgb(255,106,106)">
                                </path>
                            </svg>                                                    
                        </td>
                        <td v-html="item.title" class="song" @click="playMusic(item.mid)"></td>
                        <td>{{ displaySingers(item.singer) }}</td>
                        <td v-html="item.album.title" class="album"></td>
                    </tr>
                </tbody>
            </table>

        </div>
        
        <div :class="[isSearched ? 'd-block' : 'd-none' ,'player']">
            <div ref="player" class="aplayer"></div>
        </div>
    </div>

<script src="./node_modules/vue/dist/vue.min.js"></script>
<script src="./node_modules/axios/dist/axios.min.js"></script>
<script src="./node_modules/qs/dist/qs.js"></script>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./node_modules/bootstrap-paginator/bootstrap-paginator.js"></script>
<script src="./node_modules/aplayer/dist/Aplayer.min.js"></script>
<script>
let vm = new Vue({
    el: "#app",
    data: {
        // request setting
        key: "lana del rey",
        pageSize: 15,
        page: 0,
        isLoading:false,
        isSearched:true,
        // reponse data
        list: [],

        music_id: 0,
        title: "",
        author:"",
        url:"",
        pic:"",
        lrc:"",
    },
    mounted() {
        this.fetchData();
        this.newPlayer();
        // this.initPaginator();
    },
    methods: {
        fetchData() {
            if (this.key === "") {
                return alert("Cannot search empty!");
            }
            if (!this.isSearched) {
                this.isSearched = true;
            }
            this.isLoading = true;
            // get user liked list
            axios.post("api_liked.php", Qs.stringify({get_list: 1})).then(res => {
                let arr = res.data;
                let liked = [];
                arr.map(val => {
                    liked.push(val["mid"]);
                })
                let data = {
                    song_id: liked.join(","),
                };                
                return axios.get("api_tencent.php?" + Qs.stringify(data));
            }).then(res => { //fetch data;
                let arr = res.data.data;

                console.log(arr);

                this.list = arr;

                this.isLoading = false;
            })
        }, 
        initPaginator(){
            let _this = this;
            $(this.$refs.pagination).bootstrapPaginator({
                currentPage: 1,//当前页。
                totalPages: 20,//总页数。
                size: "normal",//应该是页眉的大小。
                bootstrapMajorVersion: 4,//bootstrap的版本要求。
                alignment: "right",
                numberOfPages: 5,//显示的页数
                itemTexts: function (type, page, current) {//如下的代码是将页眉显示的中文显示我们自定义的中文。
                    switch (type) {
                        case "first": return "First";
                        case "prev":  return "Prev";
                        case "next":  return "Next";
                        case "last":  return "Last";
                        case "page":  return page;
                    }
                },
                onPageClicked: function (event, originalEvent, type, page) {//给每个页眉绑定一个事件，其实就是ajax请求，其中page变量为当前点击的页上的数字。
                    _this.page = page;
                    _this.fetchData();
                    
                }
            });
        },
        displaySingers(arr){
            let dummy = [];
            if (arr !== undefined) {
                arr.map(val => {
                    dummy.push(val["name"]);
                }) 
                return dummy.join(" / ")               
            }
            return "";
        },
        getQueryVariable(name){
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);//search,查询？后面的参数，并匹配正则
            if (r != null) return unescape(r[2]); return null;
        },
        playMusic(mid){
            let data = {
                "song_id": mid,
            };
            this.music_id = mid;
            axios.get("api_tencent.php?" + Qs.stringify(data)).then(res => {
                let arr = res.data.data[0];

                this.title = arr.title;
                this.author = this.displaySingers(arr.singer);

                this.getPlayUrl();
                this.getLrc();
                this.getPic();
                this.firePlayer();
            });       
            
        },
        getPlayUrl() {
            let url = "api_tencent.php";
            this.url = url + "?song_mid=" + this.music_id;
        },
        getLrc() {
            let url = "api_tencent.php";
            let lrc = url + "?lrc_id=" + this.music_id;
            this.lrc = lrc;
        },   
        getPic() {
            let url = "api_tencent.php";
            let pic = url + "?pic_id=" + this.music_id;
            this.pic = pic;
        },                       
        newPlayer() {
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
        firePlayer() {
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
        },
        liked(mid){
            let currentList = []; 
            this.list.map(val => {
                if (val.mid !== mid) {
                    currentList.push(val)
                }
            })
            this.list = currentList;
            this.cancelLiked(mid);
        },
        cancelLiked(mid){
            console.log("取消收藏");
            axios.post("api_liked.php", Qs.stringify({mid: mid, type: 0})).then(res => {
                let arr = res.data;
                console.log(arr);
                
            })
        },
        addLiked(mid){
            console.log("添加收藏");
            axios.post("api_liked.php", Qs.stringify({mid: mid, type: 1})).then(res => {
                let arr = res.data;
                console.log(arr);
                
            })
        },
        search(){
            this.fetchData();

        },
        

    },
})
</script>
</body>
</html>