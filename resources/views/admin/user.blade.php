
<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title"
         style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px;margin-bottom:30px;">
        <h3 style="line-height: 1;color: deepskyblue">{{$menu_info->name or ''}}</h3>
    </div>


    <el-card shadow="hover" style="margin:auto 30px;">
        <div slot="header" class="clearfix">
            <el-form :inline="true">
                <el-form-item label="账号名">
                    <el-input v-model="searchData.name" placeholder="菜单名"></el-input>
                </el-form-item>
                <el-form-item label="状态" >
                    <el-select v-model="searchData.status">
                        <el-option label="全部" value=""></el-option>
                        <el-option label="正常" value="1"></el-option>
                        <el-option label="禁用" value="2"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSearch">查询</el-button>
                    <el-button @click="refreshSearch">重置查询</el-button>
                </el-form-item>

            </el-form>
        </div>

        <el-table
                :data="tableData"
                style="width: 100%">
            <el-table-column
                    prop="id"
                    label="ID"
                    width="50">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="账号"
                    width="150">
            </el-table-column>
            <el-table-column
                    label="真名"
                    prop="realname"
                    width="100">
            </el-table-column>
            <el-table-column
                    prop="level"
                    label="级别"
                    width="100">
            </el-table-column>
            <el-table-column
                    prop="groups"
                    label="角色"
                    width="200">
            </el-table-column>
            {{--<el-table-column--}}
                    {{--label="创建时间"--}}
                    {{--:formatter="(row)=>formatTime(row.created_at)"--}}
                    {{--width="200">--}}
            {{--</el-table-column>--}}
            {{--<el-table-column--}}
                    {{--label="修改时间"--}}
                    {{--:formatter="(row)=>formatTime(row.updated_at)"--}}
                    {{--width="200">--}}
            {{--</el-table-column>--}}
            <el-table-column
                    prop="href"
                    label="地址">
                <template slot-scope="scope">
                    <el-button
                            size="mini"
                            @click="showInfo(scope.row)">编辑</el-button>
                    <el-button
                            size="mini"
                            @click="showInfo(scope.row)">修改密码</el-button>
                    <el-button
                            size="mini"
                            @click="showInfo(scope.row)">禁用</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination
                style="margin-top: 30px;margin-left:40px;"
                background
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page="searchData.page"
                :page-sizes="[10,  30,  50, 100]"
                :page-size="searchData.limit"
                layout="total, sizes, prev, pager, next, jumper"
                :total="total">
        </el-pagination>
    </el-card>

    <el-dialog title="" :visible.sync="showInfoDialog" center width="1000">

    </el-dialog>

</div>

<script>

    new Vue({
        el: '#content',
        data: function () {
            return {
                tableData: [],
                total:0,
                searchData:{
                    name:'',
                    status:'',

                    limit:10,
                    page:1
                },

                showInfoDialog:false,
                info:{},
                last_info:{}
            }
        },
        methods: {
            handleSizeChange(val) {
                this.searchData.limit = val;
                this._getData();
            },
            handleCurrentChange(val) {
                this.searchData.page = val;
                this._getData();
            },
            showInfo(row){
//                console.log(row)
//                this.showInfoDialog = true;
//                ajaxPost(this,'/admin/log/info',{id:row.id},null,(res)=>{
//                    console.log(res)
//                })
            },
            onSearch(){
//                this._getData();
                console.log(this.searchData);
            },
            refreshSearch(){
                this.searchData.name = '';
                this.searchData.status = '';

                this.searchData.limit = 10;
                this.searchData.page = 1;

                this._getData();
            },
            _getData(){
                ajaxPost(this, '/admin/user/lists', this.searchData , null, (res) => {
                    this.tableData = res.tableData;
                    this.total = res.count;
                })
            },
            formatTime(row){
                return moment(row * 1000).format('YYYY-MM-DD HH:mm:ss')
            }
        },
        created() {
           this._getData();
        }
    })

</script>