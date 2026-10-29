@extends('layouts.app')
@section('title',$article->title.' — ЧМУ')
@section('content')
<article class="article-page editorial-article"><header><a href="{{route('press.index')}}" class="backlink">← Пресс-центр</a><p class="eyebrow">{{$type==='news'?'Новости':($type==='announcements'?'Анонсы':'СМИ о нас')}} @if($article->published_at) • {{$article->published_at->format('d.m.Y')}} @endif</p><h1>{{$article->title}}</h1>@if($article->excerpt)<p class="article-lead">{{$article->excerpt}}</p>@endif</header>@if($article->cover)<div class="article-cover"><img src="{{asset('storage/'.$article->cover)}}" alt="{{$article->title}}"></div>@endif<div class="article-body rich-content">@if($article->content){!!$article->content!!}@elseif($article->excerpt)<p>{{$article->excerpt}}</p>@else<p>Материал готовится к публикации.</p>@endif</div>@if($article->external_url)<p><a href="{{$article->external_url}}" target="_blank" rel="noopener">Открыть источник ↗</a></p>@endif</article>
@include('public.partials.post-media',['post'=>$article])
@include('public.partials.embedded-form')
@endsection