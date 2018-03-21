<!-- resources/views/auth/reset.blade.php -->
@extends('layouts.app')
@section('content')
<form method="POST" action="/password/reset">
    {!! csrf_field() !!}
    <input type="hidden" name="token" value="{{ $token }}">

    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <div class="col-md-2">
        <div>
            电子邮箱
            <input class="form-control" type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            密码
            <input class="form-control" type="password" name="password">
        </div>

        <div>
            重新输入密码
            <input class="form-control" type="password" name="password_confirmation">
        </div>
        <p></p>
        <div>
            <button class="btn btn-default" type="submit">
                重置密码
            </button>
        </div>
    </div>
</form>
@endsection