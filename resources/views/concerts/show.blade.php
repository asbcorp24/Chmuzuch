@extends('layouts.app')
@section('title',$concert->title.' — Концерты')
@section('content')
<section class="section-hero"><p class="eyebrow">Концерт</p><h1>{{$concert->title}}</h1><p>{{$concert->starts_at?->format('d.m.Y H:i')}} · {{$concert->place}}</p></section>
<section class="block"><div class="prose">{!! nl2br(e($concert->content)) !!}</div>@if($concert->external_url)<p><a href="{{$concert->external_url}}" rel="noopener noreferrer" target="_blank">Подробнее о концерте →</a></p>@endif</section>
@if($concert->concertMedia->isNotEmpty())
<section class="block"><h2>Записи и фотографии концерта</h2><div class="concert-grid">
@foreach($concert->concertMedia as $media)
<div class="concert-card"><h3>{{$media->title}}</h3>
@if($media->type==='audio')<audio controls preload="none" src="{{asset('storage/'.$media->path)}}"></audio>
@elseif($media->type==='video')<video controls preload="metadata" style="max-width:100%" src="{{asset('storage/'.$media->path)}}"></video>
@elseif($media->type==='image')<img loading="lazy" style="max-width:100%" alt="{{$media->alt?:$media->title}}" src="{{asset('storage/'.$media->path)}}">
@else<a href="{{asset('storage/'.$media->path)}}">Открыть файл</a>@endif
</div>@endforeach</div></section>@endif
<section class="block"><h2>Программа концерта</h2>
@forelse($concert->concertPerformances as $performance)
<article class="concert-card"><small>№ {{$performance->program_number}}</small><h3>{{$performance->title}}</h3>
@if($performance->composer)<p>Композитор: {{$performance->composer}}</p>@endif
@if($performance->performer)<p>Исполнитель: {{$performance->performer}}</p>@endif
@if($performance->instrument)<p>Инструмент: {{$performance->instrument}}</p>@endif
@if($performance->teacher)<p>Преподаватель: {{$performance->teacher->name}}</p>@endif
@if($performance->accompanist)<p>Концертмейстер: {{$performance->accompanist}}</p>@endif
@if($performance->description)<p>{{$performance->description}}</p>@endif
@foreach($performance->students as $student)<p>Студент: {{$student->name}}@if($student->pivot->role) — {{$student->pivot->role}}@endif</p>@endforeach
@foreach($performance->teachers as $teacher)<p>Преподаватель: {{$teacher->name}}@if($teacher->pivot->role) — {{$teacher->pivot->role}}@endif</p>@endforeach
@foreach($performance->media as $media)<div class="concert-media"><p>{{$media->title}}</p>@if($media->type==='audio')<audio controls preload="none" src="{{asset('storage/'.$media->path)}}"></audio>@elseif($media->type==='video')<video controls preload="metadata" style="max-width:100%;width:720px" src="{{asset('storage/'.$media->path)}}"></video>@elseif($media->type==='image')<img loading="lazy" alt="{{$media->alt?:$media->title}}" src="{{asset('storage/'.$media->path)}}">@else<a href="{{asset('storage/'.$media->path)}}" target="_blank" rel="noopener">Открыть файл</a>@endif</div>@endforeach
@if($performance->audio_url)<audio controls preload="none" src="{{$performance->audio_url}}"></audio>@endif
@if($performance->video_url)<video controls preload="metadata" style="width:100%;max-width:720px" src="{{$performance->video_url}}"></video>@endif
</article>
@empty<p>Программа концерта будет опубликована позже.</p>@endforelse
</section>
@endsection
