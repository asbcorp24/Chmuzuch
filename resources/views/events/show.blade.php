@extends('layouts.app')
@section('title',$event->title.' — Афиша ЧМУ')
@section('content')
<section class="event-detail-hero"><div><a href="{{route('events.index')}}" class="backlink">← Афиша</a><p class="eyebrow">Мероприятие</p><h1>{{$event->title}}</h1>@if($event->excerpt)<p>{{$event->excerpt}}</p>@endif</div><div class="event-ticket"><small>ДАТА</small><b>{{$event->starts_at?->format('d.m.Y')??'Уточняется'}}</b><small>ВРЕМЯ</small><b>{{$event->starts_at?->format('H:i')??'Уточняется'}}</b><small>МЕСТО</small><b>{{$event->place?:'Уточняется'}}</b></div></section>
@if($event->cover)<section class="block"><img loading="lazy" style="max-width:100%;height:auto;border-radius:12px" src="{{asset('storage/'.$event->cover)}}" alt="{{$event->title}}"></section>@endif
<section class="block split"><div><p class="eyebrow">О событии</p><h2>Программа</h2></div><div class="rich-content">@if($event->content){!!$event->content!!}@elseif($event->excerpt)<p>{{$event->excerpt}}</p>@else<p>Программа и информация об исполнителях будут опубликованы дополнительно.</p>@endif</div></section>
@include('public.partials.post-media',['post'=>$event])
@include('public.partials.embedded-form')
@endsection
