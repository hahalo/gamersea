<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>兼容IE8的响应式网格瀑布流布局jQuery插件</title>
    <link rel="stylesheet" href="http://localhost:81/h5/jQuery_Pinterest/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="http://localhost:81/h5/jQuery_Pinterest/css/default.css">
    <style type="text/css">
        #gallery-wrapper {
            position: relative;
            max-width: 75%;
            width: 75%;
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
    <!--[if IE]>
    <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body>
<section class="htmleaf-container">
    <header class="htmleaf-header">
        <h1>兼容IE8的响应式网格瀑布流布局jQuery插件 <span>A Simple jQuery Plugin To Create Pinterest Style Grid Layout</span></h1>
        <div class="htmleaf-links">
            <a class="htmleaf-icon icon-htmleaf-home-outline" href="http://www.jb51.net/" title="脚本之家" target="_blank"><span> 脚本之家</span></a>
            <a class="htmleaf-icon icon-htmleaf-arrow-forward-outline" href="http://www.jb51.net/" title="返回下载页" target="_blank"><span> 返回下载页</span></a>
        </div>
    </header>
</section>
<section id="gallery-wrapper">
    <article class="white-panel">
        <img src="img/1.jpg" class="thumb">
        <h1>11</h1>
        <p>Description 1</p>
    </article>
    <article class="white-panel">
        <img src="img/2.jpg" class="thumb">
        <h1><a href="#">Title 2</a></h1>
        <p>Description 2</p>
    </article>
    <article class="white-panel">
        <img src="img/3.jpg" class="thumb">
        <h1><a href="#">Title 3</a></h1>
        <p>Description 3</p>
    </article>
    <article class="white-panel">
        <img src="img/4.jpg" class="thumb">
        <h1><a href="#">Title 4</a></h1>
        <p>Description 4</p>
    </article>
    <article class="white-panel">
        <img src="img/5.jpg" class="thumb">
        <h1><a href="#">Title 5</a></h1>
        <p>Description 5</p>
    </article>
    <article class="white-panel">
        <img src="img/6.jpg" class="thumb">
        <h1><a href="#">Title 6</a></h1>
        <p>Description 6</p>
    </article>
    <article class="white-panel">
        <img src="img/7.jpg" class="thumb">
        <h1><a href="#">Title 7</a></h1>
        <p>Description 7</p>
    </article>
    <article class="white-panel">
        <img src="img/8.jpg" class="thumb">
        <h1><a href="#">Title 8</a></h1>
        <p>Description 8</p>
    </article>
    <article class="white-panel">
        <img src="img/9.jpg" class="thumb">
        <h1><a href="#">Title 9</a></h1>
        <p>Description 9</p>
    </article>
    <article class="white-panel">
        <img src="img/10.jpg" class="thumb">
        <h1><a href="#">Title 10</a></h1>
        <p>Description 10</p>
    </article>
    <article class="white-panel">
        <img src="img/11.jpg" class="thumb">
        <h1><a href="#">Title 11</a></h1>
        <p>Description 11</p>
    </article>
    <article class="white-panel">
        <img src="img/12.jpg" class="thumb">
        <h1><a href="#">Title 12</a></h1>
        <p>Description 12</p>
    </article>
    <article class="white-panel">
        <img src="img/13.jpg" class="thumb">
        <h1><a href="#">Title 13</a></h1>
        <p>Description 13</p>
    </article>
    <article class="white-panel">
        <img src="img/14.jpg" class="thumb">
        <h1><a href="#">Title 14</a></h1>
        <p>Description 14</p>
    </article>
    <article class="white-panel">
        <img src="img/15.jpg" class="thumb">
        <h1><a href="#">Title 15</a></h1>
        <p>Description 15</p>
    </article>
</section>


<script src="http://libs.baidu.com/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')</script>
<script src="http://localhost:81/h5/jQuery_Pinterest/js/pinterest_grid.js"></script>
<script type="text/javascript">
    $(function(){
        $("#gallery-wrapper").pinterest_grid({
            no_columns: 4,
            padding_x: 10,
            padding_y: 10,
            margin_bottom: 50,
            single_column_breakpoint: 700
        });

    });
</script>
</body>
</html>