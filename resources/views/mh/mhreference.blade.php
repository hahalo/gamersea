@extends('layouts.app')
<header>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <style>
        .highlight {
            font-style: normal;
            color: #c00;
            font-weight:bold;
        }
    </style>
</header>
@section('content')
    <div class="form-group">
        <div class="col-lg-10">
            <div class="input-group">
                <input type="text" id="search_text" class="form-control" placeholder="嗖嗖嗖">
                 <span class="input-group-btn">
                {{-- <button id='search' class="btn btn-default" type="button">搜索</button>--}}
                 <input type="submit" id='search' class="btn btn-default" value="搜索">
                 </span>
            </div><!-- /input-group -->
            <div class="form-group">
                <div class="form-view-data">
                    <p id="loading"></p>
                    <p id="sucess_text"></p>
                </div>
            </div>
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    <script>
        $("#search").click(function () {
            searchAjax();
        });
        $('input').keydown(function(e){
            if(e.keyCode==13){
                searchAjax();
            }

        });
        function searchAjax(){
            $("#sucess_text").html('');
            var search_text = $("#search_text").val();
            if(search_text==""||typeof (search_text)=='undefined'){
                //alert('搜索不能为空');
                $("#sucess_text").css('color','red');
                $("#sucess_text").text('搜索不能为空!');
                return false;
            }
            if(search_text.length<2){
                //alert('长度不小于2');
                $("#sucess_text").css('color','red');
                $("#sucess_text").text('长度不小于2');
                return false;
            }
            $("#loading").css('color','green');
            $("#loading").text('正在查找请稍等');
            $.ajax({
                url:'/mhreference/search',
                type: "GET",
                data:{search_text:search_text},
                async:true,
                success:function (msg) {
                    //console.log(msg);
                    $("#loading").hide();
                    var data = JSON.parse(msg);
                    if(data[1]=='null'){
                        if($("#sucess_text").html().length==0){
                            $("#sucess_text").css('color','red');
                            $("#sucess_text").text('没有找到对应的信息!');
                        }
                    }else{

                        $("#sucess_text").css('color','#337ab7');
                        var show_text = '';
                        var h = 1;
                        for(var i=0;i<data.length;i++){
                            var mhCode = highlightAll(data[i][1].toLowerCase(),search_text.toLowerCase());
                            var mhTranslate = highlightAll(data[i][3],search_text.toLowerCase());
                            show_text = show_text+h+'</br>代码：'+mhCode+'    </br>名称：'+mhTranslate+'</br>';
                            h++;
                        }
                        if($("#sucess_text").html().length==0){
                            $("#sucess_text").html(show_text);
                        }else if($("#sucess_text").html()=='没有找到对应的信息!'){
                            $("#sucess_text").html(show_text);
                        }else{
                            $("#sucess_text").append(show_text);
                        }


                    }
                },error: function(data) {
                    var error = JSON.parse(data.responseText);
                    $("#sucess_text").css('color','red');
                    $("#sucess_text").text(error.search_text);
                }
            });
        }
        //单个词汇匹配
        function highlightEach(text, words, tag) {
            // 默认的标签，如果没有指定，使用span
            tag = tag || 'span';
            var i, len = words.length, re;
            for (i = 0; i < len; i++) {
                // 正则匹配所有的文本
                re = new RegExp(words[i], 'g');
                if (re.test(text)) {
                    text = text.replace(re, '<'+ tag +' class="highlight">$&</'+ tag +'>');
                }
            }
            return text;
        }
        //全词匹配
        function highlightAll(text, words, tag) {
            // 默认的标签，如果没有指定，使用span
            tag = tag || 'span';
            // 正则匹配所有的文本
            re = new RegExp(words, 'g');
            if (re.test(text)) {
                text = text.replace(re, '<'+ tag +' class="highlight">$&</'+ tag +'>');
            }
            return text;
        }
    </script>


@endsection
