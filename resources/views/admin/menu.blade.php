<style>
    .custom-tree-node {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 20px;
        padding-right: 8px;
    }
</style>
<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title"
         style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px;margin-bottom:30px;">
        <h3 style="line-height: 1;color: deepskyblue">后台菜单</h3>
    </div>


    <el-card shadow="hover" style="margin:auto 30px;">
        <div slot="header" class="clearfix">
            <el-form :inline="true">
                <el-form-item label="菜单名称">
                    <el-input v-model="searchData.name" placeholder="菜单名称" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="显示">
                    <el-select v-model="searchData.status" placeholder="显示" size="mini">
                        <el-option label="全部" value=""></el-option>
                        <el-option label="显示" value="1"></el-option>
                        <el-option label="不显示" value="2"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="写日志">
                    <el-select v-model="searchData.write_log" placeholder="写日志" size="mini">
                        <el-option label="全部" value=""></el-option>
                        <el-option label="写日志" value="1"></el-option>
                        <el-option label="不写日志" value="2"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSearch" size="mini">查询</el-button>
                    <el-button @click="refreshSearch" size="mini">重置查询</el-button>
                    <el-button type="primary" @click="addTop" size="mini" style="margin-left: 40px;">添加顶级菜单</el-button>
                </el-form-item>
            </el-form>
        </div>

        <el-tree :data="menuData"
                 :props="defaultProps"
                 node-key="id"
                 ref="tree"
                 show-checkbox
                 accordion>

                <span class="custom-tree-node" slot-scope="{ node, data }" style="text-align: right">
                    <span>@{{ node.label }}</span>

                    <span>
                        <el-tag type="info" size="mini" style="margin-right: 20px;width: 100px;text-align: center">
                          排序：@{{ data.listorder}}
                      </el-tag>
                        <el-tag type="info" size="mini" style="margin-right: 20px;width: 300px;text-align: center">
                          @{{ data.m+'/'+data.c+'/'+data.a }}
                      </el-tag>
                      <el-tag type="info" size="mini" style="margin-right: 20px;width: 100px;text-align: center">
                          @{{ data.status == 1?'显示菜单':'不显示菜单' }}
                      </el-tag>
                        <el-tag type="info" size="mini" style="margin-right: 20px;width: 100px;text-align: center">
                          @{{ data.write_log == 1?'写日志':'不写日志' }}
                      </el-tag>
                      <el-tag
                              size="mini"
                              @click.native.stop="() => showAddDialog(data)">
                        添加
                      </el-tag>
                        <el-tag
                                type="success"
                                size="mini"
                                @click.native.stop="() => showEditDialog(data)">
                        编辑
                      </el-tag>
                      <el-tag
                              type="danger"
                              size="mini"
                              @click.native.stop="() => remove(data.id)">
                        删除
                      </el-tag>
                    </span>
                </span>
        </el-tree>

        <div style="text-align: center;margin-top: 30px;">
            <el-button type="primary" @click="deleteChecked">删除选中</el-button>
        </div>
    </el-card>


    <el-dialog :title="dialogTitle" :visible.sync="showEdit" center>
            <el-form label-width="100px" style="margin-right:30px;margin-bottom:50px;">
                <el-form-item label="上级菜单">
                    <el-select v-model="editData.parentid" placeholder="上级菜单">
                        <el-option v-for="(name,key) in menuSelect" :key="key" :label="name" :value="Number(key)"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="图标">
                    <el-popover
                            placement="top-start"
                            width="500"
                            trigger="hover">
                        <div>
                            <h3>选择图标</h3>
                            <el-tag v-for="item in iconLists" :class="item" style="font-size: 26px;margin:5px;background-color:#fff;" @click.native.stop="editData.icon = item"></el-tag>
                        </div>
                        <el-input slot="reference" v-model="editData.icon"></el-input>
                    </el-popover>
                </el-form-item>
                <el-form-item label="菜单名称">
                    <el-input v-model="editData.name"></el-input>
                </el-form-item>
                <el-form-item label="模块名">
                    <el-input v-model="editData.m"></el-input>
                </el-form-item>
                <el-form-item label="控制器名">
                    <el-input v-model="editData.c"></el-input>
                </el-form-item>
                <el-form-item label="方法名">
                    <el-popover
                            placement="top-start"
                            width="200"
                            trigger="hover"
                            content="添加菜单时，方法名 为lists，则自动添加 add,del,edit(不显示)">
                        <el-input slot="reference" v-model="editData.a"></el-input>
                    </el-popover>
                </el-form-item>
                <el-form-item label="附加参数">
                    <el-input v-model="editData.data"></el-input>
                </el-form-item>
                <el-form-item label="排序">
                    <el-input v-model="editData.listorder"></el-input>
                </el-form-item>
                <el-form-item label="菜单显示">
                    <el-radio-group v-model="editData.status">
                        <el-radio :label="1">显示</el-radio>
                        <el-radio :label="2">不显示</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="日志">
                    <el-radio-group v-model="editData.write_log">
                        <el-radio :label="1">写日志</el-radio>
                        <el-radio :label="2">不写日志</el-radio>
                    </el-radio-group>
                </el-form-item>
            </el-form>
            <div style="text-align: center">
                <el-button type="primary" @click="onSubmit">确定</el-button>
            </div>
    </el-dialog>
