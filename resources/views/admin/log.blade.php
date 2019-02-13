
<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title"
         style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px;margin-bottom:30px;">
        <h3 style="line-height: 1;color: deepskyblue">{{$menu_info->name}}</h3>
    </div>


    <el-card shadow="hover" style="margin:auto 30px;">
        <div slot="header" class="clearfix">
            <el-form :inline="true">
                <el-form-item label="时间">
                    <el-date-picker
                            v-model="searchData.timeRange"
                            type="daterange"
                            align="right"
                            unlink-panels
                            range-separator="至"
                            start-placeholder="开始日期"
                            end-placeholder="结束日期"
                            :picker-options="pickerOptions"
                            format="yyyy 年 MM 月 dd 日"
                            value-format="yyyy-MM-dd"
                    >
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="菜单名">
                    <el-input v-model="searchData.menu" placeholder="菜单名"></el-input>
                </el-form-item>
                <el-form-item label="操作人">
                    <el-input v-model="searchData.user" placeholder="操作人"></el-input>
                </el-form-item>
                <el-form-item label="ip">
                    <el-input v-model="searchData.ip" placeholder="ip"></el-input>
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
                    prop="created_at"
                    label="时间"
                    :formatter="(row)=>formatTime(row.created_at)"
                    width="240">
            </el-table-column>
            <el-table-column
                    prop="menu_name"
                    label="菜单名"
                    width="200">
            </el-table-column>
            <el-table-column
                    label="请求地址"
                    :formatter="(row)=> row.c+'/'+row.a "
                    width="200">
            </el-table-column>
            <el-table-column
                    prop="ip"
                    label="IP地址"
                    width="200">
            </el-table-column>
            <el-table-column
                    prop="admin_name"
                    label="操作人"
                    width="200">
            </el-table-column>
            <el-table-column
                    prop="href"
                    label="地址">
                <template slot-scope="scope">
                    <el-button
                            size="mini"
                            @click="showInfo(scope.row)">查看</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination
                style="margin-top: 30px;margin-left:40px;"
                background
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page="searchData.page"
                :page-sizes="[10, 20, 30, 40, 50]"
                :page-size="searchData.limit"
                layout="total, sizes, prev, pager, next, jumper"
                :total="total">
        </el-pagination>
    </el-card>

</div>

<script>

    new Vue({
        el: '#content',
        data: function () {
            return {
                tableData: [],
                infoData:{},
                total:0,
                searchData:{
                    timeRange:[],
                    menu:'',
                    user:'',
                    ip:'',

                    limit:10,
                    page:1
                },
                pickerOptions: pickerOptions(),
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
                console.log(row)
            },
            onSearch(){
                this._getData();
            },
            refreshSearch(){
                this.searchData.timeRange = [];
                this.searchData.menu = '';
                this.searchData.user = '';
                this.searchData.ip = '';

                this.searchData.limit = 10;
                this.searchData.page = 1;

                this._getData();
            },
            _getData(){
                ajaxPost(this, '/admin/log/lists', this.searchData , null, (res) => {
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