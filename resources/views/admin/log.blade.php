@include('common.table')
@include('common.editDialog')
<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title"
         style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px;margin-bottom:30px;">
        <h3 style="line-height: 1;color: deepskyblue">{{$menu_info->name}}</h3>
    </div>
    <mp-table :show-search="true" :search-opts="searchOpts" :search-url="'/admin/log/lists'" ref="mpTable">
        <template slot="tb-content">
            <el-table-column
                    prop="created_at"
                    label="时间"
                    :formatter="(row)=>formatTime(row.created_at)"
                    width="240">
            </el-table-column>
            <el-table-column
                    prop="menu_name"
                    label="菜单名">
            </el-table-column>
            <el-table-column
                    label="请求地址"
                    :formatter="(row)=> row.c+'/'+row.a ">
            </el-table-column>
            <el-table-column
                    prop="ip"
                    label="IP地址">
            </el-table-column>
            <el-table-column
                    prop="admin_name"
                    label="操作人">
            </el-table-column>
            <el-table-column
                    prop="href"
                    label="操作"
                    width="100"
                    align="center">
                <template slot-scope="scope">
                    <el-button
                            size="mini"
                            @click="showInfo(scope.row)">查看
                    </el-button>
                </template>
            </el-table-column>
        </template>
    </mp-table>

    <el-dialog title="日志详情" :visible.sync="showInfoDialog" center width="60%">
        <el-row :gutter="24">
            <el-col :span="12">
                <el-card  :body-style="{ padding: '0px' }">
                    <div slot="header" class="clearfix">
                        <el-tag type="primary">本次操作记录 @{{info.id}}</el-tag>
                    </div>
                    <table class="layui-table" lay-skin="nob">
                        <tbody>
                        <tr>
                            <td width="80px" align="center"><b>菜单名</b></td>
                            <td>@{{ info.name }}</td>
                        </tr>
                        <tr>
                            <td width="80px" align="center"><b>用户</b></td>
                            <td>@{{ info.user }}</td>
                        </tr>
                        <tr>
                            <td width="80px" align="center"><b>时间</b></td>
                            <td>@{{ formatTime(info.created_at) }}</td>
                        </tr>
                        <tr>
                            <td width="80px" align="center"><b>ip</b></td>
                            <td>@{{ info.ip }}</td>
                        </tr>
                        <tr>
                            <td width="80px" align="center"><b>请求地址</b></td>
                            <td>@{{ info.c +'/'+ info.a }}</td>
                        </tr>
                        <tr>
                            <td width="80px" align="center"><b>post数据</b></td>
                            <td>
                                <div v-for="(item,k) in info.data">
                                    @{{k + '  ->  ' + item}}
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </el-card>
            </el-col>
            <el-col :span="12">
                <el-card  :body-style="{ padding: '0px' }">
                    <div slot="header" class="clearfix">
                        <el-tag type="info">原始记录</el-tag>
                    </div>
                    <table class="layui-table" lay-skin="nob" v-if="lastInfo.id">
                        <tbody>
                        <tr>
                            <td width="80px" align="center"><b>菜单名</b></td>
                            <td>@{{ lastInfo.name }}</td>
                        </tr>
                        <tr>
                            <td width="80px" align="center"><b>用户</b></td>
                            <td>@{{ lastInfo.user }}</td>
                        </tr>
                        <tr>
                            <td width="80px" align="center"><b>时间</b></td>
                            <td>@{{ formatTime(lastInfo.created_at) }}</td>
                        </tr>
                        <tr>
                            <td width="80px" align="center"><b>ip</b></td>
                            <td>@{{ lastInfo.ip }}</td>
                        </tr>
                        <tr>
                            <td width="80px" align="center"><b>请求地址</b></td>
                            <td>@{{ lastInfo.c +'/'+ lastInfo.a }}</td>
                        </tr>
                        <tr>
                            <td width="80px" align="center"><b>post数据</b></td>
                            <td>
                                <div v-for="(item,k) in info.data">
                                    @{{k + '  ->  ' + item}}
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </el-card>
            </el-col>
        </el-row>
    </el-dialog>
</div>

<script>
    new Vue({
        el: '#content',
        data: function () {
            return {
                searchOpts: [
                    {label: '操作时间', type: 'range', word: 'timeRange', default: []},
                    {label: '菜单名', type: 'input', place: '菜单名', word: 'menu', default: ''},
                    {label: '操作人', type: 'input', place: '操作人账号', word: 'user', default: ''},
                    {label: 'ip', type: 'input', place: 'ip地址', word: 'ip', default: ''},
                ],

                showInfoDialog: false,
                info: {},
                lastInfo: {}
            }
        },
        methods: {
            formatTime(row) {
                return moment(row * 1000).format('YYYY-MM-DD HH:mm:ss')
            },
            showInfo(row) {
                ajaxPost(this, '/admin/log/info', {id: row.id}, null, (res) => {
                    this.info = res.info;
                    this.lastInfo = res.last_info;
                    this.showInfoDialog = true;
                })
            },
        }
    })
</script>