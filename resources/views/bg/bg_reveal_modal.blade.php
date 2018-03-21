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

        .reveal-modal-bg { position: fixed; height: 100%; width: 100%; z-index: 100; display: none; top: 0; left: 0; background:rgba(00, 00, 00, 0.8) }

        .reveal-modal { visibility: hidden;z-index: 101;padding: 30px 40px 34px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; -moz-box-shadow: 0 0 10px rgba(0,0,0,.4); -webkit-box-shadow: 0 0 10px rgba(0,0,0,.4); -box-shadow: 0 0 10px rgba(0,0,0,.4); background-color: #FFF;
            position: fixed;
            top: 50%;
            left: 50%;
            width:80%;
            height: 80%;
            -webkit-transform: translateX(-50%) translateY(-50%);
        }

        .reveal-modal.small 		{ width: 200px; margin-left: -140px;}
        .reveal-modal.medium 		{ width: 400px; margin-left: -240px;}
        .reveal-modal.large 		{ width: 600px; margin-left: -340px;}
        .reveal-modal.xlarge 		{ width: 800px; margin-left: -440px;}

        .reveal-modal .close-reveal-modal { font-size: 22px; line-height: 0.5; position: absolute; top: 8px; right: 11px; color: #333; text-shadow: 0 -1px 1px rbga(0,0,0,.6); font-weight: bold; cursor: pointer; 		}
    </style>
    <!--[if lt IE 9]>
    <style>
        .reveal-modal-bg{filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#cc000000,endColorstr=#cc000000);}
    </style>
    <![endif]-->
@section('checkbox')
    <li > <a style="padding-top:13px"><input id="daynight" type="checkbox" checked data-size="mini"  data-on-text="白天" data-off-text="夜晚" data-off-color="danger" data-on-color="info" onclick="daynithtChange(this)"></a></li>
@endsection
@section('content')
 <body id="bg_body">
 <section id="gallery-wrapper">
     @foreach($bg as $bg_value)
         <a class="big-link" data-reveal-id="myModal" data-animation="fade" href="#">
         <article class="white-panel" >
             <img src="upload/{{$bg_value['minpic']}}" class="thumb" >
             <h1><a href="#" >
                     <?php $date = strtotime($bg_value['created_at']);?>
                     {{date('Y-m-d',$date)}}
                 </a>
             </h1>
             <p></p>
         </article>
         </a>
     @endforeach

 </section>
 <div id="myModal" class="reveal-modal">
         <a class="close-reveal-modal">&#215;</a>
         <img id = "show_img" src="" style="width: auto;height:auto;max-width:100%;max-height:100%;">
 </div>
 <script src="js/jquery-1.6.4.min.js"></script>
 <script src="js/jquery.reveal.js"></script>
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
         //图片动态替换
        $(".thumb").click(function () {
            var imgSrc = this.src;
            imgSrc = imgSrc.replace("Min_","Max_");
            $("#show_img").attr('src',imgSrc);
        });
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








