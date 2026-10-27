@extends('layouts.app')
@section('title','Поиск — ЧМУ')
@section('content')
<section class="system-hero"><p class="eyebrow">Поиск по сайту</p><h1>Найти</h1><form action="/search"><input name="q" value="{{$q}}" autofocus placeholder="Что вы ищете?"><button>Поиск</button></form></section>
<section class="block search-results">@if($q==='')<p>Введите название раздела, документа, события или ключевое слово.</p>@elseif(empty($results))<p>По запросу «{{$q}}» ничего не найдено. После подключения CMS поиск будет индексировать весь контент сайта.</p>@else<p class="eyebrow">Результаты для «{{$q}}»</p>@foreach($results as $item)<a href="{{$item['url']}}"><h2>{{$item['title']}}</h2><p>{{$item['text']}}</p><span>→</span></a>@endforeach@endif</section>
@endsection