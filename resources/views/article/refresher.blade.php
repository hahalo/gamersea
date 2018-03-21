@extends('layouts.app')
<!DOCTYPE html>
@section('content')
<html>
<head>
    <title>pull to refresh</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="refresher2/css/reset.css"/>
    <link rel="stylesheet" href="refresher2/css/pullToRefresh.css"/>
    <script src="refresher2/js/iscroll.js"></script>
    <script src="refresher2/js/pullToRefresh.js"></script>
    <style type="text/css" media="all">
        body, html {
            padding: 0;
            margin: 0;
            height: 100%;
            font-family: Arial, Microsoft YaHei;
            color: #111;
        }
        .scroller li {
            height:60px;
            border-bottom: 1px solid #eee;
            background-color: #fff;
            font-size: 14px;

        }
        .pullDownLabel img {
            width: 13px;
            height: 13px;
            margin-top: -1px;
            vertical-align: -2px;
            margin-right: 5px;
        }
        #wrapper ul li img{width:60px; float:left;  margin-left:10px;}
        .game-info{text-align:left; float:left; margin-left:10px; width:210px; overflow:hidden; height:60px;}
        .game-info h1{font-size:16px; margin-bottom:8px;}
        .game-info p:nth-child(2){font-size:12px; color:#B6B6B6;}
        .game-info p:nth-child(3){font-size:12px; color:#9D9D9D;}
        #wrapper ul li button{position:absolute; right:20px; margin-top:10px; background-color:#F8CD0C; border:0; color:#fff; font-family:Microsoft YaHei; padding:5px 14px; border-radius:3px;}
    </style>

</head>
<body>
<!--must content ul li,or shoupi-->
<div id="wrapper">
    <ul>
        @foreach($articles as $article)
        <li>
            <div class="game-info">
                <a href="article/{{$article['id']}}"><h1>{{$article['title']}}</h1></a>
               <p style="font-size: 10px"><?php echo htmlspecialchars_decode($article['typename']);?></p>
            </div>
            <button onclick="window.location.href='article/{{$article['id']}}'">查看</button>
        </li>
        @endforeach

    </ul>
</div>
<script>

    refresher.init({
        id:"wrapper",//<------------------------------------------------------------------------------------┐
        pullDownAction:Refresh,
        pullUpAction:Load
    });
    function Refresh() {
       // setTimeout(function () {	// <-- Simulate network congestion, remove setTimeout from production!
            var el, li, i;
            el =document.querySelector("#wrapper ul");
            //这里写你的刷新代码
            document.getElementById("wrapper").querySelector(".pullDownIcon").style.display="none";
            document.getElementById("wrapper").querySelector(".pullDownLabel").innerHTML="<img src='refresher2/css/ok.png'/>刷新成功";
         //   setTimeout(function () {
                wrapper.refresh();
                document.getElementById("wrapper").querySelector(".pullDownLabel").innerHTML="";
          //  },1000);//模拟qq下拉刷新显示成功效果
            /****remember to refresh after  action completed！ ---yourId.refresh(); ----| ****/
       // }, 1000);
    }
    var x=9,y=5;
    function Load() {
            $.ajax ({
                data: "x="+x+"&y="+y,
                type: "POST",
                url: "refresher/refresher",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data) {

                    if(data){
                        var jsonlength = eval(data).length;
                       // alert(jsonlength);
                        var data = JSON.parse(data);
                        for(var i=0;i<jsonlength;i++){
                            var el, li, i;
                            el =document.querySelector("#wrapper ul");
                            li = document.createElement('li');
                            li.innerHTML="<div class='game-info'><a href='article/"+data[i].id+"'><h1>"+data[i].title+"</h1></a><p>"+"     </p><p>"+data[i].typename+"</p></div><button onclick='openurl(this.id)'  id='"+data[i].id+"'>查看</button>"
                            el.appendChild(li, el.childNodes[0]);
                        }
                        x=x+jsonlength;
                    }

                    wrapper.refresh();/****remember to refresh after action completed！！！   ---id.refresh(); --- ****/
                    //   },2000);
                }
            });
    }
    //跳转
    function openurl(a){
        window.location.href='article/'+a;
    }


</script>
</body>
</html>
@endsection