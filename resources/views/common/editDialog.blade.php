{{-- 添加，编辑对话框  mp-edit-dialog --}}
<script type="text/x-template" id="mp-edit-dialog-template">
    <el-dialog :title="editTitle" :visible.sync="showEditDialog" center width="600">
        <el-form label-width="100px" style="margin-right:30px;margin-bottom:50px;">
            <el-form-item v-for="(item,index) in editOpts" :key="index" :label="item.label" >
                <el-input v-if="item.type == 'input'" :placeholder="item.place"
                          v-model="editData[item.word]" size="mini">
                </el-input>

                <el-select v-else-if="item.type == 'select'" v-model="editData[item.word]" size="mini">
                    <el-option v-for="(opt,k) in item.options" :label="opt" :value="(item.keyType == 'Number')?Number(k):k" :key="k"></el-option>
                </el-select>

                <el-checkbox-group v-else-if="item.type == 'check'" v-model="editData[item.word]">
                    <el-checkbox v-for="(name,k) in item.options" :label="(item.keyType == 'Number')?Number(k):k" :key="k">@{{ name }}</el-checkbox>
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
        props:['editOpts','editUrl','addUrl','getData'],
        methods:{
            showEdit(row){
                this.showEditDialog = true;
                this.editTitle = '编辑';

                this.editData = deepCopy(this._editData);
                for(k in this.editData){
                    if(!row[k]) // 解决 groups没有时 赋值为undefined 出bug
                        continue;
                    this.editData[k] = Array.isArray(row[k])?deepCopy(row[k]):row[k];
                }
                this.editData.id = row.id;
            },
            showAdd(){
                this.showEditDialog = true;
                this.editTitle = '添加';

                this.editData = deepCopy(this._editData);
            },
            onSubmit(){
                this.showEditDialog = false;
                if(this.editData.id){
                    ajaxPost(this,this.editUrl,this.editData,'修改数据..',()=>{
                        if(this.getData){
                            this.getData();
                        }
                    })
                }else{
                    ajaxPost(this,this.addUrl,this.editData,'新增数据..',()=>{
                        if(this.getData){
                            this.getData();
                        }
                    })
                }
            },
        },
        created(){
            // 初始化 editData
            for (var opt of this.editOpts) {
                this.$set( this.editData,opt.word,opt.default);
            }
            this._editData = deepCopy(this.editData);
        }
    })
</script>