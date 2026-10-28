@extends('layouts.app')
@section('title','СМИ о нас — ЧМУ')
@section('content')
<section class="press-list-hero"><p class="eyebrow">Пресс-центр · Публикации</p><h1>СМИ о нас</h1><p>Публикации, сюжеты и материалы средств массовой информации об училище.</p></section>
<nav class="edu-nav"><a href="/press">Пресс-центр</a><a href="/press/events">События</a><a href="/press/announcements">Анонсы</a><a href="/press/media-about-us">СМИ о нас</a></nav>
<section class="press-list-wrap"><div class="press-list-head"><div><p class="eyebrow">Архив</p><h2>СМИ о нас</h2></div><div><button class="active">Все годы</button><button>Архив</button></div></div><div class="press-list-empty"><span>—</span><h3>Материалы будут перенесены после проверки оригинала</h3><p>Здесь не публикуются фиктивные заголовки, даты или ссылки.</p></div></section>
@endsection