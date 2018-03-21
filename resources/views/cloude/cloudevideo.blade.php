@extends('layouts.app')
@section('content')
    @foreach($videos as $video)
        <div class=" col-md-3">
                <div class="thumbnail">
                    <div class="caption">
                        <p>{{$video['videoname']}}</p>
                    </div>
                    <div align="center" class="embed-responsive embed-responsive-16by9">
                        <video class="thumbnail" src="videos/{{$video['videourl']}}" controls="controls" ></video>
                    </div>
                </div>
        </div>
    @endforeach
        <div class="col-md-12">  {!! $videos->render() !!}</div>

@endsection
