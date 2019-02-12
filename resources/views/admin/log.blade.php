
<div class="right-content" style=" width: 100%;height: 100%;padding: 20px;box-sizing: border-box;" id="content">
    <div class="title"
         style="line-height: 40px;border-bottom: 1px solid #c1c1c1;padding-bottom: 20px;margin-bottom:30px;">
        <h3 style="line-height: 1;color: deepskyblue">xxx</h3>
    </div>


    <el-card style="margin:auto 30px;">
        <div slot="header" class="clearfix">
            <el-form :inline="true" class="demo-form-inline">
                <el-form-item label="标题">
                    <el-input v-model="searchData.title" placeholder="标题"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSearch">查询</el-button>
                </el-form-item>
            </el-form>
        </div>

        <el-table
                :data="tableData"
                style="width: 100%">
            <el-table-column
                    prop="id"
                    label="ID"
                    width="80">
            </el-table-column>
            <el-table-column
                    prop="title"
                    label="标题"
                    width="480">
            </el-table-column>
            <el-table-column
                    prop="href"
                    label="地址">
                <template slot-scope="scope">
                    <el-button
                            size="mini"
                            @click="goUrl(scope.row)">查看</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination
                style="margin-top: 30px;"
                backgroud
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
                    title:'',
                    limit:10,
                    page:1
                }

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
            onSearch(){
                this._getData();
            },
            goUrl(row){
                console.log('row',row.href);
                window.open('http://w3.jbzcjsj.rocks/pw/'+row.href);
            },
            _getData(){
                ajaxPost(this, '/admin/log/index', this.searchData , null, (res) => {
                    this.tableData = res.data;
                    this.total = res.count;
                })
            }
        },
        created() {
            this._getData();
        }
    })

</script>