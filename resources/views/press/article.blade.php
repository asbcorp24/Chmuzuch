@extends('layouts.app')
@section('title',$article['title'].' — ЧМУ')
@section('content')
<article class="article-page"><header><a href="/press" class="backlink">← Пресс-центр</a><p class="eyebrow">{{$article['type']}} • {{$article['date']}}</p><h1>{{$article['title']}}</h1><p class="article-lead">{{$article['lead']}}</p></header><div class="article-cover">▧</div><div class="article-body"><p>Основной текст публикации будет редактироваться в системе управления сайтом. Здесь поддерживаются заголовки, текст, цитаты, изображения, галереи, видео, аудио, документы и ссылки.</p><blockquote>Цитата или важный фрагмент публикации.</blockquote><h2>Материалы</h2><p>Связанные фотографии, видеозаписи и документы публикации.</p></div></article>
@endsection