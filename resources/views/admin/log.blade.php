
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
                    <el-button @click="refreshSearch">查询</el-button>
                </el-form-item>

            </el-form>
            <h2>@{{ searchData.timeRange }}</h2>
        </div>

        <el-table
                :data="tableData"
                style="width: 100%">
            <el-table-column
                    prop="created_at"
                    label="时间"
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="title"
                    label="菜单名"
                    width="200">
            </el-table-column>
            <el-table-column
                    prop=""
                    label="请求地址"
                    width="200">
            </el-table-column>
            <el-table-column
                    prop="ip"
                    label="IP地址"
                    width="200">
            </el-table-column>
            <el-table-column
                    prop="title"
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
                {{--:current-page="searchData.li"--}}
                :page-sizes="[10, 20, 30, 40, 50]"
                :page-size="100"
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
                total:0,
                searchData:{
                    timeRange:0,
                    menu:'',
                    user:'',
                    ip:'',

                    limit:10,
                    page:1
                },
                pickerOptions: {
                    shortcuts: [{
                        text: '最近一周',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近一个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近三个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                            picker.$emit('pick', [start, end]);
                        }
                    }]
                },
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
                this.searchData.title = '';
                this._getData();
            },
            _getData(){
                ajaxPost(this, '/admin/log/lists', this.searchData , null, (res) => {
                    this.tableData = res.data;
                    this.total = res.count;
                })
            }
        },
        created() {
//            this._getData();
        }
    })

</script>