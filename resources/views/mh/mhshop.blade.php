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
<meta name="_token" content="{{ csrf_token() }}"/>
@section('content')
   <div class="container-fluid">
       <div class="row-fluid">
           <div class="col-md-2 col-xs-3">
               <ul class="nav nav-pills nav-stacked" role="tablist">
                   @foreach($gmItemsGruops as $gmItemsGruop)
                       @if(!empty($gmItemsGruop['ItemType']))
                           {{--active--}}
                           <li class=" @if(isset($type)&&$type==$gmItemsGruop['ItemType'])active @endif">
                               <a href="/mhshop/group/{{$gmItemsGruop['ItemType']}}">
                                   {{$gmItemsGruop['ItemType']}}
                               </a>
                           </li>
                       @endif
                   @endforeach
               </ul>
           </div>

           <div class="col-md-8 col-xs-9">
               <form method="get" action="/mhshop/search">
                   <div class="input-group">
                         <input type="text" id="s" name="s" class="form-control" placeholder="买买买">
                         <span class="input-group-btn">
                         <input type="submit" value="搜索" id='search' class="btn btn-default" >
                         </span>
                   </div><!-- /input-group -->
               </form>

               <div class="container">
                    <!-- 选择角色-->
                   @if(Auth::check())
                       <div class="row">
                           <div class="col-md-5 col-lg-5 col-xs-5">
                               <div class="input-group">
                                   <div class="input-group-btn">
                                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                               @if(Session::has('role'))
                                               <span id="role" rid="{{session('rid')}}">{{session('role')}}</span>
                                               @else
                                               <span id="role">请选择角色</span>
                                               @endif
                                           <span class="caret"></span></button>
                                       <ul class="dropdown-menu" role="menu">
                                           @if(!empty($gameNames))
                                               @foreach($gameNames as $gameName)
                                                   <li rid="{{$gameName->RID}}"><a href="#">{{$gameName->Name}}</a></li>
                                               @endforeach
                                           @endif
                                       </ul>
                                   </div><!-- /btn-group -->
                                   <input type="text" class="form-control" name="goods" id="goods" placeholder="物品">
                                   <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="buy">购买</button>
                                  </span>
                               </div><!-- /input-group -->
                           </div><!-- /.col-lg-6 -->

                           <div class="col-md-2 col-lg-2">
                               <span >数量：</span>
                               <input style="width: 20px;height: 26px" class="spinner" name="spinner" id = "spinner" value="1">
                           </div>
                       </div><!-- /.row --><p></p>
                   @else
                     <p>登陆后才能购买</p>
                   @endif

                   @foreach($gmItems as $gmItemKey=>$gmItem)

                       <div >
                           <span style="color:tomato">
                               {{--算法：key+1+当前记录*页数-1--}}
                              <?php if(!isset($_GET['page'])){$_GET['page']=1;}?>
                               {{ $gmItemKey+1+$pageSize*($_GET['page']-1) }}
                           </span>&nbsp;
                           <span onclick="roleList('{{$gmItem['ItemName']}}','{{$gmItem['ID']}}')" class="btn btn-link" style="color:#339bb9">
                               @if(!empty($gmItem['ItemType']))
                                   <a style="color:#9e78c0">[{{$gmItem['ItemType']}}]</a>
                               @endif
                                   {{$gmItem['ItemName']}}
                           </span>
                           @if(Auth::check())
                             {{--  <input style="width: 20px;" class="spinner" name="spinner" id = "spinner_{{$gmItem['ID']}}" value="1">--}}
                              {{-- <button type="button" class="btn btn-link">购买</button>--}}
                           @endif

                       </div>
                   @endforeach

                   <div class="col-md-12">  {!! $gmItems->appends(['s' => "$itemname"])->render() !!}</div>


                </div>
           </div>
       </div>
   </div><!--/.fluid-container-->
   <script>
       $(function() {
           $( ".spinner" ).spinner({
               min: 1,
               max: 999,
               step: 1,
           });

           $(".dropdown-menu li").click(function(){
               var username = $(this).text();
               var rid = $(this).attr('rid');
               $("#role").text(username);
               $("#role").attr('rid',rid);
           });
           $("#buy").click(function () {
               var goodsNum = $("#spinner").val();
               var itemID = $("#goods").attr('itemID');
               var role = $("#role").text();
               var rid = $("#role").attr('rid');
               var goodsName = $("#goods").val();
               if(role!=""&&itemID!=""&&goodsNum!=""&&goodsName!=""){
                   //buy
                   $.ajax({
                       url:'/mhshop/buy',
                       type: "POST",
                       data:{goodsNum:goodsNum,itemID:itemID,role:role,rid:rid},
                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                       },
                       async:false,
                       success:function (msg) {
                           $("#goods").val("购买成功！"+goodsName+",已经发送到您的邮箱里！");
                       }
                   });
               }else{
                   $("#goods").val("请选择正确物品！");
               }
           })
       });
    function roleList(goods,id) {
        $("#goods").val(goods);
        $("#goods").attr('itemID',id);
    }


   </script>





@endsection
