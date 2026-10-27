@extends('layouts.app')
@section('title','Конкурсы — ЧМУ')
@section('content')
<section class="competition-hero"><div><p class="eyebrow">Сцена • мастерство • признание</p><h1>Конкурсы</h1><p>Условия участия, сроки, документы, результаты и архив конкурсов училища.</p></div><div class="competition-trophy">✦</div></section>
<nav class="applicant-nav"><a href="#current">Актуальные</a><a href="#archive">Архив</a><a href="/laureates">Результаты</a></nav>
<section id="current" class="block"><p class="eyebrow">Конкурсы</p><h2>Актуальные и прошедшие</h2><div class="competition-grid">@forelse($competitions as $c)<a href="{{route('competitions.show',$c->slug)}}"><div class="competition-mark">{{$c->symbol?:'✦'}}</div><small>{{$c->status}} {{$c->year?'• '.$c->year:''}}</small><h3>{{$c->title}}</h3><p>{{$c->subtitle}}</p><b>О конкурсе →</b></a>@empty<p>Конкурсы пока не опубликованы.</p>@endforelse</div></section>
<section id="archive" class="block"><p class="eyebrow">История</p><h2>Архив конкурсов</h2><div class="year-archive">@forelse($years as $year)<a href="#current"><b>{{$year}}</b><span>{{$competitions->where('year',$year)->count()}} материалов</span><i>→</i></a>@empty<p>Архив пока пуст.</p>@endforelse</div></section>
<section class="block result-zone"><div><p class="eyebrow">Итоги</p><h2>Результаты и дипломы</h2></div><div class="result-links"><a href="/laureates"><b>Лауреаты и дипломанты</b><span>→</span></a><a href="/achievements"><b>Все достижения</b><span>→</span></a></div></section>
@endsection