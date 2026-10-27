@extends('layouts.app')
@section('title',$conference->title.' — ЧМУ')
@section('content')
<section class="conference-hero"><div><a href="/science#conferences" class="backlink">← Конференции</a><p class="eyebrow">{{$conference->status}} {{$conference->year?'• '.$conference->year:''}}</p><h1>{{$conference->title}}</h1><p>{{$conference->lead}}</p></div><div class="conference-year">{{$conference->year}}</div></section>
<nav class="department-nav"><a href="#about">О конференции</a><a href="#docs">Документы</a><a href="#results">Материалы</a></nav>
<section id="about" class="block split"><div><p class="eyebrow">Конференция</p><h2>{{$conference->subtitle?:'О событии'}}</h2></div><div><p>{{$conference->description?:'Описание конференции готовится к публикации.'}}</p></div></section>
<section class="block competition-dates"><article><small>Начало</small><b>{{$conference->starts_at?->format('d.m.Y H:i')??'Уточняется'}}</b></article><article><small>Окончание</small><b>{{$conference->ends_at?->format('d.m.Y H:i')??'Уточняется'}}</b></article><article><small>Место</small><b>{{$conference->place?:'Уточняется'}}</b></article></section>
<section id="docs" class="block"><p class="eyebrow">Документы</p><h2>Положение, программа и материалы</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank"><b>{{$doc->title}}</b><small>{{$doc->document_date?->format('d.m.Y')}}</small><em>Открыть →</em></a>@empty<p>Документы пока не опубликованы.</p>@endforelse</div></section>
@endsection