<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title"
         style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px;margin-bottom:30px;">
        <h3 style="line-height: 1;color: deepskyblue">更新密码</h3>
    </div>


    <el-card style="margin:auto;width:500px">
        <el-form label-width="100px" style="margin-right:30px;margin-bottom:50px;">
            <el-form-item label="账号" >
                <el-input disabled v-model="userInfo.name"></el-input>
            </el-form-item>
            <el-form-item label="新密码">
                <el-input v-model="userInfo.password"></el-input>
            </el-form-item>
        </el-form>
        <div style="text-align: center">
            <el-button type="primary" @click="editInfo">修改</el-button>
        </div>
    </el-card>
</div>

<script>
    new Vue({
        el: '#content',
        data: function () {
            return {
                userInfo:{
                    id:'{{$userInfo['id']}}',
                    name:'{{$userInfo['name']}}',
                    password:''
                }
            }
        },
        methods: {
            editInfo(){
                ajaxPost(this,'/admin/index/updatePass',this.userInfo,'更新密码...',(res)=>{
                    jumpTo('/',500);
                })
            }
        }
    })

</script>