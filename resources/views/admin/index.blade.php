<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>xx管理系统</title>
    <link rel="stylesheet" href="/mp/el-index.css">
    <link rel="stylesheet" href="/layui/css/layui.css">

    <script src="/mp/jquery.min.js"></script>
    <script src="/layui/layui.all.js"></script>
    <script src="/mp/vue.js"></script>
    <script src="/mp/el-index.js"></script>
    <script src="/mp/axios.min.js"></script>
    <script src="/mp/moment.js"></script>
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

    [v-cloak] {
        display: none;
    }
</style>
<body>
<div id="head" v-cloak>
    <header>
        <h3 class="left" style="margin-left:40px;">后台管理模板</h3>
        <div class="right" style="margin-right:40px;">
            <el-dropdown>
                <span class="el-dropdown-link">管理员
                   <i class="el-icon-arrow-down el-icon--right"></i>
                </span>
                <el-dropdown-menu slot="dropdown" split-button="true">
                    <el-dropdown-item @click.native="updateInfo"><i class="el-icon-edit"></i> 更新资料</el-dropdown-item>
                    <el-dropdown-item @click.native="updatePass"><i class="el-icon-refresh"></i> 更新密码</el-dropdown-item>
                    <el-dropdown-item divided @click.native="logout"><i class="el-icon-close"></i> 退出系统
                    </el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
    </header>
</div>

<div class="content">
    <div id="left-menu" v-cloak>
        <div class="aside" style="height: 100%;border-right: solid 1px #e6e6e6;">
            <el-menu
                    class="el-menu-vertical-demo"
                    @select="handleSelect">
                @foreach($menuTree as $menu)
                    @if(isset($menu['_child']))
                        <el-submenu index="{{ $menu['m'].'/'.$menu['c'].'/'.$menu['a'] }}">
                            <template slot="title">
                                @if(!empty($menu['icon']))
                                    <i class="{{$menu['icon'] }}"></i>
                                @endif
                                <span>{{$menu['name']}}</span>
                            </template>

                            @foreach($menu['_child'] as $m1)
                                <el-menu-item index="/{{ $m1['m'].'/'.$m1['c'].'/'.$m1['a'].'?'.$m1['data'] }}">
                                    {{--<i class="el-icon-menu"></i>--}}
                                    @if(!empty($m1['icon']))
                                        <i class="{{$m1['icon'] }}"></i>
                                    @endif
                                    <span slot="title">{{$m1['name']}}</span>
                                </el-menu-item>
                            @endforeach

                        </el-submenu>
                    @else
                        <el-menu-item index="/{{ $menu['m'].'/'.$menu['c'].'/'.$menu['a'].'?'.$menu['data'] }}">
                            {{--<i class="el-icon-menu"></i>--}}
                            @if(!empty($menu['icon']))
                                <i class="{{$menu['icon'] }}"></i>
                            @endif
                            <span slot="title">{{$menu['name']}}</span>
                        </el-menu-item>
                    @endif
                @endforeach
            </el-menu>
        </div>
    </div>

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
            updateInfo() {
                getPage(this, '/admin/index/updateInfo');
            },
            updatePass() {
                getPage(this, '/admin/index/updatePass');
            },
            logout() {
                ajaxPost(this, '/admin/login/logout', {}, '登出...', (res) => {
                    jumpTo(res.url, 500);
                })
            },
        }
    });

    // left-menu
    new Vue({
        el: '#left-menu',
        data: function () {
            return {
                menuTree:@json($menuTree)
            }
        },
        methods: {
            handleSelect(key) {
                getPage(this,key);
            }
        },
        created() {
            // console.log(this.menuTree);
        }
    })
</script>


</body>

</html>
