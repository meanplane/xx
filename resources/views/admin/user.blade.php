@include('common.table')
@include('common.editDialog')
<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title"
         style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px;margin-bottom:30px;">
        <h3 style="line-height: 1;color: deepskyblue">{{$menu_info->name or ''}}</h3>
    </div>

    <mp-table :show-search="true" :search-opts="searchOpts" search-url="/admin/user/lists" ref="mpTable">
        <template slot="extra-btns">
            <el-button @click="showAdd" type="primary" style="margin-left:60px;">新增管理员</el-button>
            <el-button @click="()=>this.$refs.mpDialog.showEdit()" type="primary" style="margin-left:60px;">test</el-button>
        </template>
        <template slot="tb-content">
            <el-table-column
                    prop="id"
                    label="ID"
                    width="50">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="账号">
            </el-table-column>
            <el-table-column
                    label="真名"
                    prop="realname">
            </el-table-column>
            <el-table-column
                    prop="level"
                    label="级别"
                    :formatter="(row)=>levels[row.level] ">
            </el-table-column>
            <el-table-column
                    :formatter="(row)=>showGroups(row)"
                    label="角色">
            </el-table-column>
            <el-table-column
                    label="状态">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.status == 1" type="success" size="mini">正常</el-tag>
                    <el-tag v-else type="danger" size="mini">已禁用</el-tag>
                </template>
            </el-table-column>
            <el-table-column
                    label="创建时间"
                    :formatter="(row)=>formatTime(row.created_at)"
                    width="100">
            </el-table-column>
            <el-table-column
                    label="修改时间"
                    :formatter="(row)=>formatTime(row.updated_at)"
                    width="100">
            </el-table-column>
            <el-table-column
                    prop="href"
                    label="操作"
                    align="center"
                    width="320">
                <template slot-scope="scope">
                    <el-button-group>
                        <el-button
                                size="mini" plain
                                @click="showEdit(scope.row)">编辑
                        </el-button>
                        <el-button
                                size="mini" plain
                                @click="showEditPass(scope.row)">修改密码
                        </el-button>
                        <el-button v-if="scope.row.status == 1" size="mini" type="danger" plain
                                   @click="disableUser(scope.row.id,2)">禁用
                        </el-button>
                        <el-button v-else size="mini" type="success" plain
                                   @click="disableUser(scope.row.id,1)">解禁
                        </el-button>
                    </el-button-group>
                    <el-button size="mini" type="danger"
                               @click="delUser(scope.row.id)">删除
                    </el-button>
                </template>
            </el-table-column>
        </template>
    </mp-table>

    {{-- 添加用户 --}}
    <el-dialog :title="editTitle" :visible.sync="showEditDialog" center width="1000">
        <el-form label-width="100px" style="margin-right:30px;margin-bottom:50px;">
            <el-form-item label="账号">
                <el-input v-model="editData.name"></el-input>
            </el-form-item>
            <el-form-item label="密码" >
                <el-input v-model="editData.password" :disabled="showPass"></el-input>
            </el-form-item>
            <el-form-item label="真实姓名">
                <el-input v-model="editData.realname"></el-input>
            </el-form-item>
            <el-form-item label="手机号">
                <el-input v-model="editData.mobile"></el-input>
            </el-form-item>
            <el-form-item label="级别">
                <el-select v-model="editData.level">
                    <el-option v-for="(name,key) in levels" :label="name" :value="Number(key)"></el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="角色">
                <el-checkbox-group v-model="editData.groups">
                    <el-checkbox v-for="(name,key) in roles" :label="Number(key)" :key="Number(key)">@{{name}}</el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <el-form-item label="状态">
                <el-select v-model="editData.status">
                    <el-option v-for="(name,key) in statuss" :label="name" :value="Number(key)"></el-option>
                </el-select>
            </el-form-item>
        </el-form>
        <div style="text-align: center">
            <el-button type="primary" @click="onSubmit">确定</el-button>
        </div>
    </el-dialog>

    <el-dialog title="修改密码" :visible.sync="showEditPassDialog" center width="500">
        <el-form label-width="100px" style="margin-right:30px;margin-bottom:50px;">
            <el-form-item label="新密码" >
                <el-input v-model.trim="editPass.password"></el-input>
            </el-form-item>
        </el-form>
        <div style="text-align: center">
            <el-button type="primary" @click="onEditPass">确定</el-button>
        </div>
    </el-dialog>

    {{--<mp-edit-dialog ref="mpDialog"></mp-edit-dialog>--}}
</div>

<script>
    var _editData={
        name:'',
        password:'',
        realname:'',
        mobile:'',
        level:1,
        groups:[],
        status:1
    };
    new Vue({
        el: '#content',
        data: function () {
            return {
                levels: @json($levels),
                roles: @json($roles),
                statuss: @json($statuss),

                searchOpts: [
                     {label:'账号名',type:'input',place:'菜单名',word:'name',default:''},
                     {label:'状态',type:'select',options:{'':'全部',1:'正常',2:'禁用'},word:'status',default:''}
                ],
                editOpts:[
                    {label:'账号名',type:'input',place:'账号名',word:'name',default:''},
                    {label:'密码',type:'input',place:'密码',word:'password',default:''},
                    {label:'真实姓名',type:'input',place:'姓名',word:'realname',default:''},
                    {label:'手机号',type:'input',place:'手机号',word:'mobile',default:''},

                    {label:'级别',type:'select',options:deepCopy(this.levels),word:'level',default:1},
                    {label:'角色',type:'check',options:deepCopy(this.roles),word:'groups',default:[]},
                    {label:'状态',type:'select',options:deepCopy(this.status),word:'status',default:1},
                ],


                showEditDialog: false,
                editTitle: '',
                editData: deepCopy(_editData),
                showPass:true,

                showEditPassDialog: false,
                editPass: {
                    id:'',
                    password:'',
                }
            }
        },
        methods: {
            // table format
            formatTime(row) {
                return moment(row * 1000).format('YYYY-MM-DD HH:mm:ss')
            },
            showGroups (row){
                if(!row.groups){
                    return '';
                }
                str = '';
                for(r of row.groups){
                    str += this.roles[r] + ' , ';
                }
                return str.slice(0,-3);
            },

            showAdd() {
                this.showEditDialog = true;
                this.showPass = false;
                this.editTitle = '添加管理员';
                this.editData = deepCopy(_editData);
            },
            showEdit(row) {
                this.showEditDialog = true;
                this.showPass = true;
                this.editTitle = '编辑管理员';
                for(var k in this.editData){
                    this.editData[k] = row[k];
                }
                delete(this.editData.password);
                this.editData.id = row.id;
                this.editData.groups = this.editData.groups || [];
            },
            onSubmit(){
                this.showEditDialog = false;
                if(this.editData.id){
                    ajaxPost(this, '/admin/user/edit', this.editData, null, () => {
                        this.$refs.mpTable._getData();
                    })
                }else{
                    ajaxPost(this, '/admin/user/add', this.editData, null, () => {
                        this.$refs.mpTable._getData();
                    })
                }
            },
//
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