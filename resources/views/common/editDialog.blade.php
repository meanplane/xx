{{-- 添加，编辑对话框  mp-edit-dialog --}}
<script type="text/x-template" id="mp-edit-dialog-template">
    <el-dialog :title="editTitle" :visible.sync="showEditDialog" center width="1000">
        <h2>xxx</h2>
    </el-dialog>
</script>
<script>
    Vue.component('mp-edit-dialog', {
        data: function () {
            return {
                showEditDialog: false,
                _editData:{},
                editTitle: '',
                editData: deepCopy(_editData),
                showPass:true,
            }
        },
        template: '#mp-edit-dialog-template',
        props:{
        },
        methods:{
            showEdit(){
                this.showEditDialog = true;
                this.editTitle = '编辑'
            }
        },
        created(){
            // 初始化
        }
    })
</script>