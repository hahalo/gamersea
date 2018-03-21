<link rel="stylesheet" href="/css/lightbox.css">
@extends('layouts.app')
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" type="text/css" href="css/default.css">
<style type="text/css">

    #gallery-wrapper {
        position: relative;
        max-width: 95%;
        width: 95%;
        margin:50px auto;
    }
    img.thumb {
        width: 100%;
        max-width: 100%;
        height: auto;
    }
    .white-panel {
        position: absolute;
        background: white;
        border-radius: 5px;
        box-shadow: 0px 1px 2px rgba(0,0,0,0.3);
        padding: 10px;
    }
    .white-panel h1 {
        font-size: 1em;
    }
    .white-panel h1 a {
        color: #A92733;
    }
    .white-panel:hover {
        box-shadow: 1px 1px 10px rgba(0,0,0,0.5);
        margin-top: -5px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }
</style>
@section('content')
    @if(Auth::check())
        <div class="col-md-1" style="float:right;"><a href="/addPhoto" class="btn btn-link">上传 </a></div>
        <div class="form-group">
            <section id="gallery-wrapper">
                @foreach($albums as $alubm)
                    <article class="white-panel" id="article_{{$alubm['id']}}">
                        <a href="/cloudealbum/maxpic/{{$alubm['id']}}"> <img src="/upload/{{$alubm['minpic']}}" class="thumb" ></a>
                        <h1><a href="/cloudealbum/maxpic/{{$alubm['title']}}">
                                <?php $date = strtotime($alubm['lastmodefieddate']);?>
                                <p>
                                    {{date('Y-m-d',$date)}}
                                </p>
                                <p>
                                    <a id="share_{{$alubm['id']}}" share="{{$alubm['share']}}" href="###" style="text-decoration:none;" onclick="sharePic({{$alubm['id']}})"><?php echo $alubm['share']?'不分享':'分享' ?></a>
                                </p>
                                <p>
                                    <a onclick="deletePic({{$alubm['id']}})" href="##" style="text-decoration:none;">删除</a>
                                </p>

                            </a>
                        </h1>
                    </article>
                @endforeach
            </section>
            <div class="form-group" style="width:800px;margin:0 auto;">  {!! $albums->render() !!}</div>
        </div>

    @endif
    <script src="js/pinterest_grid.js"></script>
    <script type="text/javascript">
        $(function(){
            $("#gallery-wrapper").pinterest_grid({
                no_columns: 5,
                padding_x: 10,
                padding_y: 10,
                margin_bottom: 50,
                single_column_breakpoint: 700
            });

        });
        function deletePic(id){
            if(confirm('是否删除?')){
               $.ajax({
                  url:"/cloudealbum/delete/"+id,
                  type:"get",
                   success:function (msg) {
                       $("#article_"+id).hide();
                   }
               });
               // location.href="/cloudealbum/delete/"+id;
            }
        }
        function sharePic(id){
            var share = $("#share_"+id).attr('share');

            if(share==0){
                var shareAfterText = "不分享";
                var shareAfter = 1;
            }else{
                var shareAfterText = "分享";
                var shareAfter = 0;
            }
            $("#share_"+id).html(shareAfterText);
            $.ajax({
                url:"cloudealbum/share/"+id+"&&"+share,
                type:"get",
                success:function (msg) {
                    $("#share_"+id).attr('share',shareAfter);
                }
            });
        }

    </script>
@endsection
