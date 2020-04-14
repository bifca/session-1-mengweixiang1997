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
        
        .table-hover tbody tr{text-overflow:ellipsis;overflow:hidden;white-space:nowrap;}
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
        .music_list .search{margin-right:0px;margin-left:0px;padding:0px;margin-top:15px;}
        .music_list .search .input{width:100%;height:40px;background-color:rgb(227,227,227);border-radius:30px;display:flex;justify-content:space-between;overflow:hidden;}
        .music_list .search .input input{width:calc(100% - 50px);height:100%;width:100%;background-color:transparent;border:none;outline:none;text-indent:15px;}
        .music_list .search .input .submit{height:40px;width:50px;display:flex;justify-content:center;align-items:center;cursor:pointer;}
        .music_list .search .input .submit path{fill:rgb(175,175,175)}
        .music_list .search .input .submit:hover path{fill:var(--color);}
        
        .words{margin-top:100px;text-align:center;margin-bottom:30px;font-size:42px;color:#fff;}

        .background{width:100%;height:100vh;background-image:url("./static/img/download.webp");background-size:cover;background-position:center center;position:fixed;z-index:-999;left:0px;top:0px;}
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
            /* .music_list{overflow:auto;} */
            .skeleton{display:block;margin-top:15px;}
            .skeleton .th .block{height:35px;width:60%;}
            .skeleton .search{margin-bottom:15px;}
        }
        /* *{border:1px solid #ccc;} */

        .favorite{width:50px;height:50px;box-shadow:0px 0px 10px 0px #ccc;position:fixed;right:0px;top:100px;border-top-left-radius:10px;border-bottom-left-radius:10px;background-color:#fff;display:flex;justify-content:center;align-items:center;cursor:pointer;}
    </style>
</head>
<body>
    
    <div class="container" id="app">

        <div class="favorite" @click="jump">
            <svg t="1586507659614" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5713" width="35" height="35">
                <path d="M694 170.8c-71.6 0-138.2 69.6-182 121.8-43.8-52.3-110.3-121.8-182-121.8-129 0-234 101.2-234 225.7 0 74.3 37.6 126.4 67.8 168.2 87.9 121.6 308.8 273 318.1 279.3 9 6.1 19.6 9.2 30.1 9.2s21.1-3.1 30.1-9.2c9.4-6.4 230.3-157.7 318.1-279.3 30.2-41.9 67.9-94 67.9-168.2C928 272 823 170.8 694 170.8z m0 0" p-id="5714" fill="rgb(230,230,230)">
                </path>
            </svg>               
        </div>


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

        <div :class="[isLoading === false ? 'd-block' : 'd-none', 'music_list']">
            <div class="row search">
                <div class="input">
                    <input type="text" v-model="key" @keyup.enter="search" placeholder="Press enter to search~">
                    <div class="submit" @click="search">
                        <svg t="1586410441436" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4882"
                            width="20" height="20">
                            <path
                                d="M999.68 880.213333l-249.173333-249.173333c41.813333-64 66.133333-140.8 66.133333-222.72C816.64 183.04 634.026667 0 408.32 0 183.04 0 0 183.04 0 408.32c0 225.706667 183.04 408.32 408.32 408.32 82.773333 0 160-24.746667 224.426667-67.413333l248.746666 248.746666c32.426667 32.426667 85.333333 32.426667 117.76 0 32.853333-32.426667 32.853333-85.333333 0.426667-117.76zM137.813333 408.32c0-150.613333 122.026667-272.64 272.64-272.64s272.64 122.026667 272.64 272.64-122.026667 272.64-272.64 272.64S137.813333 558.933333 137.813333 408.32z" p-id="4883">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- data table begin -->
            <div class="table-responsive">
                <table class="table table-hover" v-if="isSearched">
                    <caption>Total results: {{ totalnum }}</caption>
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
                            <td class="like" @click="liked(item.songmid)">
                                <div v-if="item.liked !== 1">
                                    <svg t="1586407158609" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4126"
                                        width="25" height="25">
                                        <path
                                            d="M501.76 896c-15.36 0-30.72-5.12-40.96-15.36-5.12-5.12-322.56-358.4-322.56-363.52-35.84-46.08-56.32-102.4-56.32-158.72-5.12-143.36 112.64-256 256-256 61.44 0 117.76 20.48 163.84 56.32 46.08-35.84 102.4-56.32 163.84-56.32 138.24 0 256 112.64 256 250.88 0 56.32-20.48 112.64-56.32 158.72l-322.56 363.52c-15.36 10.24-25.6 20.48-40.96 20.48zM179.2 476.16c10.24 10.24 235.52 261.12 317.44 358.4l322.56-358.4c25.6-35.84 46.08-76.8 46.08-122.88 0-107.52-92.16-194.56-199.68-194.56-56.32 0-107.52 20.48-143.36 56.32l-20.48 25.6-25.6-20.48c-35.84-40.96-87.04-61.44-138.24-61.44-112.64 0-199.68 87.04-199.68 194.56-5.12 46.08 10.24 92.16 40.96 122.88z"
                                            fill="#818181" p-id="4127">
                                        </path>
                                    </svg>                            
                                </div>
                                <div v-else>
                                    <svg t="1586507659614" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5713" width="25" height="25">
                                        <path d="M694 170.8c-71.6 0-138.2 69.6-182 121.8-43.8-52.3-110.3-121.8-182-121.8-129 0-234 101.2-234 225.7 0 74.3 37.6 126.4 67.8 168.2 87.9 121.6 308.8 273 318.1 279.3 9 6.1 19.6 9.2 30.1 9.2s21.1-3.1 30.1-9.2c9.4-6.4 230.3-157.7 318.1-279.3 30.2-41.9 67.9-94 67.9-168.2C928 272 823 170.8 694 170.8z m0 0" p-id="5714" fill="rgb(255,106,106)">
                                        </path>
                                    </svg>                                                    
                                </div>
                            </td>
                            <td v-html="item.songname" class="song" @click="playMusic(item.songmid)"></td>
                            <td>{{ displaySingers(item.singer) }}</td>
                            <td v-html="item.albumname" class="album"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- data table end -->

            <nav aria-label="Page navigation example" :class="[isSearched ? 'd-block' : 'd-none']">
                <ul class="pagination" ref="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item" v-for="(item, index) in Math.ceil(totalnum / pageSize)" :key="index">
                        <a class="page-link" :href="'?page=' + item">{{ item }}</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- player beign -->
        <div :class="[isSearched ? 'd-block' : 'd-none' ,'player']">
            <div ref="player" class="aplayer"></div>
        </div>
        <!-- player end -->
    </div>

<script src="./node_modules/vue/dist/vue.min.js"></script>
<script src="./node_modules/axios/dist/axios.min.js"></script>
<script src="./node_modules/qs/dist/qs.js"></script>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./node_modules/bootstrap-paginator/bootstrap-paginator.js"></script>
<script src="./node_modules/aplayer/dist/Aplayer.min.js"></script>
<script>
// initialize the vue object
let vm = new Vue({
    el: "#app",
    data: {
        // request setting
        key: "avicii",
        pageSize: 15,     // page items number
        page: 0,          // current page number
        isLoading:false,  // is loading?
        isSearched:false, // is first searched?
        // reponse data
        list: [],         // response result list
        likedList:[],     // user liked list
        totalnum: 0,      // total pages number

        music_id: 0,      // current playing music mid
        title: "",        // current playing music title
        author:"",        // current playing music author
        url:"",           // current playing music url address
        pic:"",           // current playing music cover
        lrc:"",           // current playing music lyrics
    },
    mounted() {
        // let page = this.getQueryVariable("page") !== null ? this.getQueryVariable("page") : 1;
        // console.log(page);

        this.fetchData();
        this.newPlayer();
    },
    methods: {
        fetchData() {
            // validate search keywords
            if (this.key === "") {
                return alert("Cannot search empty!");
            }
            if (!this.isSearched) {
                this.isSearched = true;
            }
            // show loading
            this.isLoading = true;
            let data = {
                search: this.key,
                pageSize: this.pageSize,
                page: this.page,
            };
            // get user liked list
            // serialize the form data and POST request
            axios.post("api_liked.php", Qs.stringify({get_list: 1})).then(res => {
                let arr = res.data;
                let liked = [];
                arr.map(val => {
                    liked.push(val["mid"]);
                })
                this.likedList = liked;
                // get search result list
                // serialize the form data and POST request 
                return axios.get("api_tencent.php?" + Qs.stringify(data));
            }).then(res => { //fetch data;
                let arr = res.data.data;
                arr.list.map(val => {
                    let songmid = val["songmid"];
                    val["liked"] = 0;
                    this.likedList.map(v => {
                        if(songmid === v){
                            val["liked"] = 1;
                        }
                    })
                })
                this.list = arr.list;

                this.totalnum = arr.totalnum;
                this.isLoading = false;
                this.initPaginator();
            })
        },
        // initizlize paginator
        initPaginator(){
            let _this = this;
            $(this.$refs.pagination).bootstrapPaginator({
                currentPage: this.page === 0 ? 1 : this.page,//curretn page number
                totalPages: Math.ceil(this.totalnum / this.pageSize),//total page number
                size: "normal",//font size
                bootstrapMajorVersion: 4,//bootstrap version required
                alignment: "right",
                numberOfPages: 5,// show page foot
                itemTexts: function (type, page, current) {
                    // modify the pagination information
                    switch (type) {
                        case "first": return "First";
                        case "prev":  return "Prev";
                        case "next":  return "Next";
                        case "last":  return "Last";
                        case "page":  return page;
                    }
                },
                //Binding an event to each header is actually an ajax request, where the page variable is the number on the currently clicked page.
                onPageClicked: function (event, originalEvent, type, page) {
                    _this.page = page;
                    _this.fetchData();
                    
                }
            });
        },
        // convert singer array to string
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
        // get url qurey parameter
        getQueryVariable(name){
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            // search? The following parameters, and match the regular
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;
        },
        // play music
        playMusic(mid){
            let data = {
                "song_id": mid,
            };
            this.music_id = mid;
            // serialize the form data and POST request
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
        // get music play address
        getPlayUrl() {
            let url = "api_tencent.php";
            this.url = url + "?song_mid=" + this.music_id;
        },
        // get lyrics cover address
        getLrc() {
            let url = "api_tencent.php";
            let lrc = url + "?lrc_id=" + this.music_id;
            this.lrc = lrc;
        },   
        // get music cover address
        getPic() {
            let url = "api_tencent.php";
            let pic = url + "?pic_id=" + this.music_id;
            this.pic = pic;
        },                       
        newPlayer() {
            // initialize the music player
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
            // add this object to GLOBLE
            this.ap = ap;
        },
        // fire music player
        firePlayer() {
            // clear play list
            this.ap.list.clear();
            let data = {
                title: this.title,
                author: this.author,
                url: this.url,
                pic: this.pic,
                lrc: this.lrc,
            };
            // add music to music play list
            this.ap.list.add(data);
            // // this.ap.option.music = data;
            // // this.ap.music = data;
            // after 80ms and play
            this.$nextTick(() => {
                this.ap.play();
            })
        },
        // check the music what i liked
        liked(mid){
            let list = this.list.map(val => {
                // if the liked music mid === fetched data muisc mid;
                if (val["songmid"] === mid) {
                    if(val["liked"] === 1){
                        this.cancelLiked(mid);
                    }else{
                        this.addLiked(mid);
                    }
                    val["liked"] = val["liked"] === 1 ? 0 : 1;
                }
                return val;
            })
            this.list = list;
        },
        // remove music to favorite list
        cancelLiked(mid){
            // serialize the form data and POST request
            axios.post("api_liked.php", Qs.stringify({mid: mid, type: 0}))
        },
        // add music to favorite list
        addLiked(mid){
            //serialize the form data and POST request
            axios.post("api_liked.php", Qs.stringify({mid: mid, type: 1}))
        },
        // search music
        search(){
            this.fetchData();

        },
        jump(){
            window.location.href = "liked.php";

        },
        

    },
})
</script>
</body>
</html>