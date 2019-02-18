{{-- 带搜索，分页的table mp-table --}}
<script type="text/x-template" id="mp-table-template">
    <el-card shadow="hover" style="margin:auto 30px;">
        <div slot="header" class="clearfix" v-if="showSearch">
            <el-form :inline="true">
                <el-form-item v-for="(item ,index) in searchOpts"  :key="index" :label="item.label">
                    <el-input v-if="item.type == 'input'" :placeholder="item.place"
                              v-model="searchData[item.word]" size="mini"></el-input>

                    <el-date-picker v-else-if="item.type == 'range'" v-model="searchData[item.word]"
                            type="daterange"
                            align="right"
                            unlink-panels
                            range-separator="至"
                            start-placeholder="开始日期"
                            end-placeholder="结束日期"
                            :picker-options="pickerOptions"
                            format="yyyy 年 MM 月 dd 日"
                            value-format="yyyy-MM-dd"
                            size="mini">
                    </el-date-picker>

                    <el-select v-else-if="item.type == 'select'" v-model="searchData[item.word]" size="mini">
                        <el-option v-for="(opt,k) in item.options" :label="opt" :value="k" :key="k"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="onSearch" size="mini">查询</el-button>
                    <el-button @click="refreshSearch" size="mini">重置查询</el-button>

                    {{--额外按钮--}}
                    <slot name="extra-btns"></slot>
                </el-form-item>
            </el-form>
        </div>


        <el-table :data="tableData" style="width: 100%" size="mini">
            <slot name="tb-content"></slot>
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
</script>
<script>
    Vue.component('mp-table', {
        data: function () {
            return {
                _searchData: {},
                searchData: {},
                total: 0,
                tableData: [],

                // 时间范围插件
                 pickerOptions:{
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
        template: '#mp-table-template',
        props: ['searchOpts', 'showSearch', 'searchUrl'],
        methods: {
            handleSizeChange(val) {
                this.searchData.limit = val;
                this._getData();
            },
            handleCurrentChange(val) {
                this.searchData.page = val;
                this._getData();
            },
            onSearch() {
                this._getData();
            },
            refreshSearch() {
                this.searchData = deepCopy(this._searchData);
                this._getData();
            },
            _getData() {
                ajaxPost(this, this.searchUrl, this.searchData, '', (res) => {
                    this.total = res.count;
                    this.tableData = res.tableData;
                })
            },
        },
        created() {
            // 初始化 searchData
            for (var opt of this.searchOpts) {
                this.$set( this.searchData,opt.word,opt.default);
            }
            this.searchData['page'] = 1;
            this.searchData['limit'] = 10;
            this._searchData = deepCopy(this.searchData);
            this._getData();
        }
    })
</script>