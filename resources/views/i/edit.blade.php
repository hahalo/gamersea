@extends('layouts.app')
<meta name="_token" content="{{ csrf_token() }}"/>
<style>
.jumbotron{
    background-image:url(/upload/bg.jpg);
    background-repeat: no-repeat;
    background-color: #FFFFFF !important;
}
.container{
    margin-left: 7px !important;
}
.row{
    margin-top:210px;
}

.left_span{
    font-size: large;
    font-weight:bold;
}
.right_span_2{
    font-size: large;
    margin-left: 140px;
}
.right_span_5{
    font-size: large;
    margin-left: 86px;
}
.a_edit{
    font-size: medium;
    margin-left: 10px;
}
.a_edit:hover{
    color:black;
}
.form-control{
    /*display: none!important;*/
}
.cropit-preview {
    background-color: #f8f8f8;
    background-size: cover;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-top: 7px;
    width: 300px;
    height: 300px;
}

.cropit-preview-image-container {
    cursor: move;
}

.image-size-label {
    margin-top: 10px;
}

input, .export {
    display: block;
}

button {
    margin-top: 10px;
}
</style>
@section('content')
    <div class="col-md-12">
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-md-3">
                        <div >
                            @if(!empty($user['photo']))
                                <img id="my_photo" src="/icon/{{$user['photo']}}" class="img-thumbnail">
                            @else
                                <img id="my_photo" src="/upload/Max_201612311553488619.gif" class="img-thumbnail">
                            @endif
                            <div class="caption">
                                <h3>Hello,
                                    <small id="top_nick_name">
                                        @if(!empty($user['nick_name']))
                                            {{$user['nick_name']}}
                                        @else
                                            {{$user['name']}}
                                        @endif
                                    </small>
                                </h3>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-4" >
                    <div class="image-editor" style="display:none">
                        <input type="file" id="uploadFile" class="cropit-image-input" style="display: none">
                        <div class="cropit-preview"></div>
                        <div class="image-size-label"></div>
                        <input type="range" class="cropit-image-zoom-input">
                        <p><button class="btn btn-default export">保存</button></p>
                    </div>
                </div>
                </div>
                <div id ="userInfo" class="col-sm-12 col-md-10">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="left_span">昵称</span>
                            <span class="right_span_2" id="show_nick_name">{{$user->nick_name}}</span>
                            <a class="a_edit" id="edit_nick_name" href="##">编辑</a>
                            <input class="form-control input_edit" type="text" id="nick_name" value="{{$user->nick_name}}">
                        </li>
                        <li class="list-group-item">
                            <span class="left_span">性别</span>
                            <span class="right_span_2" id="show_sex">
                                @if($user->sex===0)
                                   {{"女"}}
                                @elseif($user->sex==1)
                                    {{"男"}}
                                @endif
                            </span>
                            <a class="a_edit" id="edit_sex" href="##">编辑</a>
                            <button class="btn btn-default sex" sex="1" >男</button>
                            <button class="btn btn-default sex" sex="0" >女</button>
                        </li>
                        <li class="list-group-item">
                            <span class="left_span">一句话介绍</span>
                            <span class="right_span_5" id="show_signature">{{$user->signature}}</span>
                            <a class="a_edit" id="edit_signature" href="##">编辑</a>
                            <input class="form-control input_edit" type="text" id="signature" value="{{$user->signature}}">
                        </li>

                    </ul>
                </div>
             </div>
        </div>
    </div>
    <script src="/js/jquery.cropit.js"></script>
    <script>
        $(document).ready(function(){
            $(".input_edit").hide();
            $(".sex").hide();
            $("#edit_nick_name").click(function () {
              $("#nick_name").show();
            })
            $("#nick_name").blur(function () {
                var url = '/i/edit/nick_name';
                var userInfo = $("#nick_name").val();
                var id = "#show_nick_name";
                updateUserInfo(url,userInfo,id);
                $("#nick_name").hide();
            });

            $("#edit_sex").click(function () {
                $(".sex").show();
            })
            $(".btn").click(function () {
                var url = '/i/edit/sex';
                var userInfo = $(this).attr('sex');
                var id = "#show_sex";
                updateUserInfo(url,userInfo,id);
                $(".sex").hide();
            });

            $("#edit_signature").click(function () {
                $("#signature").show();
            })
            $("#signature").blur(function () {
                var url = '/i/edit/signature';
                var userInfo = $("#signature").val();
                var id = "#show_signature";
                updateUserInfo(url,userInfo,id);
                $("#signature").hide();
            });
            $("#my_photo").click(function () {
                $('#uploadFile').click();
                $('.image-editor').show();
            })
        });
        function updateUserInfo(url,userInfo,id){
            $.ajax({
                type:"post",
                url:url,
                data:{userInfo:userInfo},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                async:false,
                success:function(msg){
                    if(id!='null'){
                        $(id).html(userInfo);
                        if(url=="/i/edit/sex"){
                            if(userInfo==0){
                                $(id).html('女');
                            }else{
                                $(id).html('男');
                            }
                        }else if(url=="/i/edit/nick_name"){
                            $("#top_nick_name").text(userInfo);
                        }
                    }
                }

            })
        }
    </script>
    <script>
        $(function() {
            $('.image-editor').cropit({
                imageState: {
                    src: 'http://'+window.host+'/400/400/',
                },
            });

            $('.rotate-cw').click(function() {
                $('.image-editor').cropit('rotateCW');
            });
            $('.rotate-ccw').click(function() {
                $('.image-editor').cropit('rotateCCW');
            });

            $('.export').click(function() {
                var url = '/i/edit/photo';
                var userInfo = $('.image-editor').cropit('export');
                $("#my_photo").attr('src',userInfo);
                var id = "null";
                updateUserInfo(url,userInfo,id);
                $(".image-editor").hide();
            });
        });
    </script>
@endsection
