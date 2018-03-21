<?php
$url = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>MY Zone</title>
    <!-- CSS 及 JavaScript -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="//cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="css/bootstrap-switch.min.css" rel="stylesheet">
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
<body>
<ul class="nav nav-tabs">
    <li role="presentation" ><a href="/">游民海洋</a></li>
    <li role="presentation" ><a href="/addarticle">上传文章</a></li>
    <li role="presentation" <?php if($url=='/addDaily'){echo "class='active'";} ?>><a href="/addDaily">添加日志</a></li>
    <li role="presentation" <?php if($url=='/addPhoto'){echo "class='active'";} ?>><a href="/addPhoto" >上传图片</a></li>
    <li role="presentation" <?php if($url=='/addMusic'){echo "class='active'";} ?>><a href="/addMusic">添加音乐</a></li>
    <li role="presentation" <?php if($url=='/addVideo'){echo "class='active'";} ?>><a href="/addVideo">添加视频</a></li>
    <li role="presentation" <?php if($url=='/mhadmin'){echo "class='active'";} ?>><a href="/mhadmin">洛英后台</a></li>
</ul>
<script src="/js/jquery-1.9.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-switch.min.js"></script>
@yield('content')


</body>
</html>