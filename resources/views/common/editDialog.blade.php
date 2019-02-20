{{-- 添加，编辑对话框  mp-edit-dialog --}}
<script type="text/x-template" id="mp-edit-dialog-template">
    <el-dialog :title="editTitle" :visible.sync="showEditDialog" center width="600">
        {{--<el-form label-width="100px" style="margin-right:30px;margin-bottom:50px;">--}}
            {{--<el-form-item label="账号">--}}
                {{--<el-input v-model="editData.name"></el-input>--}}
            {{--</el-form-item>--}}
            {{--<el-form-item label="密码" >--}}
                {{--<el-input v-model="editData.password" :disabled="showPass"></el-input>--}}
            {{--</el-form-item>--}}
            {{--<el-form-item label="真实姓名">--}}
                {{--<el-input v-model="editData.realname"></el-input>--}}
            {{--</el-form-item>--}}
            {{--<el-form-item label="手机号">--}}
                {{--<el-input v-model="editData.mobile"></el-input>--}}
            {{--</el-form-item>--}}
            {{--<el-form-item label="级别">--}}
                {{--<el-select v-model="editData.level">--}}
                    {{--<el-option v-for="(name,key) in levels" :label="name" :value="Number(key)"></el-option>--}}
                {{--</el-select>--}}
            {{--</el-form-item>--}}

            {{--<el-form-item label="角色">--}}
                {{--<el-checkbox-group v-model="editData.groups">--}}
                    {{--<el-checkbox v-for="(name,key) in roles" :label="Number(key)" :key="Number(key)">@{{name}}</el-checkbox>--}}
                {{--</el-checkbox-group>--}}
            {{--</el-form-item>--}}
            {{--<el-form-item label="状态">--}}
                {{--<el-select v-model="editData.status">--}}
                    {{--<el-option v-for="(name,key) in statuss" :label="name" :value="Number(key)"></el-option>--}}
                {{--</el-select>--}}
            {{--</el-form-item>--}}
        {{--</el-form>--}}
        <el-form label-width="100px" style="margin-right:30px;margin-bottom:50px;">
            <el-form-item v-for="(item,index) in editOpts" :key="index" :label="item.label" >
                <el-input v-if="item.type == 'input'" :placeholder="item.place"
                          v-model="editData[item.word]" size="mini">
                </el-input>

                <el-select v-else-if="item.type == 'select'" v-model="editData[item.word]" size="mini">
                    <el-option v-for="(opt,k) in item.options" :label="opt" :value="(item.keyType == 'Number')?Number(k):k" :key="k"></el-option>
                </el-select>

                <el-checkbox-group v-else-if="item.type == 'check'" v-model="editData[item.word]">
                    <el-checkbox v-for="(name,k) in item.options" :label="name" :value="(item.keyType == 'Number')?Number(k):k" :key="k" ></el-checkbox>
                </el-checkbox-group>
            </el-form-item>
        </el-form>
        <div style="text-align: center">
            <el-button type="primary" @click="onSubmit">确定</el-button>
        </div>
    </el-dialog>
</script>
<script>
    Vue.component('mp-edit-dialog', {
        data: function () {
            return {
                showEditDialog: false,
                editTitle: '',

                _editData:{},
                editData: {},
            }
        },
        template: '#mp-edit-dialog-template',
        props:['editOpts'],
        methods:{
            showEdit(row){
                this.showEditDialog = true;
                this.editTitle = '编辑';

                this.editData = deepCopy(_editData);
                for(k in this.editData){
                    this.editData[k] = deepCopy(row[k]);
                }
            },
            showAdd(){
                this.showEditDialog = true;
                this.editTitle = '添加';

                this.editData = deepCopy(_editData);
            },
            onSubmit(){
                this.showEditDialog = false;
                console.log(this.editData)
            },
        },
        created(){
            // 初始化 editData
            console.log(this.editOpts);
            for (var opt of this.editOpts) {
                this.$set( this.editData,opt.word,opt.default);
            }
            this._editData = deepCopy(this.editData);
        }
    })
</script>