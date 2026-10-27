@extends('layouts.admin')
@php($labels=['official'=>'Сведения об образовательной организации','employees'=>'Работникам','safety'=>'Безопасность'])
@section('title',$labels[$portal].' — CMS')
@section('content')
<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Структура портала</small><h1>{{$labels[$portal]}}</h1></div><a class="admin-primary" href="{{route('admin.sections.edit',[$portal,'new'])}}">+ Раздел</a></header>
@if(session('success'))<div class="admin-flash">{{session('success')}}</div>@endif
<section class="admin-list">@forelse($items as $item)<div class="admin-row"><a href="{{route('admin.sections.edit',[$portal,$item->id])}}"><span><b>{{$item->title}}</b><small>{{$item->group}}</small></span><span>/{{$item->slug}}</span><span>{{$item->is_active?'Опубликован':'Скрыт'}}</span><b>Редактировать</b></a><form method="POST" action="{{route('admin.sections.destroy',[$portal,$item])}}">@csrf @method('DELETE')<button onclick="return confirm('Удалить раздел?')">×</button></form></div>@empty<div class="admin-empty"><b>Разделов пока нет</b><p>Добавьте структуру вручную или позже импортируйте её с прежнего сайта.</p></div>@endforelse</section>
@endsection