@extends('layouts.app')
@section('content')
   <div class="form-group">
            <div class="col-lg-8">
                    <div class="input-group">
                        <input type="text" id="s" name="s" class="form-control" placeholder="将要看的视频地址复制进来，就能解析出实际VIP地址">
                        <span class="input-group-btn">
                             <input type="submit" value="搜索" id='search' class="btn btn-default" >
                         </span>
                    </div><!-- /input-group -->
					<div class="container" style="margin-top: 10px">
                    <div class="row">
                        <div class="form-group" id="vdeoUrlDiv" style="display:none">
						<span id = "videoUrl"></span> <button style="margin-left:10px" class="btn btn-default" id="openVideo">打开视频</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-lg-6 -->
	</div><!-- /.row -->
	<script>
	$("#search").click(function(){
	  var pageUrl = $("#s").val();
	   burl = "http://"+Math.ceil(Math.random()*100000)+".mxtv.72du.com/?url=" + encodeURIComponent(pageUrl);
	   window.open(burl) 
	   //$("#videoUrl").html(burl);
	   //$("#vdeoUrlDiv").show();
	});
	$("#openVideo").click(function(){
		window.open(burl) 
	});
	</script>
@endsection

