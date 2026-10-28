@extends('layouts.app')
@section('title','Концерты — ЧМУ')
@section('content')
<section class="section-hero"><p class="eyebrow">Музыкальная жизнь</p><h1>Концерты</h1><p>Выступления студентов, преподавателей и творческих коллективов училища.</p></section>
<section class="block"><div class="concert-grid">@forelse($concerts as $concert)<article class="concert-card"><small>{{$concert->starts_at?->format('d.m.Y H:i')}}</small><h2><a href="{{route('concerts.show',$concert->slug)}}">{{$concert->title}}</a></h2><p>{{$concert->place}}</p><p>{{$concert->excerpt}}</p><a href="{{route('concerts.show',$concert->slug)}}">Подробнее →</a></article>@empty<p>Анонсы концертов пока не опубликованы.</p>@endforelse</div>{{$concerts->links()}}</section>
@endsection
