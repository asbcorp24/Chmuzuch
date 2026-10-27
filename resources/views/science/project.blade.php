@extends('layouts.app')
@section('title',$project->title.' — ЧМУ')
@section('content')
<section class="project-hero"><div><a href="/science" class="backlink">← Наука и проекты</a><p class="eyebrow">{{$project->status}}</p><h1>{{$project->title}}</h1><p>{{$project->lead}}</p></div><div class="project-mark">∑</div></section>
<section class="block split"><div><p class="eyebrow">О проекте</p><h2>{{$project->subtitle?:'Идея и задачи'}}</h2></div><div><p>{{$project->description?:'Описание проекта готовится к публикации.'}}</p></div></section>
<section class="block"><p class="eyebrow">Сроки и место</p><div class="competition-dates"><article><small>Начало</small><b>{{$project->starts_at?->format('d.m.Y')??'—'}}</b></article><article><small>Окончание</small><b>{{$project->ends_at?->format('d.m.Y')??'—'}}</b></article><article><small>Место</small><b>{{$project->place?:'—'}}</b></article></div></section>
<section class="block"><p class="eyebrow">Материалы</p><h2>Документы проекта</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank"><b>{{$doc->title}}</b><em>Открыть →</em></a>@empty<p>Материалы пока не опубликованы.</p>@endforelse</div></section>
@endsection