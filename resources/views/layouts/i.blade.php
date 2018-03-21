<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>GamerSea</title>
    <!-- CSS 及 JavaScript -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="//cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <!--[if IE]>
    <script src="//cdn.bootcss.com/html5shiv/r29/html5.js"></script>
    <![endif]-->

    <style>
        body{
        <?php
            date_default_timezone_set('prc');
           // session_start();
            $nowHours = date('H',time());
            if(isset($_SESSION['daynight'])){
                 $_SESSION['daynight'];
            }else if($nowHours>=00&&$nowHours<=06){
                 $_SESSION['daynight']=0;
            }else if($nowHours>=22&&$nowHours<=24){
                 $_SESSION['daynight']=0;
            }else{
                $_SESSION['daynight']=1;
            }

             if($_SESSION['daynight']==0){
                echo $bg = "background-color: rgb(20,22,22);color:#ccc";
             }else{
                echo $bg='';
             }


        ?>
         }

    </style>

</head>


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
            @if(Auth::check())
                <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/i">个人主页</a></li>
                <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/adminc">后台</a></li>
                <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/logout">退出</a></li>
            @else
                <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/login">登录</a></li>
            @endif
            @yield('checkbox')
        </ul>
    </div>
</nav>
<script src="//cdn.bootcss.com/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>

@yield('content')


</html>