<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>GamerSea</title>
    <!-- CSS 及 JavaScript -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="//cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" >
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
                 $randPngNum = rand(1,13);
                 if($randPngNum<10){
                    $randPngNum = '0'.$randPngNum;
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
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/mhshop">海洋商城</a></li>
            <li style="background-color: rgb(254,254,254);font-size: 15px;" ><a href="/mhrole">海洋角色</a></li>
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/article">云文章</a></li>
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/daily">云日志</a></li>
            {{--<li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/cloudealbum">云相册</a></li>--}}
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/cloudealbumflow">云相册</a></li>
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/cloudemusic">云音乐</a></li>
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/cloudevideo">云视频</a></li>
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/vipvideo">VIP视频</a></li>
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/chat">云聊天</a></li>
           {{-- <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/refresher">刷一刷</a></li>--}}
            <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/libary">社工库</a></li>
            {{--@foreach($navs as $nav)
                <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/article/{{$nav['typename']}}">{{$nav['typename']}}</a></li>
            @endforeach--}}
            @if(Auth::check())
               {{-- <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/adminc">后台</a></li>--}}
                <li class="dropdown" style="background-color: rgb(254,254,254);font-size: 15px;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(Auth::user()->photo)
                            <img style="width: 20px;height: 20px;margin-right: 4px;" src="/icon/{{Auth::user()->photo}}" class="img-circle">
                        @else
                            <img style="width: 20px;height: 20px;margin-right: 4px;" src="/upload/lito_s-ido_{{$randPngNum}}.png" class="img-circle">
                        @endif
                        {{Auth::user()->nick_name?Auth::user()->nick_name:Auth::user()->name}}
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/i"><i class="fa fa-user text-md" style="margin-right: 16px"></i>个人中心</a></li>
                        <li class="divider"></li>
                        <li><a href="/adminc"><i class="fa fa-cog text-md" style="margin-right: 16px"></i>后台</a></li>
                        <li class="divider"></li>
                        <li><a href="/logout"><i class="fa fa-sign-out text-md" style="margin-right: 16px"></i>退出</a></li>
                    </ul>
                </li>
               {{-- <li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/i">个人主页</a></li>--}}
                {{--<li style="background-color: rgb(254,254,254);font-size: 15px;"><a href="/logout">退出</a></li>--}}
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