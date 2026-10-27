@extends('layouts.app')
@section('title','Отделения — ЧМУ')
@section('content')
<section class="section-hero"><p class="eyebrow">Образование • ЧМУ</p><h1>Отделения</h1><p>Профессиональная музыкальная школа, в которой академическая традиция соединяется с живой сценой.</p></section>
<section class="block department-catalog">@foreach(config('departments') as $slug=>$d)<a class="department-row" href="{{route('departments.show',$slug)}}"><span>{{str_pad($loop->iteration,2,'0',STR_PAD_LEFT)}}</span><h2>{{$d['title']}}</h2><div><small>Преподаватели • специальности • достижения</small><b>→</b></div></a>@endforeach</section>
@endsection