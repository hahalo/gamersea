<?php
    date_default_timezone_set('prc');
    // session_start();
    $nowHours = date('H',time());
    if(isset($_SESSION['daynight'])){
        $_SESSION['daynight'];
    }else if($nowHours>=00&&$nowHours<=06){
        $_SESSION['daynight']=0;
    }else if($nowHours>=22&&$nowHours<=24){
        $_SESSION['daynight']=0;
    }else{
        $_SESSION['daynight']=1;
    }
?>
<link href="css/bootstrap-switch.min.css" rel="stylesheet">
<link href="css/highlight.css" rel="stylesheet">
<link rel="stylesheet" href="/css/lightbox.css">
{{--<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />--}}
<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.app_not_jq')
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <style type="text/css">
        #gallery-wrapper {
            position: relative;
            max-width: 90%;
            width: 90%;
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
@section('checkbox')
    <li > <a style="padding-top:13px"><input id="daynight" type="checkbox" checked data-size="mini"  data-on-text="白天" data-off-text="夜晚" data-off-color="danger" data-on-color="info" onclick="daynithtChange(this)"></a></li>
@endsection
@section('content')
 <body id="bg_body">
 <section id="gallery-wrapper">
     @foreach($bg as $bg_value)
         <?php $date = strtotime($bg_value['created_at']);?>
         <a href="upload/{{$bg_value['maxpic']}}" data-lightbox="e1" data-title="{{date('Y-m-d',$date)}}">
         <article class="white-panel" >
             <img src="upload/{{$bg_value['minpic']}}" class="thumb" >
             <h1>
                     {{date('Y-m-d',$date)}}
             </h1>
             <p></p>
         </article>
         </a>
     @endforeach
 </section>

{{-- <script src="js/jquery-1.6.4.min.js"></script>--}}
 <script src="http://libs.baidu.com/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
 <script src="/js/lightbox-plus-jquery.js"></script>
 <script src="js/pinterest_grid.js"></script>

{{-- <script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>--}}
 <script type="text/javascript">
     $(function(){
         $("#gallery-wrapper").pinterest_grid({
             no_columns: 4,
             padding_x: 10,
             padding_y: 10,
             margin_bottom: 50,
             single_column_breakpoint: 700
         });
         //

        /* $('#gallery-wrapper a').lightBox({
             containerResizeSpeed:10
         });
*/
     });
 </script>
 <script src="js/bootstrap-switch.min.js"></script>
 <script src="js/highlight.js"></script>
 <script>
     $(document).ready(function() {
         $(function(argument) {

             $('[type="checkbox"]').bootstrapSwitch({
                 onSwitchChange: function(event, state) {
                     event.preventDefault();
                     $.ajax ({
                         data: {state:state},
                         type: "POST",
                         url: "/daynight",
                         headers: {
                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
                         success: function(msg) {
                             if(msg==1){
                                 $('#bg_body').css("background-color","white");
                             }else{
                                 $('#bg_body').css("background-color","black");
                             }
                         }
                     });
                 }
             });
             var daynight = '<?php echo $_SESSION['daynight']?>';
             if(daynight==0){
                 $('[type="checkbox"]').bootstrapSwitch('state', false, false);
             }else{
                 $('[type="checkbox"]').bootstrapSwitch('state', true, true);
             }
         });
     });

 </script>
 </body>
@endsection








