@extends('layouts.admin')
@section('title','Панель управления — ЧМУ')
@section('content')
<header class="admin-top"><div><small>Панель управления</small><h1>Добрый день</h1></div><div><span>Сайт опубликован</span><a href="/" target="_blank">Открыть сайт ↗</a></div></header>
<section class="admin-stats"><article><small>Контент</small><b>Все разделы</b><span>структура сайта</span></article><article><small>Сегодня</small><b>0</b><span>новых обращений</span></article><article><small>Публикация</small><b>Онлайн</b><span>состояние сайта</span></article></section>
<section class="admin-section"><div class="admin-section-head"><div><small>Управление</small><h2>Разделы сайта</h2></div></div><div class="admin-module-grid">@foreach($modules as $slug=>$item)<a href="/admin/{{$slug}}"><span>{{$item['icon']}}</span><div><h3>{{$item['title']}}</h3><p>{{$item['count']}}</p></div><b>→</b></a>@endforeach</div></section>
<section class="admin-section admin-activity"><div><small>Последние изменения</small><h2>Активность</h2></div><div><p>История изменений появится здесь после подключения постоянного хранилища CMS.</p></div></section>
@endsection