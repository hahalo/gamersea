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
    @else
        <div class="form-group">
            <div class="col-lg-8">
                <form method="get" action="/searcharticle">
                    <div class="input-group">
                        <input type="text" id="s" name="s" class="form-control" placeholder="搜啊搜啊 我骄傲放纵">
                        <span class="input-group-btn">
                             <input type="submit" value="搜索" id='search' class="btn btn-default" >
                           <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                               <span class="caret"></span>
                               <span class="sr-only">Toggle Dropdown</span>
                           </button>
                           <ul class="dropdown-menu dropdown-menu-right">
                               @foreach($navs as $navKey=>$nav)
                                   <li style="background-color: rgb(254,254,254);font-size: 15px;">
                                       <a href="/article/{{$nav['typename']}}">{{$nav['typename']}}</a>
                                   </li>
                                   @if($navKey<count($navs)-1)
                                       <li role="separator" class="divider"></li>
                                   @endif
                               @endforeach
                           </ul>
                         </span>
                    </div><!-- /input-group -->
                </form>
                <div class="container" style="margin-top: 10px">
                    <div class="row">
                        <div class="form-group">
                            @foreach($articles as $article)
                                <li>
                                        <span>
                                            <a href="/article/{{$article['id']}}">
                                                {{$article['title']}}
                                            </a>
                                            @if(Auth::check())
                                                @if(Session('userid')==$article['userid'])
                                                    <a class="glyphicon glyphicon-edit" aria-hidden="true" href="/article/editshow/{{$article['id']}}" title="编辑"></a>
                                                @endif
                                            @endif
                                        </span>
                                </li>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    @endif
    @endsection








