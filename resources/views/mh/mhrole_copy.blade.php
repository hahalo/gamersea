<?php
    //判断是否有搜索内容
    if(isset($_GET['s'])){
        $itemname = $_GET['s'];
    }else{
        $itemname = '';
    }
?>
@extends('layouts.app_not_jq')
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="/js/jquery-1.9.1.min.js"></script>
<script src="/js/jquery-ui-1.11.4.min.js"></script>
<script src="/js/jquery.minicolors.js"></script>
<link rel="stylesheet" href="/css/jquery.minicolors.css">
<meta name="_token" content="{{ csrf_token() }}"/>
@section('content')
   <div class="container-fluid">
       <div class="row-fluid">
           <div class="col-md-1 col-xs-3">
               <ul class="nav nav-pills nav-stacked" role="tablist">
                   <li class="panel panel-primary" style="line-height:36px;font-size: 17px;font-weight: 300;">
                       <center>角色栏</center>
                   </li>
                   @foreach($gameNames as $gameName)
                       @if(!empty($gameName->Name))
                           {{--active--}}
                           <li  >
                               <a href="/mhrole/role/{{$gameName->Name}}" @if($role==$gameName->Name) class="label label-info" @endif>
                                   {{$gameName->Name}}
                               </a>
                           </li>
                       @endif
                   @endforeach

               </ul>
           </div>
           <div class="col-md-10 col-xs-9">
               <div class="container">
                   <form method="get" action="/mhrole/search">
                    <div class="col-md-9 input-group">
                     <input type="text" id="s" name="s" class="form-control" placeholder="我的装备">
                     <span class="input-group-btn">
                     <input type="submit" value="搜索" id='search' class="btn btn-default" >
                     </span>
                    </div><!-- /input-group -->
                   </form>

                    <!-- 选择角色-->
                   @if(Auth::check())
                       <div class="row">
                           <div class="col-md-5 col-lg-5 ">
                               <div class="input-group">
                                   <div class="input-group-btn">
                                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                               <span id="scroll" >附魔卷轴</span>
                                           <span class="caret"></span></button>
                                       <ul class="dropdown-menu" role="menu">
                                           @if(!empty($enchantScrolls))
                                               @foreach($enchantScrolls as $enchantScroll)
                                                   <li scrollid="{{$enchantScroll['id']}}"><a href="#">[{{$enchantScroll['part']}}] {{$enchantScroll['name']}}</a></li>
                                               @endforeach
                                           @endif
                                       </ul>
                                   </div><!-- /btn-group -->
                                   <input type="text" class="form-control" name="goods" id="goods" placeholder="物品">
                                   <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="enchanting">附魔</button>
                                    <button class="btn btn-default" type="button" id="send">邮寄</button>
                                  </span>
                               </div><!-- /input-group -->
                           </div><!-- /.col-lg-6 -->

                           <div class="col-md-4 col-lg-4 ">
                               <span >强化：</span>
                               <input style="width: 20px;height: 26px" class="spinner" name="spinner" id = "spinner" value="10">
                               <span><button class="btn btn-default" type="button" id="enhance">强化</button></span>
                               <span >&nbsp;&nbsp;等级：</span>
                               <input style="width: 20px;height: 26px" class="spinner_level" name="spinner_level" id = "spinner_level" value="90">
                               <span><button class="btn btn-default" type="button" id="upgrade">升级</button></span>
                           </div>

                       </div><!-- /.row --><p></p>
                   @else
                     <p>登陆后才能购买</p>
                   @endif
                   <div class="row">
                       <div class="col-lg-2 col-sm-2 col-2">
                           <div class="form-group">
                               <input type="text" id="color1" class="form-control demo" value="#000000">
							<span class="help-block">

							</span>
                           </div>
                       </div>
                       <div class="col-lg-2 col-sm-4 col-12">
                           <div class="form-group">

                               <input type="text" id="color2" class="form-control demo" data-defaultValue="#000000">

                           </div>
                       </div>
                       <div class="col-lg-2 col-sm-4 col-12">
                           <div class="form-group">

                               <input type="text" id="color3" class="form-control demo" data-letterCase="uppercase" value="#000000">

                           </div>
                       </div>
                       <div class="col-lg-4 col-sm-4 col-12">
                           <div class="form-group">
                               <span><button class="btn btn-default" type="button" id="dyeing">染色</button></span>
                               &nbsp;
                               <span id="red">0</span>
                           </div>
                       </div>
                   </div>
                   @foreach($gameRoleInfos as $gameRoleInfoKey=>$gameRoleInfo)

                       <div id="d_{{$gameRoleInfo['UID']}}" >
                           <span style="color:tomato">
                               {{--算法：key+1+当前记录*页数-1--}}
                               <?php if(!isset($_GET['page'])){$_GET['page']=1;}?>
                               {{ $gameRoleInfoKey+1+$pageSize*($_GET['page']-1) }}
                           </span>&nbsp;
                           <span onclick="roleList('{{$gameRoleInfo['ItemName']}}','{{$gameRoleInfo['UID']}}')" class="btn btn-link" style="color:#339bb9">

                               @if(!empty($gameRoleInfo['ItemType']))
                                   <a style="color:#9e78c0">[{{$gameRoleInfo['ItemType']}}]</a>
                               @endif
                               @if(!empty($gameRoleInfo['ENHANCE']))
                                   <span style="color: crimson">+{{$gameRoleInfo['ENHANCE']}}</span>
                               @endif
                               {{--显示装备附魔卷轴前缀--}}
                               @if(!empty($gameRoleInfo['PREFIX']))
                                   @foreach($enchantScrolls as $enchantScroll)
                                       @if($enchantScroll['code']==$gameRoleInfo['PREFIX'])
                                           <span style="color:seagreen">{{$enchantScroll['name']}}</span>
                                       @endif
                                   @endforeach
                               @endif
                               {{--显示装备附魔卷轴后缀--}}
                               @if(!empty($gameRoleInfo['SUFFIX']))
                                   @foreach($enchantScrolls as $enchantScroll)
                                       @if($enchantScroll['code']==$gameRoleInfo['SUFFIX'])
                                           <span style="color: seagreen">{{$enchantScroll['name']}}</span>
                                       @endif
                                   @endforeach
                               @endif
                               {{--显示物品名称--}}
                               {{$gameRoleInfo['ItemName']}}
                           </span>

                           @if($gameRoleInfo['Color1']!='')
                              <span id="c1_{{$gameRoleInfo['UID']}}"style="color:#{{dechex($gameRoleInfo['Color1'])}}; font-size:x-large">■</span>
                           @endif
                           @if($gameRoleInfo['Color2']!='')
                               <span id="c2_{{$gameRoleInfo['UID']}}" style="color:#{{dechex($gameRoleInfo['Color2'])}};font-size:x-large">■</span>
                           @endif
                           @if($gameRoleInfo['Color3']!='')
                               <span id="c3_{{$gameRoleInfo['UID']}}" style="color:#{{dechex($gameRoleInfo['Color3'])}};font-size:x-large">■</span>
                           @endif
                           <button onclick="deleteItem('{{$gameRoleInfo['UID']}}')" class="btn btn-link" style="color:tomato"  >删除</button>

                       </div>
                   @endforeach

                  {{-- <div class="col-md-12">  {!! $paginator->render() !!}</div>--}}
                   <div class="col-md-12"> {!! $paginator->appends(['s' => "$itemname"])->render() !!}</div>

               </div>
           </div>
       </div>
   </div><!--/.fluid-container-->
   <script>
       $(function() {
           $( "#spinner" ).spinner({
               min: 1,
               max: 15,
               step: 1,
           });
           $( "#spinner_level" ).spinner({
               min: 1,
               max: 90,
               step: 1,
           });

           $(".dropdown-menu li").click(function(){
               var scrollname = $(this).text();
               var scrollid = $(this).attr('scrollid');
               $("#scroll").text(scrollname);
               $("#scroll").attr('scrollid',scrollid);
           });

           //邮寄
           $("#send").click(function () {
               var scrollid = $("#scroll").attr("scrollid");
               var scrollName = $("#scroll").text();
               if(scrollid!=""&&scrollName!=""){
                   //send
                   $.ajax({
                       url:'/mhrole/send',
                       type: "POST",
                       data:{scrollid:scrollid},
                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                       },
                       async:false,
                       success:function (msg) {
                           $("#goods").val(scrollName+",已经发送到您的邮箱里！");
                       }
                   });
               }else{
                   $("#goods").val("无法预料到的错误！");
               }
           });
           //强化
           $("#enhance").click(function () {
               var itemid = $("#goods").attr("itemid");
               var level = $("#spinner").val();
               var goodsName = $("#goods").val();
               if(itemid!=""&&level<=15){
                   $.ajax({
                       url:'/mhrole/enhance',
                       type: "POST",
                       data:{itemid:itemid,level:level},
                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                       },
                       async:false,
                       success:function (msg) {
                           $("#goods").val(goodsName+",强化成功！");
                       }
                   });
               }else{
                   $("#goods").val("无法预料到的错误！");
               }
           });
           //升级
           $("#upgrade").click(function () {
               var level = $("#spinner_level").val();
               if(level<=90){
                   $.ajax({
                       url:'/mhrole/upgrade',
                       type: "POST",
                       data:{level:level},
                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                       },
                       async:false,
                       success:function (msg) {
                           var data = JSON.parse(msg);
                           if(data['success']==1){
                               $("#goods").val(data['info']+"等级已经提升到"+level+"级");
                           }else{
                               $("#goods").val("信息提供有误，无法升级！");
                           }
                       }
                   });
               }else{
                   $("#goods").val("无法预料到的错误！");
               }
           });
           //附魔
           $("#enchanting").click(function () {
               var itemid = $("#goods").attr("itemid");
               var scrollid = $("#scroll").attr("scrollid");
               var goodsName = $("#goods").val();
               if(scrollid!=""&&goodsName!=""&&itemid!=""){
                   //send
                   $.ajax({
                       url:'/mhrole/enchanting',
                       type: "POST",
                       data:{scrollid:scrollid,itemid:itemid},
                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                       },
                       async:false,
                       success:function (msg) {
                          // console.log(msg);
                           $("#goods").val(goodsName+",附魔成功！");
                       },error(msg){
                           //console.log(msg);
                       }
                   });
               }else{
                   $("#goods").val("无法预料到的错误！");
               }
           });
           //染色
           $("#dyeing").click(function () {
               var color1 = $("#color1").val();
               var color2 = $("#color2").val();
               var color3 = $("#color3").val();
               var itemid = $("#goods").attr("itemid");
               if(color1!=""&&color2!=""&&color3!=""&&itemid!=""){
                   //send
                   $.ajax({
                       url:'/mhrole/dyeing',
                       type: "POST",
                       data:{color1:color1,color2:color2,color3:color3,itemid:itemid},
                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                       },
                       async:false,
                       success:function (msg) {
                           var data = JSON.parse(msg);
                           if(data['success']==1){
                              $("#c1_"+itemid).css('color',color1);
                              $("#c2_"+itemid).css('color',color2);
                              $("#c3_"+itemid).css('color',color3);
                           }
                          // $("#goods").val(goodsName+",染色成功！");
                       },error(msg){
                           //console.log(msg);
                       }
                   });
               }else{
                   $("#goods").val("无法预料到的错误！");
               }
           });
           //
           // Dear reader, it's actually very easy to initialize MiniColors. For example:
           //
           //  $(selector).minicolors();
           //
           // The way I've done it below is just for the demo, so don't get confused
           // by it. Also, data- attributes aren't supported at this time...they're
           // only used for this demo.
           //
           $('.demo').each( function() {
               $(this).minicolors({
                   control: $(this).attr('data-control') || 'hue',
                   defaultValue: $(this).attr('data-defaultValue') || '',
                   inline: $(this).attr('data-inline') === 'true',
                   letterCase: $(this).attr('data-letterCase') || 'lowercase',
                   opacity: $(this).attr('data-opacity'),
                   position: $(this).attr('data-position') || 'bottom left',
                   change: function(hex, opacity) {
                       if( !hex ) return;
                       if( opacity ) hex += ', ' + opacity;
                       try {
                           $("#red").text(hex.colorRgb());
                           //console.log(hex);
                       } catch(e) {}
                   },
                   theme: 'bootstrap'
               });

           });
       });
       
        function roleList(goods,id) {
            $("#goods").val(goods);
            $("#goods").attr('itemID',id);
            var c1 = $("#c1_"+id).css("color");
            var c2 = $("#c2_"+id).css("color");
            var c3 = $("#c3_"+id).css("color");
            if(typeof (c1)=='undefined'&& typeof (c2)=='undefined' && typeof (c3)=='undefined'){
                c1='#000000';
                c2='#000000';
                c3='#000000';
            }
            $("#color1").val( c1.colorHex());
            $("#color2").val( c2.colorHex());
            $("#color3").val( c3.colorHex());
            $("#color1").next().children().css( "background-color",c1);
            $("#color2").next().children().css( "background-color",c2);
            $("#color3").next().children().css( "background-color",c3);
        }
       function deleteItem(deleteId) {
           var deleteConfirm = confirm("你真的要删吗？");
          if(deleteId!=''&&deleteConfirm==true){
               $.ajax({
                   url:'/mhrole/delete',
                   type: "POST",
                   data:{itemid:deleteId},
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   },
                   async:false,
                   success:function (msg) {
                       var data = JSON.parse(msg);
                       if(data['success']==1){
                            $("#d_"+deleteId).remove();
                       }
                   },error(msg){
                      // console.log(msg);
                   }
               });
           }
       }
       //十六进制颜色值的正则表达式
       var reg = /^#([0-9a-fA-f]{3}|[0-9a-fA-f]{6})$/;
       /*rgb转换16进制*/
       /*RGB颜色转换为16进制*/
       String.prototype.colorHex = function(){
           var that = this;

           if(/^(rgb|RGB)/.test(that)){
               var aColor = that.replace(/(?:\(|\)|rgb|RGB)*/g,"").split(",");

               var strHex = "#";

               for(var i=0; i<aColor.length; i++){

                   var hex = Number(aColor[i]).toString(16);

                   if(hex === "0"){
                       hex += hex;
                   }
                   strHex += hex;
               }
               if(strHex.length !== 7){
                   strHex = that;
               }
               return strHex;
           }else if(reg.test(that)){
               var aNum = that.replace(/#/,"").split("");
               if(aNum.length === 6){
                   return that;
               }else if(aNum.length === 3){
                   var numHex = "#";
                   for(var i=0; i<aNum.length; i+=1){
                       numHex += (aNum+aNum);
                   }
                   return numHex;
               }
           }else{
               return that;
           }};
       /*16进制颜色转为RGB格式*/
       String.prototype.colorRgb = function(){
           var sColor = this.toLowerCase();
           if(sColor && reg.test(sColor)){
               if(sColor.length === 4){
                   var sColorNew = "#";
                   for(var i=1; i<4; i+=1){
                       sColorNew += sColor.slice(i,i+1).concat(sColor.slice(i,i+1));
                   }
                   sColor = sColorNew;

               }
               //处理六位的颜色值
               var sColorChange = [];
               for(var i=1; i<7; i+=2){
                   sColorChange.push(parseInt("0x"+sColor.slice(i,i+2)));
               }
               return "RGB(" + sColorChange.join(",") + ")";
           }else{
               return sColor;
           }
       };


   </script>





@endsection
