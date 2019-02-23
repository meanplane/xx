@include('common.table')
@include('common.editDialog')
<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title"
         style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px;margin-bottom:30px;">
        <h3 style="line-height: 1;color: deepskyblue">{{$menu_info->name or ''}}</h3>
    </div>

    <mp-table :show-search="true" :search-opts="searchOpts" search-url="/admin/group/lists" ref="mpTable">
        <template slot="extra-btns">
            <el-button  type="primary" style="margin-left:60px;" size="mini" @click="showAdd">新增权限组</el-button>
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
                                   @click="delGroup(scope.row.id)">删除
                        </el-button>
                    </el-button-group>
                </template>
            </el-table-column>
        </template>
    </mp-table>

    <el-dialog :title="editTitle" :visible.sync="showEditDialog" center width="500" @open="onOpen">
        <el-form label-width="100px" style="margin-right:30px;margin-bottom:50px;">
            <el-form-item label="权限组名" >
                <el-input placeholder="权限组名"
                          v-model="editName" size="mini">
                </el-input>
            </el-form-item>
            <el-form-item label="描述" >
                <el-input placeholder="描述"
                          v-model="editDesc" size="mini">
                </el-input>
            </el-form-item>
        </el-form>
        <el-tree :data="menuData"
                 show-checkbox
                 :props="defaultProps"
                 node-key="id"
                 ref="mpTree">

                <span class="custom-tree-node" slot-scope="{ node, data }" style="text-align: right">
                    <span>@{{ node.label }}</span>
                </span>
        </el-tree>
        <div style="text-align: center">
            <el-button type="primary" @click="onSubmit" style="margin-top:30px;">提交</el-button>
        </div>
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

                menuData: @json($allMenus),

                defaultProps: {
                    children: '_child',
                    label: 'name'
                },

                showAddDialog:false,
                showEditDialog:false,
                editTitle:'',

                editId:'',
                editMenus:[],
                editName:'',
                editDesc:'',
            }
        },
        methods: {
            // table format
            formatTime(row) {
                return moment(row * 1000).format('YYYY-MM-DD HH:mm:ss')
            },

            _getData(){
                this.$refs.mpTable._getData();
            },

            delGroup(id){
                this.$confirm('确定要删除？').then(()=>{
                    ajaxPost(this,'/admin/group/del',{id},'删除用户组..',()=>{
                        this._getData();
                    })
                })
            },

            onOpen(){
                setTimeout(()=>{
                    this.$refs.mpTree.setCheckedKeys(this.editMenus);
                })
            },

            showEdit(row){
                this.showEditDialog = true;
                this.editTitle = '编辑权限组';
                this.editId = row.id;
                var menuArr = row.menus ? row.menus.split(',').map((item)=>Number(item)) : [];
                this.editMenus = deepCopy(menuArr);
                this.editName = row.name;
                this.editDesc = row.description;
            },

            showAdd(){
                this.showEditDialog = true;
                this.editTitle = '新增权限组';
                this.editId = '';
                this.editMenus = [];
                this.editName = '';
                this.editDesc = '';
            },

            onSubmit(){
                this.showEditDialog = false;
                var menus = this.$refs.mpTree.getCheckedKeys();
                menus = menus.join(',');
                if(!this.editId){ //add
                    ajaxPost(this,'/admin/group/add',{
                        name:this.editName,
                        description:this.editDesc,
                        menus:menus
                    },'新增权限组..',()=>{
                        this._getData();
                    })
                }else{ //edit
                    ajaxPost(this,'/admin/group/edit',{
                        name:this.editName,
                        description:this.editDesc,
                        menus:menus,
                        id:this.editId
                    },'编辑权限组..',()=>{
                        this._getData();
                    })
                }
            },
        },
    })

</script>