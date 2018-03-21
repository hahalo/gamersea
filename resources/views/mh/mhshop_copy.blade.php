<head>
    <link href="http://localhost:81/twitter-bootstrap/bootstrap/twitter-bootstrap-v2/docs/assets/css/bootstrap.css" rel="stylesheet">

    <script src="../js/jquery-1.8.0.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.js" type="text/javascript"></script>
</head>
@extends('layouts.app')
@section('content')

   {{-- <ul class="nav nav-list bs-docs-sidenav affix-top">


            </div>
    </ul>

    <script type="text/javascript">
        $(function() {
            $('.nav li').click(function(e) {
                $('.nav li').removeClass('active');
                //$(e.target).addClass('active');
                $(this).addClass('active');
            });
        });

    </script>--}}

   <div class="container-fluid">
       <div class="row-fluid">
           <div class="span1.2">
               <div class="well sidebar-nav">
                   <ul class="nav nav-list">
                     {{--  <li class="active"><a href="#">HTML 4.01</a></li>--}}
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
               </div><!--/.well -->
           </div><!--/span-->
           <div class="span9">


               <div class="container">
                   @foreach($gmItems as $gmItemKey=>$gmItem)

                       <div >
                           <span style="color:tomato">{{$gmItemKey+1}}</span>&nbsp;&nbsp;&nbsp;
                           <span style="color:#339bb9">{{$gmItem['ItemName']}}</span>

                       </div>

                   @endforeach
                   <div class="col-md-12">  {!! $gmItems->render() !!}</div>


                </div>
               </div>
           </div>
   </div><!--/.fluid-container-->





@endsection
