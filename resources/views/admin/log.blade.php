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

    <el-dialog title="日志详情" :visible.sync="showInfoDialog" center width="1000">
        <el-row :gutter="24">
            <el-col :span="12">
                <el-card>
                    <h2>info</h2>
                </el-card>
            </el-col>
            <el-col :span="12">
                <el-card>
                    <h2>lastInfo</h2>
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
                    // {label:'账号名',type:'input',place:'菜单名',word:'name',default:''},
                    // {label:'状态',type:'select',options:{'':'全部',1:'正常',2:'禁用'},word:'status',default:''}
                    {label: '操作时间', type: 'range', word: 'timeRange', default: []},
                    {label: '菜单名', type: 'input', place: '菜单名', word: 'menu', default: ''},
                    {label: '操作人', type: 'input', place: '操作人账号', word: 'user', default: ''},
                    {label: 'ip', type: 'input', place: 'ip地址', word: 'ip', default: ''},
                ],

                showInfoDialog: false,
                info: {},
                last_info: {}
            }
        },
        methods: {
            formatTime(row) {
                return moment(row * 1000).format('YYYY-MM-DD HH:mm:ss')
            },
            showInfo(row) {
//                console.log(row)
//                this.showInfoDialog = true;
                ajaxPost(this, '/admin/log/info', {id: row.id}, null, (res) => {
                    console.log(res)
                })
            },
        }
    })
</script>