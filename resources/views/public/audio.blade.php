@extends('layouts.app')
@section('title','Аудиозаписи — ЧМУ')
@section('content')
<section class="media-sub-hero audio-hero"><p class="eyebrow">Медиа · Аудио</p><h1>Аудиозаписи</h1><p>Исполнительские записи студентов, преподавателей и творческих коллективов училища.</p></section>
<nav class="edu-nav"><a href="/media">Все медиа</a><a href="/video-gallery">Видеогалерея</a><a href="/audio">Аудиозаписи</a></nav>
<section class="audio-list">@foreach(range(1,6) as $i)<article><button aria-label="Воспроизвести">▶</button><div><small>Аудиозапись</small><h3>Запись из медиатеки</h3><p>Исполнитель и произведение будут указаны после переноса оригинальных данных.</p></div><time>—:—</time></article>@endforeach</section>
@endsection