</div>

<script>
    var _editData = {
        parentid:0,
        icon:'',
        name:'',
        m:'',
        c:'',
        a:'',
        data:'',
        listorder:999,
        status:1,
        write_log:2
    };
    var _searchData = {
        name: '',
        status: '',
        write_log: ''
    };
    var icon_lists = [
        'el-icon-remove',
        'el-icon-circle-plus',
        'el-icon-remove-outline',
        'el-icon-circle-plus-outline',
        'el-icon-close',
        'el-icon-check',


        'el-icon-circle-close',
        'el-icon-circle-check',
        'el-icon-circle-close-outline',
        'el-icon-circle-check-outline',
        'el-icon-zoom-out',
        'el-icon-zoom-in',

        'el-icon-d-caret',
        'el-icon-sort',
        'el-icon-sort-down',
        'el-icon-sort-up',
        'el-icon-tickets',
        'el-icon-document',


        'el-icon-goods',
        'el-icon-sold-out',
        'el-icon-news',
        'el-icon-message',
        'el-icon-date',
        'el-icon-printer',

        'el-icon-time',
        'el-icon-bell',
        'el-icon-mobile-phone',
        'el-icon-service',
        'el-icon-view',
        'el-icon-menu',

        'el-icon-more',
        'el-icon-more-outline',
        'el-icon-star-on',
        'el-icon-star-off',
        'el-icon-location',
        'el-icon-location-outline',
        'el-icon-phone',
        'el-icon-phone-outline',
        'el-icon-picture',
        'el-icon-picture-outline',
        'el-icon-delete',
        'el-icon-search',
        'el-icon-edit',
        'el-icon-edit-outline',
        'el-icon-rank',
        'el-icon-refresh',
        'el-icon-share',
        'el-icon-setting',
        'el-icon-upload',
        'el-icon-upload2',
        'el-icon-download',
        'el-icon-loading',
    ];
    new Vue({
        el: '#content',
        data: function () {
            return {
                iconLists:icon_lists,
                showEdit:false,
                dialogTitle:'',
                searchData: deepCopy(_searchData),
                editData:deepCopy(_editData),

                menuData: [],
                menuSelect: {},
                defaultProps: {
                    children: '_child',
                    label: 'name'
                }
            }
        },
        methods: {
            onSearch() {
                this._getData();
            },
            refreshSearch(){
                this.searchData = deepCopy(_searchData);
                this._getData();
            },
            showAddDialog(data) {
                this.showEdit=true;
                this.dialogTitle = '添加菜单';
                this.editData = deepCopy(_editData);
                this.editData.parentid = data.id;
            },
            addTop(){
                this.showEdit=true;
                this.dialogTitle = '添加菜单';
                this.editData = deepCopy(_editData);
                this.editData.parentid = 0;
            },
            showEditDialog(data){
                this.showEdit=true;
                this.dialogTitle = '编辑菜单';
                for(k in _editData){
                    this.editData[k] = data[k];
                }
                this.editData.id = data.id;
            },
            addIcon(item){
                  console.log(item);
            },
            onSubmit(){
                if(this.editData.id){
                    ajaxPost(this,'/admin/menu/edit',this.editData,'修改菜单..',()=>{
                        this.showEdit = false;
                        this._getData();
                    })
                }else{
                    ajaxPost(this,'/admin/menu/add',this.editData,'新增菜单..',()=>{
                        this.showEdit = false;
                        this._getData();
                    })
                }
            },
            remove(id) {
                this.$confirm('确定要删除吗？').then(()=>{
                    ajaxPost(this,'/admin/menu/del',{id},'删除菜单..',()=>{
                        this._getData();
                    })
                })
            },
            // 删除选中
            deleteChecked() {
                let id = this.$refs.tree.getCheckedKeys();
                this.$confirm('确定要删除吗？').then(()=>{
                    ajaxPost(this,'/admin/menu/del',{id},'删除菜单..',()=>{
                        this._getData();
                    })
                })
            },
            _getData(){
                ajaxPost(this, '/admin/menu/index', this.searchData, '', (res) => {
                    this.menuData = res.allMenus;
                    this.menuSelect = res.selectMenus;
                })
            }
        },
        created() {
            this._getData();
        }
    })

</script>
