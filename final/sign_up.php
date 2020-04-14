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
    <link rel="stylesheet" type="text/css" href="./static/css/common.css">
    <style>

        .container{display:flex;align-items:center;min-height:100vh;overflow:hidden;}
        .justify-content-center{width:100%;}

        .main{height:auto;box-shadow:0px 0px 10px 0px rgba(80,80,80,.5);background-color:#fff;padding-bottom:30px;}        
        :root{
            --color: rgb(31,211,173);
        }
        .bar{width:100%;height:3px;background-color:var(--color);position:absolute;top:0px;left:0px;}
        .input{width:100%;height:35px;margin-top:15px;border-radius:30px;overflow:hidden;background-color:rgb(227,227,227);}
        .input input{width:100%;height:100%;border:none;outline:none;background-color:transparent;text-indent:15px;}
        .label{margin-bottom:-10px;margin-top:15px;}

        .submit{padding:10px 5px 0px;align-items:center;justify-content:center;margin-top:15px;}
        .submit .login{background-color:var(--color);height:40px;border-radius:5px;text-transform:capitalize;font-size:18px;line-height:40px;color:#fff;cursor:pointer;text-align:center;}
        .background{width:100%;height:100vh;background-image:url("./static/img/download.webp");background-size:cover;background-position:center center;position:fixed;z-index:-999;left:0px;top:0px;}

        a{color:var(--color);}
        a:hover{text-decoration:none;color:#000;}

        div[role="alert"]{margin-top:30px;}

        .animated{animation-duration:.4s;}

        @media (max-width:576px){
            .animated{animation-duration:.0s;margin-top:0px;}
            .container{padding:0px;}
            .container .row.justify-content-center{height:100vh;}
            .justify-content-center{margin-right:0px;margin-left:0px;}
        }      

        .animated{animation-duration:.4s;}

        @media (max-width:576px){
            .fadeInUp{animation-duration:.0s;margin-top:0px;}
            .container{padding:0px;}
            .container .row.justify-content-center{height:100vh;}
            .justify-content-center{margin-right:0px;margin-left:0px;}
        }
    </style>
</head>
<body>

<div class="container" id="app">
    <div class="background"></div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4 main animated fadeInUp">
            <div class="bar"></div>    
            <p class="label">Your email:</p>
            <div class="input">
                <input type="email" v-model="email" placeholder="Input your email">
            </div>

            <p class="label">Your password:</p>
            <div class="input">
                <input type="password" v-model="password" placeholder="Input your password">
            </div>

            <p class="label">Your password repeat:</p>
            <div class="input">
                <input type="password" v-model="re_password" placeholder="Input your password">
            </div>

            <div class="row submit">
                <div class="col-12 col-md-6">
                    <div class="login" @click="submit">Sign Up</div>
                </div>
                <div class="col-12 mt-2" style="text-align:center;">
                    <a href="login.php">login</a>
                </div>                
            </div>

            <div class="alert alert-warning alert-dismissible animated shake" role="alert" v-if="isAlert">
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
        email:"",
        password: "",
        re_password: "",
        msg: "",
        isAlert: false,
    },
    mounted() {
        
        
    },
    methods: {
        submit(){
            // validate form data
            if (this.password !== this.re_password) {
                this.msg = "Two passwords are inconsistent";
                this.isAlert = true;          
                return;      
            }

            let data = {
                email: this.email,
                password: this.password,
                sign: 1,
            };

            // serialize the form data and POST request
            axios.post("api_user.php", Qs.stringify(data)).then(res => {
                let response = res.data;
                if (response.code === -1) {
                    this.msg = response.msg;
                    this.isAlert = true;
                    return;
                }
                // set cookies
                Cookies.set('music_token', response.data, { expires: 1 });
                window.location.href = 'index.php'; // redirect
            })
        }
        




    },
})
</script>
</body>
</html>
