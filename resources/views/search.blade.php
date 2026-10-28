@extends('layouts.app')
@section('title','Поиск — ЧМУ')
@section('content')
<section class="public-hero"><div><p class="eyebrow">По сайту</p><h1>Поиск</h1><form class="site-search" method="GET" action="/search"><input type="search" name="q" value="{{$q}}" placeholder="Что найти?" autofocus><button>Найти</button></form></div><div class="public-glyph">⌕</div></section>
@if($q!=='')<section class="block"><p class="eyebrow">Результаты</p><h2>«{{$q}}» — {{$results->count()}}</h2><div class="search-results">@forelse($results as $item)<a href="{{$item['url']}}"><small>{{$item['type']}}</small><h3>{{$item['title']}}</h3>@if($item['text'])<p>{{\Illuminate\Support\Str::limit(strip_tags($item['text']),180)}}</p>@endif<span>Открыть →</span></a>@empty<p>Ничего не найдено. Попробуйте изменить запрос.</p>@endforelse</div></section>@endif
@endsection