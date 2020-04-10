<?php
require_once "common.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/animate.css/animate.min.css">
    <style>
        .main{height:auto;box-shadow:0px 0px 10px 0px rgba(80,80,80,.5);background-color:#fff;padding-bottom:30px;}        
        :root{
            --color: rgb(31,211,173);
        }
        .bar{width:100%;height:3px;background-color:var(--color);position:absolute;top:0px;left:0px;}
        .input{width:100%;height:35px;margin-top:15px;border-radius:30px;overflow:hidden;background-color:rgb(227,227,227);}
        .input input{width:100%;height:100%;border:none;outline:none;background-color:transparent;text-indent:15px;}
        .label{margin-bottom:-10px;margin-top:15px;color:#ccc;}

        .submit{padding:10px 5px 0px;align-items:center;justify-content:center;margin-top:15px;}
        .submit .login{background-color:var(--color);height:40px;border-radius:5px;text-transform:capitalize;font-size:18px;line-height:40px;color:#fff;cursor:pointer;text-align:center;}
        .background{width:100%;height:100vh;background-image:url("./static/img/download.webp");background-size:cover;background-position:center center;position:fixed;z-index:-999;left:0px;top:0px;}
        
        a{color:var(--color);}
        a:hover{text-decoration:none;color:#000;}

        div[role="alert"]{margin-top:30px;}
    </style>
</head>
<body>

<div class="container" id="app">
    <div class="background"></div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4 main mt-3 animated fadeInUp">
            <div class="bar"></div>    
            <p class="label">Your email:</p>
            <div class="input">
                <input type="email" v-model="email" placeholder="Input your email">
            </div>
            <p class="label">Your password:</p>
            <div class="input">
                <input type="password" v-model="password" placeholder="Input your password">
            </div>

            <div class="row submit">
                <div class="col-12 col-md-6">
                    <div class="login" @click="submit">login</div>
                </div>
                <div class="col-12" style="text-align:center;">
                    <a href="sign_up.php">sign up</a>
                </div>
            </div>

            <div class="alert alert-warning alert-dismissible" role="alert" v-if="isAlert">
                <strong>Error: </strong> {{ msg }}
                <button type="button" class="close" @click="isAlert = false">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>

    </div>

</div>


    
<script src="./node_modules/vue/dist/vue.min.js"></script>
<script src="./node_modules/axios/dist/axios.min.js"></script>
<script src="./node_modules/qs/dist/qs.js"></script>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./node_modules/js-cookie/src/js.cookie.js"></script>
<script>
let vm = new Vue({
    el:"#app",
    data:{
        email:"397317382@qq.com",
        password: "123456",
        msg: "",
        isAlert: false,
    },
    mounted() {
        
    },
    methods: {
        submit(){
            let data = {
                email: this.email,
                password: this.password,
            };
            axios.post("api_user.php", Qs.stringify(data)).then(res => {
                let response = res.data;
                if (response.code === -1) {
                    this.msg = response.msg;
                    this.isAlert = true;
                    return;
                }
                Cookies.set('music_token', response.data, { expires: 1 });
                window.location.href = 'index.php';
            })
        }





    },
})
</script>
</body>
</html>