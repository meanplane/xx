@include('common.table')
@include('common.editDialog')
<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title"
         style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px;margin-bottom:30px;">
        <h3 style="line-height: 1;color: deepskyblue">{{$menu_info->name or ''}}</h3>
    </div>

    <mp-table :show-search="true" :search-opts="searchOpts" search-url="/admin/group/lists" ref="mpTable">
        <template slot="extra-btns">
            <el-button  type="primary" style="margin-left:60px;" size="mini">新增权限组</el-button>
        </template>
        <template slot="tb-content">
            <el-table-column
                    prop="id"
                    label="ID"
                    width="50">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="权限组名字">
            </el-table-column>
            <el-table-column
                    label="描述"
                    prop="description">
            </el-table-column>
            <el-table-column
                    align="center"
                    label="创建时间"
                    :formatter="(row)=>formatTime(row.created_at)"
                    width="160">
            </el-table-column>
            <el-table-column
                    align="center"
                    label="修改时间"
                    :formatter="(row)=>formatTime(row.updated_at)"
                    width="160">
            </el-table-column>
            <el-table-column
                    label="操作"
                    align="center"
                    width="320">
                <template slot-scope="scope">
                    <el-button-group>
                        <el-button
                                size="mini" plain
                                @click="showEdit(scope.row)">编辑
                        </el-button>
                        <el-button size="mini" type="danger"
                                   @click="delUser(scope.row.id)">删除
                        </el-button>
                    </el-button-group>
                </template>
            </el-table-column>
        </template>
    </mp-table>

    <el-dialog title="编辑权限" :visible.sync="showEditPassDialog" center width="500">

    </el-dialog>

</div>

<script>

    new Vue({
        el: '#content',
        data: function () {
            return {
                searchOpts: [
                     {label:'账号名',type:'input',place:'权限组名字',word:'name',default:''},
                ],

                showEditPassDialog: false,
                editPass: {id:'', password:''}
            }
        },
        methods: {
            // table format
            formatTime(row) {
                return moment(row * 1000).format('YYYY-MM-DD HH:mm:ss')
            },

            showEdit(row){
                this.$refs.mpDialog.showEdit(row);
            },

            _getData(){
                this.$refs.mpTable._getData();
            },

            showEditPass(row) {
                this.showEditPassDialog = true;
                this.editPass.id = row.id;
                this.editPass.password = '';
            },
            onEditPass() {
                if(this.editPass.password.length < 3 || this.editPass.password.length > 8){
                    this.$message.error('密码应该为 3-8位之间');
                    return;
                }
                this.showEditPassDialog = false;
                ajaxPost(this,'/admin/user/changePwd',this.editPass)
            },

            // 禁用
            disableUser(id,status) {
                var msg = (status === 1) ?'确定要解除禁用吗？':'确定要封禁吗？';
                this.$confirm(msg).then(()=>{
                    ajaxPost(this,'/admin/user/edit',{id,status},null,()=>{
                        this.$refs.mpTable._getData();
                    })
                })
            },

            // 删除
            delUser(id){
                this.$confirm('确定要删除此账号吗？').then(()=>{
                    ajaxPost(this,'/admin/user/del',{id},null,()=>{
                        this.$refs.mpTable._getData();
                    })
                })
            }
        }
    })

</script>