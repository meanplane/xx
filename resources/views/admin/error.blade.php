<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$msg or '错误页面'}}</title>
</head>
<body>

<!-- content start -->

    <div style="margin-top: 80px;">

        <div >
            <div style="text-align: center;">
                <h1 style="color: orangered">{{$msg or '错误页面'}}</h1>
                <p >{{$content or ''}}</p>
                <pre >
          .----.
       _.'__    `.
   .--($)($$)---/#\
 .' @          /###\
 :         ,   #####
  `-..__.-' _.-\###/
        `;_:    `"'
      .'"""""`.
     /,出错啦,\\
    //        \\
    `-._______.-'
    ___`. | .'___
   (______|______)
        </pre>
            </div>
        </div>
    </div>

<script>
    var url = '{{$url or '' }}' ;

    if(url){
        setTimeout(()=>{
            window.location.href = url;
        },3000)
    }
</script>
</body>
</html>