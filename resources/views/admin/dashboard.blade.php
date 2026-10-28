@extends('layouts.admin')
@section('title','Панель управления — ЧМУ')
@section('content')
<header class="admin-top"><div><small>Панель управления</small><h1>Добрый день</h1></div><div><a href="/" target="_blank" rel="noopener">Открыть сайт ↗</a></div></header>
<section class="admin-section"><div class="admin-section-head"><div><small>Управление</small><h2>Разделы сайта</h2></div></div><div class="admin-module-grid">@foreach($modules as $slug=>$item)<a href="/admin/{{$slug}}"><span>{{$item['icon']}}</span><div><h3>{{$item['title']}}</h3><p>{{$item['count']}}</p></div><b>→</b></a>@endforeach</div></section>

@endsection