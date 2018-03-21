@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>summernote</title>
    <!-- include jquery -->
    {{--<script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>--}}

    {{--<link href="//cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" type="text/css" href="Admin/css/default.css">
    <link href="Admin/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />

    <!-- include libraries BS3 -->
    <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" />-->

   {{-- <script src="//cdn.bootcss.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>--}}
    <link href="//cdn.bootcss.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">

    <!-- include summernote -->
    <link rel="stylesheet" href="summernote/dist/summernote.css">
    <script type="text/javascript" src="summernote/dist/summernote.js"></script>
    <script src="summernote/lang/summernote-zh-CN.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            var IMAGE_PATH =   window.location.host+'/';

            $('#summernote').summernote({
                height: 300,
                lang:'zh-CN',
                callbacks : {
                    onImageUpload: function(file) {
                        uploadImage(file[0]);
                        //console.log(file[0]);
                    }
                }
            });

            function uploadImage(file) {
                var data = new FormData();
                data.append("photo",file);
                //console.log(data);
                $.ajax ({
                    data: data,
                    type: "POST",
                    url: "addArticle/add",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(url) {
                       // alert(url);
                        //	alert(url);
                      //  var image = IMAGE_PATH + url;
                        var image =  url;
                        $('#summernote').summernote('insertImage', image);
                        	console.log(image);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });
    </script>

    <script src="Admin/js/fileinput.js" type="text/javascript"></script>
    <script src="Admin/js/fileinput_locale_zh.js" type="text/javascript"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>-->

</head>
<body>

<div class="htmleaf-container">
    <header class="htmleaf-header">
        <h1>游民海洋 <span>在游戏的海洋中欢快的畅游</span></h1>
        <a class="glyphicon glyphicon-home" aria-hidden="true"  href="/" title="游民海洋"></a>
        &nbsp;
        <a class="glyphicon glyphicon-trash" aria-hidden="true"  href="singleoperate" title="文章管理"></a>

    </header>


    <!--<div class="htmleaf-content bgcolor-8">

    </div>-->
    <div class="container kv-main">
        <div class="page-header">
            <h2>游戏资料管理中心 <small/></h2>
        </div>
        @if (count($errors) > 0)
            <div class="form-group ">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <form enctype="multipart/form-data" action="article/create" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
            <p class="help-inline">游戏标题：</p><input  type="text" name="title" class="form-control">
            </div>
               <div class="form-group ">
                   <div class="input-group">
                       <div class="input-group-btn">
                           <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">分类 <span class="caret"></span></button>
                           <ul class="dropdown-menu dropdown-menu-left">

                               @foreach($navs as $nav)
                                   <li value="{{$nav['typename']}}"><center>{{$nav['typename']}}</center></li>
                                   <li role="separator" class="divider"></li>
                               @endforeach
                           </ul>
                           <!-- Button and dropdown menu -->
                       </div>
                       <input type="text" class="form-control" name="typename" id="typename">
                   </div>

               </div>
            <div class="form-group">
                <div class="form-group">
                <span >游戏内容：</span>
                    </div>
                <textarea class="summernote" id="summernote" name="summernote"></textarea>
            </div>


            <button type="submit" class="btn btn-primary" id="click">提交</button>
            <button type="reset" class="btn btn-default">重置</button>

        </form>

        <script>
            $("ul li").click(function(){
                var li_typename = $(this).attr("value");
                $("#typename").val(li_typename);
            });
        </script>

    </div>
</div>
</body>
</html>
@endsection
