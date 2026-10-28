@extends('layouts.admin')
@php($labels=['project'=>'Проекты','conference'=>'Конференции','competition'=>'Конкурсы'])
@section('title',$labels[$type].' — CMS ЧМУ')
@section('content')
<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Наука и творчество</small><h1>{{$labels[$type]}}</h1></div><a class="admin-primary" href="{{route('admin.activities.edit',[$type,'new'])}}">+ Добавить</a></header>
@if(session('success'))<div class="admin-flash">{{session('success')}}</div>@endif
<section class="admin-list">@forelse($items as $item)<div class="admin-row"><a href="{{route('admin.activities.edit',[$type,$item->id])}}"><span><b>{{$item->title}}</b><small>{{$item->subtitle}}</small></span><span>{{$item->year}}</span><span>{{$item->status}}</span><b>{{$item->is_active?'Опубликован':'Скрыт'}}</b></a><form method="POST" action="{{route('admin.activities.destroy',[$type,$item])}}">@csrf @method('DELETE')<button onclick="return confirm('Удалить?')">×</button></form></div>@empty<div class="admin-empty"><b>Материалов пока нет</b></div>@endforelse</section>{{$items->links()}}
@endsection