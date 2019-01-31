<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/mp/el-index.css">
    <script src="/mp/jquery.min.js"></script>
    <script src="/mp/vue.js"></script>
    <script src="/mp/el-index.js"></script>
    <script src="/mp/axios.min.js"></script>
    <script src="/mp/mp.js"></script>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .el-dropdown-link.el-dropdown-selfdefine {
        display: inline-block;
        height: 100%;
        color: #fff;
    }

    .el-dropdown-menu.el-popper {
        top: 54px !important;
        z-index: 999999 !important;
    }

    .el-menu {
        border-right: none !important;
    }

    body {
        overflow-x: hidden;
    }

    #head header {
        line-height: 60px;
        display: flex;
        justify-content: space-between;
        padding: 0 20px;
        box-sizing: border-box;
        position: fixed;
        z-index: 100;
        width: 100%;
        background: #0e90d2;
        color: #fff;
    "
    }

    .content {
        position: relative;
        top: 0px;
        width: 100%;
        height: calc(100vh - 60px);
        display: flex;
    }

    #left-menu {
        display: inline-block;
        width: 200px;
        height: 100%;
        margin-top: 60px;
    }

    #main {
        width: calc(100vw - 200px);
        height: 100%;
        overflow: auto;
        margin-top: 60px;
    }

    [v-cloak]{
        display: none;
    }
</style>
<body>
<div id="head" v-cloak>
    <header>
        <h3 class="left" style="margin-left:40px;">后台管理模板</h3>
        <div class="right" style="margin-right:40px;">
            <el-dropdown >
                <span class="el-dropdown-link">管理员
                   <i class="el-icon-arrow-down el-icon--right"></i>
                </span>
                <el-dropdown-menu slot="dropdown"  split-button="true">
                    <el-dropdown-item  @click.native="updateInfo" ><i class="el-icon-edit"></i>   更新资料</el-dropdown-item>
                    <el-dropdown-item @click.native="updatePass"><i class="el-icon-refresh"></i>   更新密码</el-dropdown-item>
                    <el-dropdown-item divided @click.native="logout"><i class="el-icon-close"></i>   退出系统</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
    </header>
</div>

<div class="content">
    <div id="left-menu" v-cloak>
        <div class="aside" style="height: 100%;border-right: solid 1px #e6e6e6;">
            <el-menu
                    default-active="2"
                    class="el-menu-vertical-demo">
                <el-submenu index="1">
                    <template slot="title">
                        <i class="el-icon-location"></i>
                        <span>导航一</span>
                    </template>
                    <el-menu-item-group>
                        <el-menu-item index="1-1">选项1</el-menu-item>
                        <el-menu-item index="1-2">选项2</el-menu-item>
                        <el-menu-item index="1-3">选项3</el-menu-item>
                    </el-menu-item-group>
                    <el-submenu index="1-4">
                        <template slot="title">选项4</template>
                        <el-menu-item index="1-4-1">选项1</el-menu-item>
                    </el-submenu>
                </el-submenu>
                <el-menu-item index="2">
                    <i class="el-icon-menu"></i>
                    <span slot="title">导航二</span>
                </el-menu-item>
                <el-menu-item index="3">
                    <i class="el-icon-setting"></i>
                    <span slot="title">导航四</span>
                </el-menu-item>
            </el-menu>
        </div>
    </div>
    {{--<div id="main">--}}
        {{--<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;">--}}
            {{--<div class="title" style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px">--}}
                {{--<h3 style="line-height: 1;color: deepskyblue">表单 / form</h3>--}}
            {{--</div>--}}
            {{----}}
        {{--</div>--}}
    {{--</div>--}}
    <div id="main">

    </div>
</div>

<script>
    // head
    new Vue({
        el: '#head',
        data: function () {
            return {}
        },
        methods: {
            updateInfo(){
                getPage(this,'/admin/index/updateInfo');
            },
            updatePass(){
                getPage(this,'/admin/index/updatePass');
            },
            logout(){
                ajaxPost(this,'/admin/login/logout',{},'登出...',(res)=>{
                    setTimeout(()=>{
                        jumpTo(res.url);
                    },500);
                })
            },
        }
    });

    // left-menu
    new Vue({
        el: '#left-menu',
        data: function () {
            return {}
        },
        methods: {}
    })
</script>


</body>

</html>
