@extends('layouts.admin')

@section('content')
    <div class="container col-md-6">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @else
        <form action="addDaily/add" method="post">
            {!! csrf_field() !!}
            <div class="form-group ">
                <label >填写时间</label>

                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' class="form-control"   name="releasetime" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        </div>
                    </div>
            </div>
            <div class="form-group">
                <label >工作日志</label>
                <textarea class="form-control" rows="6" placeholder="请填写工作内容" name="contents" id="contents"></textarea>
            </div>
            <button type="submit" class="btn btn-default">提交</button>
        </form>
    </div>
    @endif
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-M-DD'
            });
        });
        /*function text() {
            //var contents = $("#contents").val();
           // contents=contents.replace(/\n/g,'<br>');
           // $("#contents").val(contents);
           // alert(contents.replace(/<br\s*\/?\s*>/ig, '\n'));
        }*/
    </script>

@endsection
