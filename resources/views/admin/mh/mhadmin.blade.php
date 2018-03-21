@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="tools-alert tools-alert-green">
            {{ session('status') }}
        </div>
    @endif
    <div class="container col-md-6">
        @if (count($errors) > 0)
            <div class="form-group ">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
            <form action="mhadmin/add" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="form-group ">
                    <label >物品代码</label>
                    <div class="form-group">
                        <input type='text' class="form-control"   name="ItemID" />
                    </div>
                </div>
                <div class="form-group ">
                    <label >物品名称</label>
                    <div class="form-group">
                        <input type='text' class="form-control"   name="ItemName" />
                    </div>
                </div>
                <div class="form-group ">
                    <label >物品代码</label>
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <span id="itemType">请选择类型</span>
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    @foreach($gmItemsGruops as $gmItemsGruop)
                                        @if(!empty($gmItemsGruop['ItemType']))
                                            {{--active--}}
                                            <li>
                                                <a>
                                                    {{$gmItemsGruop['ItemType']}}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach

                                </ul>
                            </div><!-- /btn-group -->
                            <input type="text" class="form-control" name="ItemType" id="goods" placeholder="类型或者自己填写">

                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                <button type="submit" class="btn btn-default">提交</button>
            </form>
    </div>

    <script>

        $(function() {
            $(".dropdown-menu li").click(function(){
                var itemType = $.trim($(this).text());
                $("#itemType").text(itemType);
                $("#goods").val(itemType);
            });
        });

    </script>
@endsection

