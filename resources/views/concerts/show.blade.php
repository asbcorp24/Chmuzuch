@extends('layouts.app')
@section('title',$concert->title.' — Концерты')
@section('content')
<section class="section-hero"><p class="eyebrow">Концерт</p><h1>{{$concert->title}}</h1><p>{{$concert->starts_at?->format('d.m.Y H:i')}} · {{$concert->place}}</p></section>
<section class="block"><div class="prose">{!! nl2br(e($concert->content)) !!}</div>@if($concert->external_url)<p><a href="{{$concert->external_url}}" rel="noopener noreferrer" target="_blank">Подробнее о концерте →</a></p>@endif</section>
@endsection
