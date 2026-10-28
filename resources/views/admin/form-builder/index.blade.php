@extends('layouts.admin')
@section('title','Конструктор форм — CMS ЧМУ')
@section('content')
<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Динамические формы</small><h1>Конструктор форм</h1></div><a class="admin-primary" href="/admin/form-builder/new">+ Создать форму</a></header>
<section class="form-catalog-stats"><article><b>Формы</b><span>Созданные формы сайта</span></article><article><b>Ответы</b><span>Все отправленные анкеты</span></article><article><b>Активные</b><span>Опубликованные формы</span></article></section>
<section class="admin-toolbar"><input placeholder="Поиск формы…"><select><option>Все формы</option><option>Опубликованные</option><option>Черновики</option></select></section>
<section class="form-catalog">
@foreach([['open-day','Регистрация на день открытых дверей','Абитуриенту'],['competition','Заявка на конкурс','Конкурсы'],['feedback','Обратная связь','Динамическая страница'],['survey','Опрос посетителей','Динамическая страница']] as $f)
<article><div><small>{{$f[2]}}</small><h2>{{$f[1]}}</h2><code>[form:{{$f[0]}}]</code></div><div class="form-catalog-meta"><span class="status-live">Опубликована</span><b>Ответы: —</b></div><div class="form-catalog-actions"><a href="/admin/form-builder/{{$f[0]}}">Редактор</a><a href="/admin/form-reports/{{$f[0]}}">Ответы / отчёт</a><button>•••</button></div></article>
@endforeach
</section>
@endsection