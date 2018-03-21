<link rel="stylesheet" href="/css/lightbox.css">
@extends('layouts.app')
@section('content')
    @if(Auth::check())
        @foreach($albums as $album)
            <div class="col-md-12">
                <div class="col-md-12">
                    <div  class="col-md-12 col-sm-12 col-lg-12 ">
                        <?php $date = strtotime($album['lastmodefieddate']);?>
                            <nav>
                                <ul class="pager">
                                    @if($lastAlumId)
                                        <li class="previous"><a href="/cloudealbum/maxpic/{{$lastAlumId}}">上一页</a></li>
                                    @endif

                                    <li  class="previous"><a href="##">{{date('Y-m-d',$date)}}</a></li>
                                    <li  class="previous"><a href="/cloudealbum/share/{{$album['id']}}&&{{$album['share']}}"><?php echo $album['share']?'不分享':'分享' ?></a></li>
                                    <li  class="previous"><a href="/cloudealbum/delete/{{$album['id']}}">删除</a></li>
                                    <li  class="previous"><a href="/cloudealbum">返回</a></li>
                                    @if($nextAlumId)
                                        <li class="previous"><a href="/cloudealbum/maxpic/{{$nextAlumId}}">下一页</a></li>
                                    @endif
                                </ul>
                            </nav>
                    </div>
                    <div >

                        <a id="imgHref" href="##" data-lightbox="example-1" data-title="{{date('Y-m-d',$date)}}"><img  class="img-responsive" alt="Responsive image" src="/upload/{{$album['maxpic']}}" ></a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
   {{-- <script src="/js/lightbox-plus-jquery.js"></script>--}}
    <script>
        $(function(){
            $(".img-responsive").click(function(e){
                var positionX=e.originalEvent.x-$(this).offset().left||e.originalEvent.layerX-$(this).offset().left||0;
                if (positionX < $(this).width()/2){
                    $("#imgHref").attr('href','{{$lastAlumId}}');
                }else{
                    $("#imgHref").attr('href','{{$nextAlumId}}');
                }
            });
        });

    </script>
@endsection








