@extends('layouts.admin')
@section('content')
    <style type='text/css'>
        video#bgvid {

            position: fixed; right: 0; bottom: 0;

            min-width: 100%; min-height: 100%;

            width: auto; height: auto; z-index: -100;

            background: url("/pic/scene-fire.png") no-repeat;

            background-size: cover;

        }
    </style>
    <video autoplay loop poster="/pic/scene-fire.png" id="bgvid">
        <source src="/videos/scene-fire.mp4" type="video/mp4">
    </video>
@endsection
