@extends('layouts.app')
@section('title','Афиша — ЧМУ')
@section('content')
<section class="events-hero"><div><p class="eyebrow">Афиша ЧМУ</p><h1>Музыка<br>происходит<br><em>здесь</em></h1></div><div><p>Концерты, спектакли, мастер-классы, конкурсы, конференции и другие события училища.</p></div></section>
<nav class="applicant-nav"><a href="#today">Сегодня</a><a href="#upcoming">Предстоящие</a><a href="#archive">Архив</a></nav>
<section id="today" class="block today-event"><p class="eyebrow">Сегодня</p><h2>События дня</h2><p>Если на текущую дату запланированы мероприятия, они отображаются здесь автоматически.</p></section>
<section id="upcoming" class="block"><p class="eyebrow">Календарь</p><h2>Предстоящие мероприятия</h2><div class="event-list">@foreach($events as $slug=>$event)<a href="{{route('events.show',$slug)}}"><div class="event-date"><b>{{$event['date']}}</b><span>{{$event['time']}}</span></div><div><small>{{$event['kind']}} • {{$event['status']}}</small><h3>{{$event['title']}}</h3><p>{{$event['place']}}</p></div><span class="arrow">→</span></a>@endforeach</div></section>
<section id="archive" class="block"><p class="eyebrow">Прошедшие события</p><h2>Архив афиши</h2><div class="year-archive">@foreach(['2026','2025','2024','2023','2022'] as $year)<a><b>{{$year}}</b><span>Концерты • конкурсы • мастер-классы • конференции</span><i>→</i></a>@endforeach</div></section>
@endsection