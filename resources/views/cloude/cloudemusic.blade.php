@extends('layouts.app')
@section('content')
<head>
    <link rel="stylesheet" href="css/index.css" />
    <script type="text/javascript" src="js/jqmobi.js"></script>
</head>
<body>
<header>
    <meta name="_token" content="{{ csrf_token() }}"/>
</header>
<section id="menu">
    <ul class="menu_tagList">
        <li id="newSong" class="menu_hover">新歌</li>
        <li id="songCharts">排行</li>
        <li id="singer">歌手</li>
        <li id="radioStation">电台</li>
    </ul>

</section>
<section id="content">
</section>
<section id="playwrap">
    <input type="hidden" id="list" value="1">
    <div id="playContent">
        <div >
            <audio  id="myMusic"></audio>
        </div>
        <div onClick="myControl.selectTime(event)" id="progressWrap">
            <div id="progress"></div>
        </div>
        <div class="img">
            <img id="singerHead" src="http://m.kugou.com/app/../static/images/sinheadNew.png">
        </div>
        <div class="info">
            <div class="songname clearfix">
                <label id="musicTitle" for="musicTitle"></label>
                <label style="display: none;" id="songname" for="songname" style="color: rgb(204, 0, 0);">此手机不支持html5播放，扔了吧</label>
                <label id="timeshow" for="time"><span id="currentTime">00:00</span>/<span id="totleTime">00:00</span></label>
            </div>
            <div class="audioControl">
                <a id="prevButton" class="last" onClick="myControl.prev()" href="javascript:;"></a>
                <a id="playButton" class="play" onClick="myControl.mainControl()" href="javascript:;"></a>
                <a id="nextButton" class="next" onClick="myControl.next()" href="javascript:;"></a>
                <a id="modeButton" class="mode-default" onClick="myControl.selectMode()" href="javascript:;"></a>
                <a class="border"></a>
                <a id="playDetail" class="showDetail" href="javascript:;"></a>
            </div>
        </div>
    </div>
</section>
<div style="display:none;" id="oWindow">dfsdfsdfdsf</div>
<script type="text/javascript" src="js/all.js"></script>
</body>
@endsection