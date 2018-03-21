@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>summernote</title>
    <link rel="stylesheet" type="text/css" href="/Admin/css/default.css">
    <link href="/Admin/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <link href="//cdn.bootcss.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">

    <!-- include summernote -->
    <link rel="stylesheet" href="/summernote/dist/summernote.css">
    <script type="text/javascript" src="/summernote/dist/summernote.js"></script>
    <script src="/summernote/lang/summernote-zh-CN.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            var IMAGE_PATH =   window.location.host+'/';

            $('#summernote').summernote({
                height: 300,
                lang:'zh-CN',
                callbacks : {
                    onImageUpload: function(file) {
                        uploadImage(file[0]);
                    }
                }
            });

            function uploadImage(file) {
                var data = new FormData();
                data.append("photo",file);
                $.ajax ({
                    data: data,
                    type: "POST",
                    url: "/addArticle/add",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(url) {
                       // alert(url);
                        //	alert(url);
                      //  var image = IMAGE_PATH + +url;
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

</head>
<body>
<div class="htmleaf-container">

    <!--<div class="htmleaf-content bgcolor-8">

    </div>-->
    <div class="container kv-main">
        @if (session('status'))
            <div class="tools-alert tools-alert-green">
                {{ session('status') }}
            </div>
        @endif
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
        <div class="page-header">
            <h2>游戏资料管理中心 <small/></h2>
        </div>
        <form enctype="multipart/form-data" action="/article/edit" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
            <p class="help-inline">游戏标题：</p><input  type="text" name="title" class="form-control" value="{{{$editArticle['title']}}}">
            </div>
               <div class="form-group ">
                   <div class="input-group">
                       <div class="input-group-btn">
                           <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">分类 <span class="caret"></span></button>
                           <ul class="dropdown-menu dropdown-menu-left">

                               @foreach($articles as $article)
                                   <li value="{{$article['typename']}}"><center>{{$article['typename']}}</center></li>
                                   <li role="separator" class="divider"></li>
                               @endforeach
                           </ul>
                           <!-- Button and dropdown menu -->
                       </div>
                       <input type="text" class="form-control" name="typename" id="typename" value="{{$editArticle['typename']}}">
                   </div>

               </div>
            <div class="form-group">
                <div class="form-group">
                <span >游戏内容：</span>
                    </div>
                <textarea class="summernote" id="summernote" name="summernote" >
                    {{{htmlspecialchars($editArticle['content'])}}}
                </textarea>
            </div>

            <input type="hidden" name="articleid" value="{{$editArticle['id']}}">
            <button type="submit" class="btn btn-primary" id="click">修改</button>
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
