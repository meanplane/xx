<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title" style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px">
        <h3 style="line-height: 1;color: deepskyblue">更新资料</h3>
    </div>

    <el-button type="primary" @click="xxx">xxx</el-button>

</div>

<script>
    console.log(1)
    new Vue({
        el:'#content',
        data:function(){
            return{
                msg:'xx111xx'
            }
        },
        methods:{
            xxx(){
                this.$message.success(this.msg);
            },
        }
    })

</script>