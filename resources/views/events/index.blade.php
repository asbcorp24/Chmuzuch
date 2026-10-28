@extends('layouts.app')
@section('title','Афиша — ЧМУ')
@section('content')
<section class="events-hero"><div><p class="eyebrow">Концертная жизнь училища</p><h1>Афиша <em>событий</em></h1><p>Концерты, фестивали, мастер-классы и творческие встречи.</p></div></section>
<section class="block"><div class="section-head"><div><p class="eyebrow">Музыка на сцене</p><h2>События училища</h2></div></div>
<div class="event-list">
@forelse($events as $slug=>$event)
<a href="{{route('events.show',$slug)}}"><div class="event-date"><b>{{ $event['date'] ?? 'Дата' }}</b><span>{{ $event['time'] ?? 'Уточняется' }}</span></div><div><small>{{ $event['kind'] ?? 'Концерт' }} @if(!empty($event['status'])) · {{ $event['status'] }} @endif</small><h3>{{ $event['title'] ?? 'Событие' }}</h3>@if(!empty($event['place']))<p>{{ $event['place'] }}</p>@endif</div><span class="arrow">↗</span></a>
@empty<div class="empty-state">Сейчас нет опубликованных событий. Следите за обновлениями афиши.</div>
@endforelse
</div></section>
@endsection
