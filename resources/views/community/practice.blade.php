@extends('layouts.app')
@section('title','Сектор практики — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="legacy-hero"><p class="eyebrow">Студентам</p><h1>Сектор <i>практики</i></h1><p>Практическая подготовка студентов училища.</p></section>
@elseif($id==='directions')<section class="legacy-section"><h2>{{$block['title']}}</h2><div class="federal-grid"><article><span>01</span><h3>Графики</h3></article><article><span>02</span><h3>Программы практики</h3></article><article><span>03</span><h3>Базы практики</h3></article></div></section>
@elseif($id==='documents')<section class="block"><h2>{{$block['title']}}</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}"><b>{{$doc->title}}</b><em>Открыть →</em></a>@empty<p>Документы пока не опубликованы.</p>@endforelse</div></section>
@elseif($id==='career')<section class="legacy-section"><a class="legacy-action" href="/career">Расширенный раздел «Практика и карьера» →</a></section>@endif
@endforeach
@endsection