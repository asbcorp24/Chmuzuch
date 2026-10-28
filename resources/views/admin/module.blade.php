@extends('layouts.admin')
@section('title',$meta['title'].' — CMS ЧМУ')
@section('content')
<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Раздел CMS</small><h1>{{$meta['title']}}</h1></div><a class="admin-primary" href="/admin/{{$module}}/edit/new">+ Добавить</a></header>
@if(session('success'))<div class="admin-flash">{{session('success')}}</div>@endif
<section class="admin-toolbar"><input placeholder="Поиск…"><select><option>Все</option><option>Опубликовано</option><option>Черновики</option></select><button>Фильтры</button></section>
<section class="admin-list"><div class="admin-list-head"><span>Название</span><span>Статус</span><span>Изменено</span><span></span></div>
@forelse($items as $item)<div class="admin-row">@if(auth()->user()?->role!=='editor' || $item->status==='draft')<a href="/admin/{{$module}}/edit/{{$item->id}}"><span><b>{{$item->title}}</b><small>/{{$item->slug}}</small></span><span class="{{$item->status==='published'?'status-live':''}}">{{$item->status}}</span><span>{{$item->updated_at?->format('d.m.Y H:i')}}</span><b>Редактировать</b></a>@else <div><b>{{$item->title}}</b><small>Опубликованный материал — только просмотр</small></div>@endif @if($module==='concerts')<a href="{{route('admin.concert-performances.index',$item)}}" class="admin-primary">Программа и медиа</a>@endif @if(auth()->user()?->role!=='editor')<form method="POST" action="{{route('admin.destroy',[$module,$item->id])}}" onsubmit="return confirm('Удалить запись?')">@csrf @method('DELETE')<button>×</button></form>@endif</div>@empty<div class="admin-empty"><b>Записей пока нет</b><p>Создайте первый материал — он будет сохранён в базе данных.</p></div>@endforelse
</section>
@if(method_exists($items,'links')) {{$items->links()}} @endif
@endsection