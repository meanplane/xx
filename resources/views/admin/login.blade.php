<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>xx后台管理系统</title>
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
        <h1 style="text-align: center;color: #F56C6C">xx后台管理</h1>
        <el-form
                :rules="loginRules"
                :model="loginForm"
                ref="loginForm"
                :hide-required-asterisk="true"
        >
            <el-form-item  prop="name" label="用户名">
                <el-input type="text" autocomplete="off" clearable placeholder="请输入用户名" v-model="loginForm.name"></el-input>
            </el-form-item>
            <el-form-item  prop="password" label="密码">
                <el-input type="password" autocomplete="off" clearable  placeholder="请输入密码" v-model="loginForm.password"></el-input>
            </el-form-item>
            <el-form-item >
                <el-checkbox v-model="is_remember">保存密码</el-checkbox>
            </el-form-item>
            <el-form-item class="btnBox">
                <el-button class="btn" type="primary" @click="onLogin('loginForm')">登  录</el-button>
            </el-form-item>
        </el-form>
    </div>
</div>

<script src="/mp/vue.js"></script>
<script src="/mp/el-index.js"></script>
<script src="/mp/axios.min.js"></script>
<script src="/mp/mp.js"></script>
<script>
    new Vue({
        el:"#login",
        data:{
            loginForm:{
                is_remember:false,
                name:"",
                password:""
            },
            loginRules:{
                name:[
                    {required:true,message:"请输入用户名",trigger:"blur"},
                    {min:3,max:12,message:"长度在3-12个字符",trigger:"blur"},
                ],
                password:[
                    {required:true,message:"请输入密码",trigger:"blur"},
                    {min:3,max:12,message:"长度在3-12个字符",trigger:"blur"},
                ]
            }
        },
        methods:{
            onLogin(loginName){
                var _this = this;
                this.$refs[loginName].validate((valid)=>{
                    if(valid){
                        axios.post('/admin/login/login',_this.loginForm,{headers:{'X-Requested-With':'XMLHttpRequest'}})
                            .then((res)=>{
//                                if(res.data && res.data.code && res.data.code == 1){
//
//                                }
                                console.log(res);
                            })
                    }else{
                        return false;
                    }
                })
            }
        }
    })
</script>
</body>
</html>