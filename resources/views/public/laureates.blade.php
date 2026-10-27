@extends('layouts.app')
@section('title','Лауреаты и дипломанты — ЧМУ')
@section('content')
<section class="honor-hero laureate-hero"><p class="eyebrow">Достижения</p><h1>Лауреаты <i>и дипломанты</i></h1><p>Конкурсные достижения студентов и творческих коллективов училища.</p></section>
<nav class="edu-nav"><a href="/pride">Наша гордость</a><a href="/laureates">Лауреаты и дипломанты</a><a href="/gratitudes">Нас благодарят</a><a href="/achievements">Все достижения</a></nav>
<section class="honor-list"><div class="honor-list-head"><div><p class="eyebrow">Архив</p><h2>Конкурсные результаты</h2></div></div><div class="achievement-grid">@forelse($items as $item)<article>@if($item->image)<img src="{{asset('storage/'.$item->image)}}" alt="{{$item->person_name?:$item->title}}">@else<div class="avatar-placeholder">✦</div>@endif<small>{{$item->competition}}{{$item->year?' • '.$item->year:''}}</small><h3>{{$item->person_name?:$item->title}}</h3><p>{{$item->result}}</p>@if($item->department)<span>{{$item->department->title}}</span>@endif</article>@empty<div class="honor-empty"><span>✦</span><h3>Результаты пока не опубликованы</h3></div>@endforelse</div>{{$items->links()}}</section>
@endsection