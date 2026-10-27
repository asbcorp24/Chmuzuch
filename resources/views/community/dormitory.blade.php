@extends('layouts.app')
@section('title','Общежитие — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="legacy-hero"><p class="eyebrow">Студентам</p><h1>Общежитие</h1><p>Проживание, документы, студенческий совет и жизнь общежития.</p></section>
@elseif($id==='info')<section class="legacy-section"><h2>{{$block['title']}}</h2><p>Условия проживания, порядок заселения, контакты и режим работы публикуются администрацией училища.</p></section>
@elseif($id==='council')<section class="legacy-section"><h2>{{$block['title']}}</h2><a class="legacy-action" href="/student-life/dorm-council">Студенческий совет общежития →</a></section>
@elseif($id==='documents')<section class="block"><h2>{{$block['title']}}</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}"><b>{{$doc->title}}</b><em>Открыть →</em></a>@empty<p>Документы пока не опубликованы.</p>@endforelse</div></section>
@elseif($id==='victories')<section class="legacy-section"><h2>{{$block['title']}}</h2><a class="legacy-action" href="/dormitory/victories">Открыть раздел →</a></section>@endif
@endforeach
@endsection