@include('common.table')
@include('common.editDialog')
<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title"
         style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px;margin-bottom:30px;">
        <h3 style="line-height: 1;color: deepskyblue">{{$menu_info->name or ''}}</h3>
    </div>

    <mp-table :show-search="true" :search-opts="searchOpts" :search-url="'/admin/log/lists'" ref="mpTable">
        <template slot="extra-btns">
            <el-button @click="()=>this.$refs.mpTable._getData()">xx</el-button>
        </template>
        <template slot="tb-content">
            <el-table-column
                    prop="created_at"
                    label="时间"
                    :formatter="(row)=>formatTime(row.created_at)"
                    width="240">
            </el-table-column>
            <el-table-column
                    prop="menu_name"
                    label="菜单名"
                    width="200">
            </el-table-column>
            <el-table-column
                    label="请求地址"
                    :formatter="(row)=> row.c+'/'+row.a "
                    width="200">
            </el-table-column>
            <el-table-column
                    prop="ip"
                    label="IP地址">
            </el-table-column>
            <el-table-column
                    prop="admin_name"
                    label="操作人"
                    width="200">
            </el-table-column>
        </template>
    </mp-table>
    <mp-edit-dialog></mp-edit-dialog>
</div>

<script>
    new Vue({
        el: '#content',
        data: function () {
            return {
                searchOpts:[
                    // {label:'账号名',type:'input',place:'菜单名',word:'name',default:''},
                    // {label:'状态',type:'select',options:{'':'全部',1:'正常',2:'禁用'},word:'status',default:''}
                    {label:'菜单名',type:'input',place:'菜单名',word:'menu',default:''},
                    {label:'操作人',type:'input',place:'操作人账号',word:'user',default:''},
                    {label:'ip',type:'input',place:'ip地址',word:'ip',default:''},
                ],
            }
        },
        methods: {
            formatTime(row){
                return moment(row * 1000).format('YYYY-MM-DD HH:mm:ss')
            }
        }
    })
</script>