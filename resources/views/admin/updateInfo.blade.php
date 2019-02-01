<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title"
         style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px;margin-bottom:30px;">
        <h3 style="line-height: 1;color: deepskyblue">更新资料</h3>
    </div>


    <el-card style="margin:auto;width:500px">
        <el-form label-width="100px" style="margin-right:30px;margin-bottom:50px;">
            <el-form-item label="账号" >
                <el-input disabled v-model="userInfo.name"></el-input>
            </el-form-item>
            <el-form-item label="email">
                <el-input v-model="userInfo.email"></el-input>
            </el-form-item>
            <el-form-item label="真名">
                <el-input v-model="userInfo.realname"></el-input>
            </el-form-item>
            <el-form-item label="手机">
                <el-input v-model="userInfo.mobile"></el-input>
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
                userInfo:@json($userInfo)
            }
        },
        methods: {
            editInfo(){
                ajaxPost(this,'/admin/index/updateInfo',this.userInfo,'更新资料...',(res)=>{
                    jumpTo('/',500);
                })
            }
        }
    })

</script>