@extends('layouts.app')
@section('title','Медиатека — ЧМУ')
@section('content')
<nav class="media-original-nav"><a href="/media">Все медиа</a><a href="/video-gallery">Видеогалерея</a><a href="/audio">Аудиозаписи</a></nav>
<section class="public-hero media-hero"><div><p class="eyebrow">Смотреть • слушать • помнить</p><h1>Медиатека</h1><p>Фотографии, видеозаписи, музыка, публикации и цифровой архив училища.</p></div><div class="media-orbit"><span>▶</span><span>♫</span><span>▧</span></div></section>
<section class="block media-hub"><a><span>01</span><h2>Фотогалерея</h2><p>Концерты, конкурсы, учебная и студенческая жизнь.</p></a><a><span>02</span><h2>Видеогалерея</h2><p>Выступления, события, интервью и архивные записи.</p></a><a><span>03</span><h2>Аудиозаписи</h2><p>Исполнители, ансамбли, оркестры и творческие проекты.</p></a><a href="/press#media"><span>04</span><h2>СМИ о нас</h2><p>Публикации и сюжеты об училище.</p></a></section>
<section class="block"><p class="eyebrow">Избранное</p><h2>Видео</h2><div class="video-wall">@for($i=0;$i<3;$i++)<div><b>▶</b><span>Видеозапись события</span></div>@endfor</div></section>
<section class="block audio-zone"><div><p class="eyebrow">Слушать</p><h2>Аудио</h2></div><div class="audio-list">@for($i=1;$i<=4;$i++)<div><button>▶</button><span>0{{$i}}</span><b>Музыкальная запись</b><time>—:—</time></div>@endfor</div></section>
<section class="block"><p class="eyebrow">По годам</p><h2>Архив</h2><div class="year-archive">@foreach(['2026','2025','2024','2023','2022','Ранее'] as $year)<a><b>{{$year}}</b><span>Фото • видео • аудио • публикации</span><i>→</i></a>@endforeach</div></section>
@endsection