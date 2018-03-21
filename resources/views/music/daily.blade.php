
@extends('layouts.app')


<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">

@section('content')
    <div class="container">
        <div class="col-md-8">
            <form method="post" action="daily">
                <div class="row">
                    {!! csrf_field() !!}
                    <div class='col-md-3'>
                        <div class="form-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input type='text' class="form-control" name="timebegin" placeholder="起始日期"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class="form-group">
                            <div class='input-group date' id='datetimepicker2'>
                                <input type='text' class="form-control" name="timeend" id="timeend" placeholder="结束日期"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-default" value="搜索">
                    </div>
                </div>
            </form>
            <div class="form-group">
                <div class="form-group">
                    @foreach($daily as $d_value)
                        <li style="list-style: none">{{$d_value['releasetime']}}</li>
                        <P style="list-style: none"><?php echo $d = str_replace('<BR/>','<br>',$d_value['content'])?></P>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-M-DD'
            });
        });
        $(function () {
            $('#datetimepicker2').datetimepicker({
                format: 'YYYY-M-DD'
            });
        });

    </script>

@endsection
