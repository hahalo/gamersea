@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="tools-alert tools-alert-green">
            {{ session('status') }}
        </div>
    @endif
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
            <form action="addVideo/add" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="form-group ">
                    <label >视频名字</label>
                    <div class="form-group">
                        <input type='text' class="form-control"   name="videoname" />
                    </div>
                </div>
                <div class="form-group ">
                    <label >添加视频链接</label>
                    <div class="form-group">
                        <input type='text' class="form-control"   name="videourl" />
                    </div>
                </div>
                <button type="submit" class="btn btn-default">提交</button>
            </form>
    </div>
    @endif
@endsection