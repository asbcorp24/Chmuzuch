@extends('layouts.app')
@section('title','Студенту — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="student-hero"><div><p class="eyebrow">Студенческий портал</p><h1>{{$block['title']}}</h1><p>Расписание, учебные материалы, практика, поддержка и студенческая жизнь.</p></div></section>
@elseif($id==='schedule')<section class="block schedule-preview"><div><h2>{{$block['title']}}</h2><a href="/schedule">Открыть полное расписание →</a></div></section>
@elseif($id==='library')<section class="block library-feature"><div><h2>{{$block['title']}}</h2><p>Нотный фонд, учебная литература и электронные ресурсы.</p><a href="/library">Открыть библиотеку →</a></div></section>
@elseif($id==='practice')<section class="block"><h2>{{$block['title']}}</h2><a href="/practice">Сектор практики →</a></section>
@elseif($id==='life')<section class="block"><h2>{{$block['title']}}</h2><div class="life-grid"><a href="/student-life/philharmonic"><h3>Студенческая филармония</h3></a><a href="/student-life/sport-club"><h3>Спортивный клуб</h3></a><a href="/student-life/volunteering"><h3>Волонтёрское движение</h3></a><a href="/student-life/council"><h3>Студенческое самоуправление</h3></a><a href="/student-life/personal-growth"><h3>Школа личностного роста</h3></a></div></section>
@elseif($id==='documents')<section class="block"><h2>{{$block['title']}}</h2><div class="document-list">@forelse($documents as $d)<a href="{{asset('storage/'.$d->file_path)}}"><b>{{$d->title}}</b><em>Открыть →</em></a>@empty<p>Документы пока не опубликованы.</p>@endforelse</div></section>
@else<section class="block"><h2>{{$block['title']}}</h2></section>@endif
@endforeach
@endsection