@extends('layouts.admin')
@section('title','Образовательные программы — CMS ЧМУ')
@section('content')
<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Образование</small><h1>Образовательные программы</h1></div><a class="admin-primary" href="{{route('admin.education.edit','new')}}">+ Добавить</a></header>
@if(session('success'))<div class="admin-flash">{{session('success')}}</div>@endif
<section class="admin-list"><div class="admin-list-head"><span>Программа</span><span>Код</span><span>Статус</span><span></span></div>@forelse($items as $item)<div class="admin-row"><a href="{{route('admin.education.edit',$item->id)}}"><span><b>{{$item->title}}</b><small>{{$item->qualification}}</small></span><span>{{$item->code}}</span><span class="{{$item->is_active?'status-live':''}}">{{$item->is_active?'Активна':'Скрыта'}}</span><b>Редактировать</b></a><form method="POST" action="{{route('admin.education.destroy',$item)}}">@csrf @method('DELETE')<button onclick="return confirm('Удалить программу?')">×</button></form></div>@empty<div class="admin-empty"><b>Программ пока нет</b></div>@endforelse</section>{{$items->links()}}
@endsection