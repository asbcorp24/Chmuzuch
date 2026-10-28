@extends('layouts.admin')
@section('title',$meta['title'].' — CMS ЧМУ')
@section('content')
<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Раздел CMS</small><h1>{{$meta['title']}}</h1></div><a class="admin-primary" href="{{route('admin.editor',[$module,'new'])}}">+ Добавить</a></header>
@if(session('success'))<div class="admin-flash">{{session('success')}}</div>@endif
<div class="cms-records-summary">Материалов: <strong>{{$items->total()}}</strong></div>
<div class="cms-records-table-wrap"><table class="cms-records-table"><thead><tr><th>Материал</th><th>Статус</th><th>Изменён</th><th>Действия</th></tr></thead><tbody>
@forelse($items as $item)
@php($canEdit=auth()->user()?->role!=='editor'||$item->status==='draft')
<tr>
<td data-label="Материал"><div class="cms-record-title">{{$item->title}}</div><div class="cms-record-slug">/{{$item->slug}}</div></td>
<td data-label="Статус"><span class="cms-status {{ $item->status==='published'?'is-published':($item->status==='draft'?'is-draft':'is-scheduled') }}">{{['published'=>'Опубликовано','draft'=>'Черновик','scheduled'=>'Запланировано'][$item->status]??$item->status}}</span></td>
<td data-label="Изменён"><time datetime="{{$item->updated_at?->toIso8601String()}}">{{$item->updated_at?->format('d.m.Y H:i')}}</time></td>
<td data-label="Действия"><div class="cms-record-actions">
@if($canEdit)<a class="cms-action-edit" href="{{route('admin.editor',[$module,$item->id])}}">Редактировать</a>@else<span class="cms-record-readonly">Только просмотр</span>@endif
@if($module==='concerts')<a class="cms-action-edit" href="{{route('admin.concert-performances.index',$item)}}">Программа и медиа</a>@endif
@if(auth()->user()?->role!=='editor')<form method="POST" action="{{route('admin.destroy',[$module,$item->id])}}" onsubmit="return confirm('Удалить материал?')">@csrf @method('DELETE')<button type="submit" class="cms-action-delete" aria-label="Удалить {{$item->title}}">Удалить</button></form>@endif
</div></td>
</tr>
@empty<tr><td colspan="4" class="cms-record-empty">Материалов пока нет. Нажмите «Добавить», чтобы создать первый.</td></tr>
@endforelse
</tbody></table></div>
@if(method_exists($items,'links'))<div class="cms-record-pagination">{{$items->links()}}</div>@endif
@endsection
