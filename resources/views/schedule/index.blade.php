@extends('layouts.app')
@section('title',($page?->seo_title?:'Расписание').' — ЧМУ')
@section('content')
<section class="schedule-hero"><p class="eyebrow">Учебный процесс</p><h1>{{$page?->title?:'Расписание'}}</h1><p>{{$page?->excerpt?:'Актуальное расписание занятий, консультаций, экзаменов и других учебных мероприятий.'}}</p></section>
@if($page?->content)<section class="block"><div class="rich-content">{!!$page->content!!}</div></section>@endif
<section class="block"><div class="section-head"><div><p class="eyebrow">Актуальные материалы</p><h2>Расписание и изменения</h2></div></div><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener"><b>{{$doc->title}}</b><small>{{$doc->document_date?->format('d.m.Y')}}</small><em>Открыть →</em></a>@empty<p>Актуальное расписание ещё не опубликовано учебной частью.</p>@endforelse</div></section>
@endsection