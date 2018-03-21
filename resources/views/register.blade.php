@extends('layouts.app')
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="register">
        {!! csrf_field() !!}
        <div class="col-md-2">
            <div class="form-group">
                账号
                <input class="form-control" type="text" name="name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                邮箱
                <input class="form-control" type="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                密码
                <input class="form-control" type="password" name="password">
            </div>

            <div class="form-group">
                确认密码
                <input class="form-control" type="password" name="password_confirmation">
            </div>

            <div>
                <button type="submit" class="btn btn-default">注册</button>
            </div>
        </div>

    </form>
@endsection
