
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>MY Zone</title>
    <!-- CSS 及 JavaScript -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="//cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-switch.min.css" rel="stylesheet">
    <style>
        body{
        <?php
            date_default_timezone_set('prc');
            $nowHours = date('H',time());
            if($nowHours>=0&&$nowHours<=06){
                echo "background-color: rgb(20,22,22);color:#ccc";
            }else if($nowHours>=22&&$nowHours<=24){
                echo "background-color: rgb(20,22,22);color:#ccc";
            }
        ?>
         }

    </style>
</head>
<body>
<nav class="navbar navbar-default" role="navigation" style="background-color:rgb(255,255,255)">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#example-navbar-collapse">
            <span class="sr-only">切换导航</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">游民海洋</a>
    </div>
    <div class="collapse navbar-collapse" id="example-navbar-collapse" >
        <ul class="nav navbar-nav">
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/article">文章</a></li>
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/daily">日志</a></li>
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/cloudealbum">云相册</a></li>
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/refresher">刷一刷</a></li>

            @foreach($navs as $nav)
                <li style="background-color: rgb(254,254,254)"><a href="/article/{{$nav['typename']}}">{{$nav['typename']}}</a></li>
            @endforeach
            @if(Auth::check())
                <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/addDaily">后台</a></li>
                <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/logout">退出</a></li>
            @else
                <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/login">登录</a></li>
            @endif
            <input type="checkbox">
        </ul>
    </div>
</nav>
<script src="//cdn.bootcss.com/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="js/bootstrap-switch.min.js"></script>
<script>
    $(function(argument) {
        $('[type="checkbox"]').bootstrapSwitch();
    })
</script>
@yield('content')

</body>
</html>