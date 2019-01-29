<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .login{
            margin: 0 auto;
            width: 1200px;
        }
        .login .container{
            margin: 150px auto;
            width: 400px;
        }
        .login .container h1{
            font-weight: 400;
            font-size: 36px;
            margin-bottom:50px;
        }
        .login .container .btn{
            width: 100%;
            margin-top: 30px;
            height: 48px;
        }
        .login .container .el-form-item__label{
            line-height:40px;
            font-size:14px;
        }
        .login .container .el-input__inner{
            height: 48px;
            border-radius:3px;
            font-size:14px;
            padding-left:20px;
            /* border: solid 1px $separateLineColor1; */
        }
        </style>
    <link rel="stylesheet" href="/mp/el-index.css">
</head>
<body>
<div class="login" id="login">
    <div class="container">
        <h1>欢迎登录</h1>
        <el-form
                :rules="loginRules"
                :model="loginForm"
                ref="loginForm"
                :hide-required-asterisk="true"
        >
            <el-form-item label="账户名" prop="userName">
                <el-input placeholder="请输入用户名" v-model="loginForm.userName"></el-input>
            </el-form-item>
            <el-form-item label="密码"  prop="password">
                <el-input placeholder="请输入密码" v-model="loginForm.password"></el-input>
            </el-form-item>
            <el-form-item class="btnBox">
                <el-button class="btn" type="primary">登  录</el-button>
            </el-form-item>
        </el-form>
    </div>
</div>

<script src="/mp/vue.js"></script>
<script src="/mp/el-index.js"></script>
<script src="/mp/axios.min.js"></script>
<script>
    new Vue({
        el:"#login",
        data:{
            loginForm:{
                userName:"",
                password:""
            },
            loginRules:{
                userName:{required:true,message:"请输入用户名",trigger:"blur"},
                password:{required:true,message:"请输入用户名",trigger:"blur"}
            }
        }
    })
</script>
</body>
</html>