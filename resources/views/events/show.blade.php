@extends('layouts.app')
@section('title',$event['title'].' — Афиша ЧМУ')
@section('content')
<section class="event-detail-hero"><div><a href="/events" class="backlink">← Афиша</a><p class="eyebrow">{{$event['kind'] ?? 'Концерт'}} @if(!empty($event['status'])) • {{$event['status']}} @endif</p><h1>{{$event['title']}}</h1><p>{{$event['lead'] ?? ''}}</p></div><div class="event-ticket"><small>ДАТА</small><b>{{$event['date'] ?? 'Уточняется'}}</b><small>ВРЕМЯ</small><b>{{$event['time'] ?? 'Уточняется'}}</b><small>МЕСТО</small><b>{{$event['place'] ?? 'Уточняется'}}</b></div></section>
<section class="event-poster"><div><small>МУЗЫКАЛЬНОЕ УЧИЛИЩЕ · АФИША</small><span>{{$event['title']}}</span></div></section>
<section class="block split"><div><p class="eyebrow">О событии</p><h2>Программа</h2></div><div><p>{{ $event['lead'] ?? 'Программа и информация об исполнителях будут опубликованы дополнительно.' }}</p></div></section>
@if(!empty($event['related']))<section class="block"><p class="eyebrow">Связано с событием</p><h2>Отделения и коллективы</h2><div class="member-cloud">@foreach(($event['related'] ?? []) as $x)<span>{{$x}}</span>@endforeach</div></section>@endif
<section class="block"><p class="eyebrow">После события</p><h2>Фото • Видео • Аудио</h2><div class="media-panels"><div>▧<span>Фотографии</span></div><div>▶<span>Видео</span></div><div>♫<span>Аудиозаписи</span></div></div></section>
@include('public.partials.embedded-form')
@endsection