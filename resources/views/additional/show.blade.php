@extends('layouts.app')
@section('title',$course->title.' — ЦДО ЧМУ')
@section('content')
<section class="course-hero"><div><a class="backlink" href="/additional-education">← Все программы</a><p class="eyebrow">{{$course->kind}}</p><h1>{{$course->title}}</h1></div><div class="course-meta"><div><small>Объём</small><b>{{$course->hours}}</b></div><div><small>Формат</small><b>{{$course->format}}</b></div><div><small>Для кого</small><b>{{$course->audience}}</b></div></div></section>
<section class="block split"><div><p class="eyebrow">О программе</p><h2>Практика, методика, профессиональный рост</h2></div><div><p>{{$course->description?:'Описание программы готовится к публикации.'}}</p></div></section>
<section class="block"><p class="eyebrow">Документы</p><h2>Материалы программы</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank"><b>{{$doc->title}}</b><small>{{$doc->document_date?->format('d.m.Y')}}</small><em>Открыть →</em></a>@empty<p>Документы программы пока не опубликованы.</p>@endforelse</div></section>
@if($enrollmentForm)<section class="block open-day"><div><p class="eyebrow">Участие</p><h2>Подать заявку</h2></div><a href="{{route('forms.show',$enrollmentForm->slug)}}">Записаться →</a></section>@endif
@endsection