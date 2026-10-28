@extends('layouts.admin')
@php($titles=['departments'=>'Отделения','teachers'=>'Преподаватели','collectives'=>'Творческие коллективы'])
@section('title',$titles[$entity].' — CMS ЧМУ')
@section('content')
<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Динамический справочник</small><h1>{{$titles[$entity]}}</h1></div><a class="admin-primary" href="{{route('admin.people.edit',[$entity,'new'])}}">+ Добавить</a></header>
@if(session('success'))<div class="admin-flash">{{session('success')}}</div>@endif
<section class="admin-list"><div class="admin-list-head"><span>Название</span><span>Статус</span><span>Изменено</span><span></span></div>
@forelse($items as $item)<div class="admin-row"><a href="{{route('admin.people.edit',[$entity,$item->id])}}"><span><b>{{$entity==='teachers'?$item->name:$item->title}}</b><small>/{{$item->slug}}</small></span><span class="{{$item->is_active?'status-live':''}}">{{$item->is_active?'Активно':'Скрыто'}}</span><span>{{$item->updated_at?->format('d.m.Y H:i')}}</span><b>Редактировать</b></a><form method="POST" action="{{route('admin.people.destroy',[$entity,$item->id])}}">@csrf @method('DELETE')<button onclick="return confirm('Удалить?')">×</button></form></div>@empty<div class="admin-empty"><b>Записей пока нет</b><p>Добавьте первую запись.</p></div>@endforelse</section>{{$items->links()}}
@endsection