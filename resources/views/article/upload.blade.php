<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div class="container">
    <div class="form-group">
        <form method="post" enctype="multipart/form-data" action="addArticle/add">
            {!! csrf_field() !!}
            <div class="form-group">
                <input type="file" name="photo" id="exampleInputFile">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default">
            </div>

        </form>
    </div>

</div>
</body>
</html>







