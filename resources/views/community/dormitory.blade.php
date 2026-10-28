@extends('layouts.app')
@section('title','Общежитие — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="legacy-hero"><p class="eyebrow">Студентам</p><h1>{{$block['title']}}</h1><p>{{$block['text']??'Проживание, документы, студенческий совет и жизнь общежития.'}}</p></section>
@elseif($id==='info')<section class="legacy-section"><h2>{{$block['title']}}</h2><div class="prose">{!!nl2br(e($block['text']??'Информация об условиях проживания, заселении и режиме работы редактируется администрацией сайта.'))!!}</div><div class="document-list">@foreach($documentGroups['settlement']??[] as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener"><b>{{$doc->title}}</b><em>Открыть →</em></a>@endforeach</div></section>
@elseif($id==='council')<section class="legacy-section"><h2>{{$block['title']}}</h2><div class="prose">{!!nl2br(e($block['text']??''))!!}</div><a class="legacy-action" href="{{route('student-life.dorm-council')}}">Студенческий совет общежития →</a></section>
@elseif($id==='documents')<section class="block"><h2>{{$block['title']}}</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener"><b>{{$doc->title}}</b><em>Открыть →</em></a>@empty<p>Документы пока не опубликованы.</p>@endforelse @foreach($documentGroups['rules']??[] as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener"><b>{{$doc->title}}</b><em>Открыть →</em></a>@endforeach</div></section>
@elseif($id==='victories')<section class="legacy-section"><h2>{{$block['title']}}</h2><div class="prose">{!!nl2br(e($block['text']??''))!!}</div><a class="legacy-action" href="{{route('dormitory.victories')}}">Открыть раздел →</a></section>@endif
@endforeach
@endsection