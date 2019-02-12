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


    <el-card style="margin:auto 30px;">
        <div slot="header" class="clearfix">
            <el-form :inline="true" :model="searchData" class="demo-form-inline">
                <el-form-item label="菜单名称">
                    <el-input v-model="searchData.name" placeholder="菜单名称"></el-input>
                </el-form-item>
                <el-form-item label="显示">
                    <el-select v-model="searchData.status" placeholder="显示">
                        <el-option label="全部" value=""></el-option>
                        <el-option label="显示" value="1"></el-option>
                        <el-option label="不显示" value="2"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="写日志">
                    <el-select v-model="searchData.write_log" placeholder="写日志">
                        <el-option label="全部" value=""></el-option>
                        <el-option label="写日志" value="1"></el-option>
                        <el-option label="不写日志" value="2"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSearch">查询</el-button>
                    <el-button @click="refreshSearch">重置查询</el-button>
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
                              @click.native.stop="() => add(data.id)">
                        添加
                      </el-tag>
                        <el-tag
                                type="success"
                                size="mini"
                                @click.native.stop="() => edit(data)">
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
                        <el-option v-for="(key,name) in menuSelect" :label="key" :value="name"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="图标">
                    <el-input v-model="editData.icon"></el-input>
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
                    <el-input v-model="editData.a"></el-input>
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
                <el-button type="primary" >确定</el-button>
            </div>
    </el-dialog>
</div>

<script>
    var _editData = {
        parentid:'0',
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
    new Vue({
        el: '#content',
        data: function () {
            return {
                showEdit:false,
                dialogTitle:'',
                searchData: {},
                editData:{},

                menuData: [],
                menuSelect: [],
                defaultProps: {
                    children: '_child',
                    label: 'name'
                }
            }
        },
        methods: {
            onSearch() {
                console.log(this.searchData)
            },
            refreshSearch(){
                this.searchData = _searchData;
            },
            deleteChecked() {
                console.log(this.$refs.tree.getCheckedKeys());
            },
            add(id) {
                this.showEdit=true;
                this.dialogTitle = '添加菜单';
                this.editData = _editData;
            },
            edit(data){
                this.showEdit=true;
                this.dialogTitle = '编辑菜单'
                for(k in _editData){
                    this.editData[k] = data[k];
                }
            },
            remove(id) {

            },
        },
        created() {
            this.searchData = _searchData;
            this.editData = _editData;

            ajaxPost(this, '/admin/menu/index', null, '', (res) => {
                this.menuData = res.allMenus;
                this.menuSelect = res.selectMenus;
            })
        }
    })

</script>