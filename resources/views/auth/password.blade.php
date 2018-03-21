<!-- resources/views/auth/password.blade.php -->
@extends('layouts.app')
@section('content')
<form method="POST" action="/password/email">
    {!! csrf_field() !!}

    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <div class="col-md-2">
    <div>
        Email
        <input class="form-control" type="email" name="email" value="{{ old('email') }}">
    </div>
        <p></p>
    <div>
        <button class="btn btn-default" type="submit">
            发送重置密码邮件
        </button>
    </div>
    </div>
</form>
@endsection