@extends('layouts.app')
@section('title',$concert->title.' — Концерты')
@section('content')
<section class="section-hero"><p class="eyebrow">Концерт</p><h1>{{$concert->title}}</h1><p>{{$concert->starts_at?->format('d.m.Y H:i')}} · {{$concert->place}}</p></section>
<section class="block"><div class="prose">{!! nl2br(e($concert->content)) !!}</div>@if($concert->external_url)<p><a href="{{$concert->external_url}}" rel="noopener noreferrer" target="_blank">Подробнее о концерте →</a></p>@endif</section>
<section class="block"><h2>Программа концерта</h2>
@forelse($concert->concertPerformances as $performance)
<article class="concert-card"><small>№ {{$performance->program_number}}</small><h3>{{$performance->title}}</h3>
@if($performance->composer)<p>Композитор: {{$performance->composer}}</p>@endif
@if($performance->performer)<p>Исполнитель: {{$performance->performer}}</p>@endif
@if($performance->instrument)<p>Инструмент: {{$performance->instrument}}</p>@endif
@if($performance->teacher)<p>Преподаватель: {{$performance->teacher->name}}</p>@endif
@if($performance->accompanist)<p>Концертмейстер: {{$performance->accompanist}}</p>@endif
@if($performance->description)<p>{{$performance->description}}</p>@endif
@if($performance->audio_url)<audio controls preload="none" src="{{$performance->audio_url}}"></audio>@endif
@if($performance->video_url)<video controls preload="metadata" style="width:100%;max-width:720px" src="{{$performance->video_url}}"></video>@endif
</article>
@empty<p>Программа концерта будет опубликована позже.</p>@endforelse
</section>
@endsection
