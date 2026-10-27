@extends('layouts.admin')
@section('title',$meta['title'].' — CMS ЧМУ')
@section('content')
<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Раздел CMS</small><h1>{{$meta['title']}}</h1></div><a class="admin-primary" href="/admin/{{$module}}/edit/new">+ Добавить</a></header>
<section class="admin-toolbar"><input placeholder="Поиск…"><select><option>Все</option><option>Опубликовано</option><option>Черновики</option></select><button>Фильтры</button></section>
<section class="admin-list"><div class="admin-list-head"><span>Название</span><span>Статус</span><span>Изменено</span><span></span></div>
@for($i=1;$i<=5;$i++)<a href="/admin/{{$module}}/edit/{{$i}}"><span><b>{{$meta['title']}} — материал {{$i}}</b><small>Контентная запись / блок</small></span><span class="status-live">Опубликовано</span><span>—</span><b>•••</b></a>@endfor
</section>
@endsection