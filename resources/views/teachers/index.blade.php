@extends('layouts.app')
@section('title','Преподаватели — ЧМУ')
@section('content')
<section class="section-hero"><p class="eyebrow">Люди • ЧМУ</p><h1>Преподаватели</h1><p>Педагогическая школа училища — исполнители, наставники, исследователи и хранители музыкальной традиции.</p></section>
<section class="block"><div class="filter-strip"><a href="/teachers" class="{{!$department?'active':''}}">Все</a>@foreach(config('departments') as $slug=>$d)<a href="/teachers?department={{$slug}}" class="{{$department===$slug?'active':''}}">{{$d['title']}}</a>@endforeach</div><div class="teacher-grid">@foreach($teachers as $slug=>$t)<a class="teacher-tile" href="{{route('teachers.show',$slug)}}"><div class="teacher-photo">♪</div><small>{{config('departments.'.$t['department'].'.title')}}</small><h2>{{$t['name']}}</h2><p>{{$t['role']}}</p><span>О преподавателе →</span></a>@endforeach</div></section>
@endsection