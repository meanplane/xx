// 解决 低版本浏览器不支持finally
Promise.prototype.finally = function (callback) {
    var Promise = this.constructor;
    return this.then(
        function (value) {
            Promise.resolve(callback()).then(
                function () {
                    return value;
                }
            );
        },
        function (reason) {
            Promise.resolve(callback()).then(
                function () {
                    throw reason;
                }
            );
        }
    );
}


// url 跳转
function jumpTo(url,time) {
    if(time){
        setTimeout(()=>{
            window.location.href = url;
        },time);
    }else{
        window.location.href = url;
    }

}

// sweetAlert2 message
function showError(title,content,func) {
    Swal({
        type:'error',
        title: title || '出错了！',
        timer:3000,
        text:content || '',
        onClose:()=>{
            if(func){
                func()
            }
        }
    })
}

function showSuccess(title,content,func) {
    Swal({
        type:'success',
        title: title || '成功！',
        timer:1500,
        text:content || '',
        onClose:()=>{
            if(func){
                func()
            }
        }
    })
}


function ajaxPost(_this,url,params,loadingTitle,func) {
    const loading = _this.$loading({
        lock: true,
        text: loadingTitle || 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(255, 255, 255, 0.9)'
    });
    axios.post(url,params,{headers:{'X-Requested-With':'XMLHttpRequest'}})
        .then((res)=>{
            if(res.data && res.data.code && res.data.code == 1){
                _this.$message.success(dealMsg(res.data.msg));
                if(func){
                    func(res.data.data)
                }
            }else{
                _this.$message.error(dealMsg(res.data.msg));
            }
        }).catch((err)=>{
            _this.$message.error(dealMsg(err));
        }).finally(()=>{
            loading.close();
        })
}

function dealMsg(msg) {
    if(msg === msg+''){
        return msg;
    }else{
        return JSON.stringify(msg);
    }
}

function ajaxGet() {

}

// 加载 main page
function getPage(_this, url) {
    const loading = _this.$loading({
        lock: true,
        text: '加载页面...',
        spinner: 'el-icon-loading',
        background: 'rgba(255, 255, 255, 0.9)'
    });
    axios.post(url)
        .then((res)=>{
            // document.getElementById("main").innerHTML = res.data;
            $('#main').html(res.data);
        }).catch((err)=>{
            _this.$message.error(err);
    }).finally(()=>{
        loading.close();
    })
}

// 深拷贝赋值
function deepCopy(obj) {
    let tmp = JSON.stringify(obj);
    return JSON.parse(tmp);
}

function aWeekDay() {
    var nowdate = new Date();
    var oneweekdate = new Date(nowdate-7*24*3600*1000);
    var y = oneweekdate.getFullYear();
    var m = oneweekdate.getMonth()+1;
    var d = oneweekdate.getDate();
    return y+'-'+m+'-'+d;
}

function toDay() {
    var nowdate = new Date();
    var y = nowdate.getFullYear();
    var m = nowdate.getMonth()+1;
    var d = nowdate.getDate();
    return y+'-'+m+'-'+d;
}

function aWeekRange() {
    return [aWeekDay(),toDay()]
}