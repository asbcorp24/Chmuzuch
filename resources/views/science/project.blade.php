@extends('layouts.app')
@section('title',$project['title'].' — ЧМУ')
@section('content')
<section class="project-hero"><div><a href="/science" class="backlink">← Наука и проекты</a><p class="eyebrow">{{$project['type']}}</p><h1>{{$project['title']}}</h1><p>{{$project['lead']}}</p></div><div class="project-mark">∑</div></section>
<section class="block split"><div><p class="eyebrow">О проекте</p><h2>Идея и задачи</h2></div><div><p>Описание, цели, актуальность, этапы реализации и ожидаемые результаты проекта.</p></div></section>
<section class="block"><p class="eyebrow">Команда</p><h2>Участники и руководители</h2><div class="member-cloud"><span>Руководитель</span><span>Преподаватели</span><span>Студенты</span><span>Партнёры</span></div></section>
<section class="block dual"><article><p class="eyebrow">Результаты</p><h2>Материалы проекта</h2><p>Публикации, исследования, документы и презентации.</p></article><article><p class="eyebrow">Медиа</p><h2>Фото и видео</h2><p>Хроника реализации проекта.</p></article></section>
@endsection