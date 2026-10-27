@extends('layouts.app')
@section('title','Достижения — ЧМУ')
@section('content')
<section class="public-hero achievement-hero"><div><p class="eyebrow">Гордость училища</p><h1>Достижения</h1><p>Единый архив достижений студентов, преподавателей и творческих коллективов.</p></div><div class="public-glyph">✦</div></section>
<nav class="edu-nav"><a href="/pride">Наша гордость</a><a href="/laureates">Лауреаты и дипломанты</a><a href="/gratitudes">Нас благодарят</a><a href="/achievements">Все достижения</a></nav>
<section class="block"><div class="achievement-grid">
@forelse($items as $item)
<article><div class="avatar-placeholder">✦</div><small>{{$item->competition}} {{$item->year}}</small><h3>{{$item->person_name ?: $item->title}}</h3><p>{{$item->result ?: $item->description}}</p>@if($item->department)<span>{{$item->department->title}}</span>@elseif($item->collective)<span>{{$item->collective->title}}</span>@elseif($item->teacher)<span>{{$item->teacher->name}}</span>@endif</article>
@empty<div class="empty-state">Достижения пока не опубликованы.</div>@endforelse
</div>{{$items->links()}}</section>
@endsection