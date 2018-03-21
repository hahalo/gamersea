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

</style>
@section('content')
    <div class="col-md-12">
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-md-3">
                        <div >
                            @if(!empty($user['photo']))
                                <img  src="/icon/{{$user['photo']}}" class="img-thumbnail">
                            @else
                                <img  src="/upload/Max_201612311553488619.gif" class="img-thumbnail">
                            @endif
                            <div class="caption">
                                <h3>
                                    @if($user['sex']===1)
                                        他的名字,
                                    @else
                                        她的名字,
                                    @endif
                                    <small>
                                        @if(!empty($user['nick_name']))
                                            {{$user['nick_name']}}
                                        @else
                                            {{$user['name']}}
                                        @endif
                                    </small>
                                        @if(Auth::check())
                                            <button id="follow" style="float: right;padding:2px 12px;" type="button" class="btn btn-primary" onclick="follow('{{$id}}')">关注</button>
                                            <button id="unFollow" style="display:none;float: right;padding:2px 12px;" type="button" class="btn btn-danger" onclick="unFollow('{{$id}}')">取关</button>
                                        @else
                                            <a href="/login"> <button style="float: right;padding:2px 12px;" type="button" class="btn btn-primary">关注</button></a>
                                        @endif

                                </h3>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6" style="margin-top: 70px;">
                        <h4>{{$user->signature}}</h4>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        $(function () {
            var isFollow = '<?php echo $isFollow;?>';
            if(isFollow==1){
                $("#unFollow").show();
                $("#follow").hide();
            }
        })
        function follow(followid){
            $.ajax({
                type:"post",
                url:"/i/follow",
                followid:followid,
                data:{followid:followid},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                async:false,
                success:function(msg){
                    $("#follow").hide();
                    $("#unFollow").show();
                }
            })
        }
        function unFollow(followid){
            $.ajax({
                type:"post",
                url:"/i/unfollow",
                followid:followid,
                data:{followid:followid},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                async:false,
                success:function(msg){
                    $("#unFollow").hide();
                    $("#follow").show();
                }
            })
        }
    </script>



@endsection
