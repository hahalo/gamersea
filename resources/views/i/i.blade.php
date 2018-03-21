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
.myInfo{
    margin-top:210px;
}
</style>
@section('content')
    <div class="col-md-12">
        <div class="jumbotron">
            <div class="container">
                <div class="row myInfo">
                    <div class="col-sm-3 col-md-3">
                        <div >
                            @if(!empty($user['photo']))
                                <img  src="/icon/{{$user['photo']}}" class="img-thumbnail">
                            @else
                                <img  src="/upload/Max_201612311553488619.gif" class="img-thumbnail">
                            @endif
                            <div class="caption">
                                <h3>Hello,
                                    <small>
                                        @if(!empty($user['nick_name']))
                                            {{$user['nick_name']}}
                                        @else
                                            {{$user['name']}}
                                        @endif
                                    </small>
                                    &nbsp;
                                    <small style="font-size: 60%">关注：{{$followNum}}</small>
                                    &nbsp;
                                    <small style="font-size: 60%">粉丝：{{$isFollowNum}}</small>
                                </h3>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-6" style="margin-top: 70px;">
                        <h4>{{$user->signature}}</h4>
                    </div>
                </div>
                <div class="row">
                    <p class="masthead-button-links">
                        <a class="btn btn-lg btn-primary btn-shadow" href="i/edit"  role="button" >编辑个人资料</a>
                    </p>
                </div>
                <div class="row">
                    <p>
                        <b>全部关注</b><span> {{$followNum}}</span>
                    </p>
                    @foreach($follows as $follow)
                        <div class="col-md-2 col-xs-6">
                            <a href="/i/people/{{$follow['followid']}}">
                            @if(empty($follow['photo']))
                                <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTlkOGU2OGI1MSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1OWQ4ZTY4YjUxIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ1LjUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" class="img-rounded" style="height: 140px; width: 140px;">
                            @else
                                <img src="/icon/{{$follow['photo']}}" class="img-rounded" style="height: 140px; width: 140px;" >
                            @endif
                            </a>
                            <div class="caption ">
                                <h3>

                                    <small style="font-size: 60%">
                                        @if($follow['sex']===1)
                                            <span style="color: #00b7ee;font-weight: bold">♂</span>
                                        @else
                                            <span style="color: red;font-weight: bold">♀</span>
                                        @endif
                                    </small>
                                    <small>
                                        <a href="/i/people/{{$follow['followid']}}">
                                        @if(!empty($follow['nick_name']))
                                            {{$follow['nick_name']}}
                                        @else
                                            {{$follow['name']}}
                                        @endif
                                        </a>
                                    </small>
                                    {{--<p>
                                        @if(!empty($follow['signature']))
                                            {{$follow['signature']}}
                                        @endif
                                    </p>--}}
                                </h3>
                                <p>
                                    <span type="button" follow="1" id="ifollow_{{$follow['followid']}}" style="padding:2px 12px;" type="button" class="btn btn-danger" onclick="follow('{{$follow['followid']}}','ifollow')">取关</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <p>
                        <b>粉丝</b><span> {{$isFollowNum}}</span>
                    </p>
                    @foreach($fans as $fan)
                        <div class="col-md-2 col-xs-6">
                            <a href="/i/people/{{$fan['userid']}}">
                            @if(empty($fan['photo']))
                                <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTlkOGU2OGI1MSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1OWQ4ZTY4YjUxIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ1LjUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" class="img-rounded" style="height: 140px; width: 140px;">
                            @else
                                <img src="/icon/{{$fan['photo']}}" class="img-rounded" style="height: 140px; width: 140px;" >
                            @endif
                            </a>
                            <div class="caption ">
                                <h3>

                                    <small style="font-size: 60%">
                                        @if($fan['sex']===1)
                                            <span style="color: #00b7ee;font-weight: bold">♂</span>
                                        @else
                                            <span style="color: red;font-weight: bold">♀</span>
                                        @endif
                                    </small>
                                    <small>
                                        <a href="/i/people/{{$fan['userid']}}">
                                        @if(!empty($fan['nick_name']))
                                            {{$fan['nick_name']}}
                                        @else
                                            {{$fan['name']}}
                                        @endif
                                        </a>
                                    </small>
                                   {{-- <p>
                                        @if(!empty($fan['signature']))
                                            {{$fan['signature']}}
                                        @endif
                                    </p>--}}
                                </h3>

                                <p>
                                    @if(!empty($iFollowArr))
                                        @if(in_array($fan['userid'],$iFollowArr))
                                            <span type="button" follow="1" id="ifans_{{$fan['userid']}}" style="padding:2px 12px;" type="button" class="btn btn-danger" onclick="follow('{{$fan['userid']}}','ifans')">取关</span>
                                        @else
                                        <span type="button" follow="0" id="ifans_{{$fan['userid']}}" style="padding:2px 12px;" type="button" class="btn btn-primary" onclick="follow('{{$fan['userid']}}','ifans')">关注</span>
                                        @endif
                                    @else
                                        <span type="button" follow="0" id="ifans_{{$fan['userid']}}" style="padding:2px 12px;" type="button" class="btn btn-primary" onclick="follow('{{$fan['userid']}}','ifans')">关注</span>
                                    @endif
                                </p>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>

        function follow(followid,type){
            /**
             * type:ifollow,ifans
             * @type {*|jQuery}
             */
            var isfollow = $("#"+type+"_"+followid).attr("follow");
            if(isfollow==1){
                var url="/i/unfollow";
            }else{
                var url="/i/follow";
            }
            $.ajax({
                type:"post",
                url:url,
                followid:followid,
                data:{followid:followid},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                async:false,
                success:function(msg){
                    if(isfollow==1){
                        $("#"+type+"_"+followid).attr("follow",'0');
                        $("#"+type+"_"+followid).attr("class","btn btn-primary");
                        $("#"+type+"_"+followid).text("关注");
                    }else{
                        $("#"+type+"_"+followid).attr("follow",'1');
                        $("#"+type+"_"+followid).attr("class","btn btn-danger");
                        $("#"+type+"_"+followid).text("取关");
                    }
                }
            })
        }
    </script>



@endsection
