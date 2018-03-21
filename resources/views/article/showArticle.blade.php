@extends('layouts.app')
@section('content')

        <!-- Bootstrap 模版... -->

<div class="container">
    <h2>{{$article['title']}}</h2>
    <p>
        {{$article['created_at']}}&nbsp;
        作者：
        <a href="/i/people/{{$article['userid']}}">
        @if(!empty($article['nick_name']))
            {{$article['nick_name']}}
            @else
            {{$article['name']}}
        @endif
        </a>
        &nbsp;
        浏览量：{{$click}}

    </p>
    <div >
        <?php echo $article['content'];?>
    </div>

</div>

<!-- 代办：目前任务 -->
@endsection