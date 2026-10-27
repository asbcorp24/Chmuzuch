@extends('layouts.app')
@section('title','Сектор практики — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="legacy-hero"><p class="eyebrow">Студентам</p><h1>{{$block['title']}}</h1><p>{{$block['text']??'Практическая подготовка студентов училища.'}}</p></section>
@elseif($id==='directions')<section class="legacy-section"><h2>{{$block['title']}}</h2><div class="prose">{!!nl2br(e($block['text']??'Информация о практической подготовке редактируется в конструкторе страницы.'))!!}</div><div class="federal-grid">@foreach(['schedules'=>'Графики','programs'=>'Программы практики','bases'=>'Базы практики'] as $key=>$title)<article><span>◆</span><h3>{{$title}}</h3><div class="document-list">@forelse($documentGroups[$key]??[] as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener">{{$doc->title}}</a>@empty<small>Материалы не опубликованы</small>@endforelse</div></article>@endforeach</div></section>
@elseif($id==='documents')<section class="block"><h2>{{$block['title']}}</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener"><b>{{$doc->title}}</b><em>Открыть →</em></a>@empty<p>Документы пока не опубликованы.</p>@endforelse</div></section>
@elseif($id==='career')<section class="legacy-section"><div class="prose">{!!nl2br(e($block['text']??''))!!}</div><a class="legacy-action" href="{{route('career')}}">Практика и карьера →</a></section>@endif
@endforeach
@endsection