@extends('layouts.app')
<header>
    <meta name="_token" content="{{ csrf_token() }}"/>
</header>
@section('content')
    <div class="form-group">
        <div class="col-lg-10">
            <div class="input-group">
                <input type="text" id="search_text" class="form-control" placeholder="嗖嗖嗖">
                 <span class="input-group-btn">
                 <button id='search' class="btn btn-default" type="button">搜索</button>
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
            $("#sucess_text").html('');
            var search_text = $("#search_text").val();
           // alert(search_text.length);
            //$("#sucess_text").text(search_text);
            if(search_text==""||typeof (search_text)=='undefined'){
                alert('搜索不能为空');
                return false;
            }
            if(search_text.length<2){
                alert('长度不小于2');
                return false;
            }
            /*$.ajax({
                url:'libary/search',
                type: "POST",
                data:{search_text:search_text},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                async:true,
                success:function (msg) {

                    var data = JSON.parse(msg);
                  //  console.log(data);
                   // console.log(data[0].length);
                    if(data.email=='null'){
                        $("#sucess_text").css('color','red');
                        $("#sucess_text").text('没有找到您的账号!');
                    }else{

                        $("#sucess_text").css('color','orange');
                        var show_text = '';
                        //csdn
                        if(data[0].length>0){
                            show_text = 'CSDN库存</br>';
                        }
                        for(var i=0;i<data[0].length;i++){
                            show_text = show_text+'  搜索到您的账号:'+data[0][i].username+'搜索到您的邮箱号码:'+data[0][i].email+'</br>';
                        }
                        //mi
                        if(data[1].length>0){
                            show_text = show_text+'小米库存</br>';
                        }
                        for(var i=0;i<data[1].length;i++){
                            show_text = show_text+'  搜索到您的账号:'+data[1][i].username+'搜索到您的邮箱号码:'+data[1][i].email+'</br>';
                        }

                        $("#sucess_text").html(show_text);

                    }
                },error: function(data) {
                    var error = JSON.parse(data.responseText);
                    $("#sucess_text").css('color','red');
                    $("#sucess_text").text(error.search_text);
                }
            });*/
            //Search Csdn
            $.ajax({
                 url:'libary/searchCsdn',
                 type: "POST",
                 data:{search_text:search_text},
                 headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                 },
                 async:true,
                 success:function (msg) {
                     $("#loading").hide();
                     var data = JSON.parse(msg);
                 if(data.email=='null'){
                     if($("#sucess_text").html().length==0){
                         $("#sucess_text").css('color','red');
                         $("#sucess_text").text('没有找到您的账号!');
                     }
                 }else{

                     $("#sucess_text").css('color','orange');
                     var show_text = '';
                     //csdn
                     if(data.length>0){
                        show_text = 'CSDN库存</br>';
                     }
                     for(var i=0;i<data.length;i++){
                        show_text = show_text+'  搜索到您的账号:'+data[i].username+'    搜索到您的邮箱号码:'+data[i].email+'</br>';
                     }
                     if($("#sucess_text").html().length==0){
                         $("#sucess_text").html(show_text);
                     }else if($("#sucess_text").html()=='没有找到您的账号!'){
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
            //Search Mi
            $.ajax({
                url:'libary/searchMi',
                type: "POST",
                data:{search_text:search_text},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                async:true,
                success:function (msg) {
                    $("#loading").hide();
                    var data = JSON.parse(msg);
                    //  console.log(data);
                    // console.log(data.length);
                    if(data.email=='null'){
                        if($("#sucess_text").html().length==0){
                            $("#sucess_text").css('color','red');
                            $("#sucess_text").text('没有找到您的账号!');
                        }
                    }else{

                        $("#sucess_text").css('color','orange');
                        var show_text = '';
                        //csdn
                        if(data.length>0){
                            show_text = '小米库存</br>';
                        }
                        for(var i=0;i<data.length;i++){
                            show_text = show_text+'  搜索到您的账号:'+data[i].username+'    搜索到您的邮箱号码:'+data[i].email+'</br>';
                        }
                        if($("#sucess_text").html().length==0){
                            $("#sucess_text").html(show_text);
                        }else if($("#sucess_text").html()=='没有找到您的账号!'){
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
            $("#loading").css('color','green');
            $("#loading").text('正在查找请稍等');
        });
    </script>


@endsection
