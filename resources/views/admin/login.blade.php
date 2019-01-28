<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/mp/el-index.css">
</head>
<body>
<div class="login-container" id="login">

    <el-form ref="loginForm" :model="loginForm" :rules="loginRules" class="login-form" auto-complete="on" label-position="left">

        <div class="title-container">
            <h3 class="title"> title </h3>
        </div>

        <el-form-item prop="username">
        <span class="svg-container">
          <svg-icon icon-class="user" />
        </span>
            <el-input
                    v-model="loginForm.username"
                    placeholder="用户名"
                    name="username"
                    type="text"
                    auto-complete="on"
            />
        </el-form-item>

        <el-form-item prop="password">
        <span class="svg-container">
          <svg-icon icon-class="password" />
        </span>
            <el-input
                    type="password"
                    v-model="loginForm.password"
                    placeholder="密码"
                    name="password"
                    auto-complete="on"
                    @keyup.enter.native="handleLogin" />
            <span class="show-pwd" @click="showPwd">
          <svg-icon icon-class="eye" />
        </span>
        </el-form-item>

        <el-button :loading="loading" type="primary" style="width:100%;margin-bottom:30px;" @click.native.prevent="handleLogin">登  录</el-button>



        <el-button class="thirdparty-button" type="primary" @click="showDialog=true">第三方登录</el-button>
    </el-form>

</div>

<script src="/mp/vue.js"></script>
<script src="/mp/el-index.js"></script>
<script src="/mp/axios.min.js"></script>
<script>
    const validateUsername = (rule, value, callback) => {
        if (!isvalidUsername(value)) {
            callback(new Error('Please enter the correct user name'))
        } else {
            callback()
        }
    };
    const validatePassword = (rule, value, callback) => {
        if (value.length < 6) {
            callback(new Error('The password can not be less than 6 digits'))
        } else {
            callback()
        }
    };
    // head
    new Vue({
        el: '#login',
        data() {

            return {
                showDialog : false,
                loginForm:{
                    username:'admin',
                    password:'111111'
                },
                loginRules: {
                    username: [{ required: true, trigger: 'blur', validator: validateUsername }],
                    password: [{ required: true, trigger: 'blur', validator: validatePassword }]
                },
                passwordType: 'password',
                    loading: false,
                    showDialog: false,
                    redirect: undefined
                }
        },
        methods: {
            showPwd() {
                if (this.passwordType === 'password') {
                    this.passwordType = ''
                } else {
                    this.passwordType = 'password'
                }
            },
        }
    });


</script>
</body>
</html>