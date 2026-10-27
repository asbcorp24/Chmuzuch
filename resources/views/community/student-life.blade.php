@extends('layouts.app')
@section('title','Студенческая жизнь — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="life-hero"><div><p class="eyebrow">Студенческая жизнь</p><h1>Музыка продолжается <i>за пределами аудитории</i></h1><p>Творчество, самоуправление, волонтёрство, спорт и развитие.</p></div><div class="life-pulse"><span>LIVE</span></div></section>
@elseif($id==='projects')<section class="life-projects">@foreach([['Филармония','/student-life/philharmonic','♫'],['Студенческое самоуправление','/student-life/council','◎'],['Волонтёрское движение','/student-life/volunteering','♡'],['Спортивный клуб','/student-life/sport-club','↗'],['Школа личностного роста','/student-life/personal-growth','◇']] as $item)<article><span>{{$item[2]}}</span><h3>{{$item[0]}}</h3><a href="{{$item[1]}}">Подробнее →</a></article>@endforeach</section>
@elseif($id==='events')<section class="life-dark"><div><p class="eyebrow">Афиша</p><h2>Ближайшие события</h2></div><div class="life-events">@forelse($events as $event)<article><time>{{$event->starts_at?->format('d.m')}}</time><div><small>{{$event->place}}</small><h3>{{$event->title}}</h3></div><a href="{{route('events.show',$event->slug)}}">→</a></article>@empty<p>События пока не опубликованы.</p>@endforelse</div></section>
@elseif($id==='support')<section class="life-support"><div><p class="eyebrow">Поддержка</p><h2>Когда нужна помощь</h2></div><div class="life-support-grid"><a href="/students"><b>Студенту</b></a><a href="/dormitory"><b>Общежитие</b></a><a href="/safety"><b>Безопасность</b></a></div></section>
@endif @endforeach
@endsection