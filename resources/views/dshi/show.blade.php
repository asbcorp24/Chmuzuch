@extends('layouts.app')
@php($c=$program->content??[])
@section('title',$program->title.' — ДШИ ЧМУ')
@section('content')
<section class="dshi-program-hero"><div><a href="/dshi" class="backlink">← Все программы ДШИ</a><p class="eyebrow">Образовательная программа</p><h1>{{$program->title}}</h1><p>{{$program->age}}</p></div><div class="program-symbol">{{$program->symbol}}</div></section>
<section class="block split"><div><p class="eyebrow">О программе</p><h2>Содержание программы</h2></div><div><p>{{$program->description?:'Описание программы готовится к публикации.'}}</p></div></section>
@if(!empty($c['admission']))<section class="block"><p class="eyebrow">Поступление</p><h2>Условия поступления</h2><div class="rich-content">{!!nl2br(e($c['admission']))!!}</div></section>@endif
@if(!empty($c['curriculum']))<section class="block"><p class="eyebrow">Обучение</p><h2>Учебный план</h2><div class="rich-content">{!!nl2br(e($c['curriculum']))!!}</div></section>@endif
@if($teachers->isNotEmpty())<section class="block"><p class="eyebrow">Наставники</p><h2>Преподаватели программы</h2><div class="cards cards-3">@foreach($teachers as $teacher)<a class="card teacher-card" href="{{route('teachers.show',$teacher->slug)}}"><div class="avatar-placeholder">♪</div><small>{{$teacher->position}}</small><h3>{{$teacher->name}}</h3><p>{{$teacher->qualifications}}</p></a>@endforeach</div></section>@endif
@if(!empty($c['outcomes']))<section class="block"><p class="eyebrow">Результат</p><h2>Чему научится ученик</h2><div class="rich-content">{!!nl2br(e($c['outcomes']))!!}</div></section>@endif
@if($events->isNotEmpty())<section class="block"><div class="section-head"><div><p class="eyebrow">Афиша</p><h2>События программы</h2></div></div><div class="cards cards-3">@foreach($events as $event)<a class="card" href="{{route('events.show',$event->slug)}}"><small>{{$event->starts_at?->format('d.m.Y H:i')}}</small><h3>{{$event->title}}</h3><p>{{$event->place}}</p></a>@endforeach</div></section>@endif
<section class="block"><p class="eyebrow">Документы</p><h2>Материалы программы</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank"><b>{{$doc->title}}</b><small>{{$doc->document_date?->format('d.m.Y')}}</small><em>Открыть →</em></a>@empty<p>Документы программы пока не опубликованы.</p>@endforelse</div></section>
<section class="block dshi-admission"><div><p class="eyebrow">Поступление</p><h2>Записаться на программу</h2></div><a href="/dshi#admission">Условия поступления →</a></section>
@endsection