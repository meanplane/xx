// url 跳转
function jumpTo(url) {
    window.location.href = url;
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
                _this.$message.success(res.data.msg);
                if(func){
                    func(res.data.data)
                }
            }else{
                _this.$message.error(res.data.msg);
            }
        }).catch((err)=>{
            _this.$message.error(err);
        }).finally(()=>{
            loading.close();
        })
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