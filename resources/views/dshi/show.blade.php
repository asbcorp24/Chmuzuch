@extends('layouts.app')
@section('title',$program->title.' — ДШИ ЧМУ')
@section('content')
<section class="dshi-program-hero"><div><a href="/dshi" class="backlink">← Все программы ДШИ</a><p class="eyebrow">Образовательная программа</p><h1>{{$program->title}}</h1><p>{{$program->age}}</p></div><div class="program-symbol">{{$program->symbol}}</div></section>
<section class="block split"><div><p class="eyebrow">О программе</p><h2>Развиваем музыкальность и творческое мышление</h2></div><div><p>{{$program->description?:'Описание программы готовится к публикации.'}}</p></div></section>
<section class="block"><p class="eyebrow">Документы</p><h2>Материалы программы</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank"><b>{{$doc->title}}</b><small>{{$doc->document_date?->format('d.m.Y')}}</small><em>Открыть →</em></a>@empty<p>Документы программы пока не опубликованы.</p>@endforelse</div></section>
<section class="block dshi-admission"><div><p class="eyebrow">Поступление</p><h2>Записаться на программу</h2></div><a href="/dshi#admission">Условия поступления →</a></section>
@endsection