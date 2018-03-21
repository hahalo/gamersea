@extends('layouts.app')
@section('content')
    @if(Auth::viaRemember())
        <div>111</div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="/login">
        {!! csrf_field() !!}
        <div class="col-md-2">
            <div >
                邮箱
                <input class="form-control" type="email" name="email" value="{{ old('email') }}">
            </div>

            <div>
                密码
                <input class="form-control" type="password" name="password" id="password" value="{{ old('email') }}">
            </div>

            <div>
                <input  type="checkbox" name="remember"> 记住密码
            </div>


            <div>
                <button type="submit" class="btn btn-default">登录</button>
                <a href="/register">注册</a>
                <a  href="/password/email">忘记密码</a>
            </div>
        </div>

    </form>
@endsection
