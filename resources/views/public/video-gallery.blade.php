@extends('layouts.app')
@section('title','Видеогалерея — ЧМУ')
@section('content')
<section class="media-sub-hero"><p class="eyebrow">Медиа · Видео</p><h1>Видеогалерея</h1><p>Концерты, выступления, проекты и другие видеоматериалы училища.</p></section>
<nav class="edu-nav"><a href="/media">Все медиа</a><a href="/video-gallery">Видеогалерея</a><a href="/audio">Аудиозаписи</a></nav>
<section class="media-sub-grid">@foreach(range(1,6) as $i)<article><div class="media-placeholder"><span>▶</span></div><small>Видео</small><h3>Материал из медиатеки</h3><p>Название, дата и видеозапись будут перенесены после проверки исходных материалов.</p></article>@endforeach</section>
@endsection