@extends('layouts.app')
@section('title','Аудиозаписи — ЧМУ')
@section('content')
<section class="media-sub-hero audio-hero"><p class="eyebrow">Медиа · Аудио</p><h1>Аудиозаписи</h1><p>Исполнительские записи студентов, преподавателей и творческих коллективов училища.</p></section><nav class="edu-nav"><a href="/media">Все медиа</a><a href="/video-gallery">Видеогалерея</a><a href="/audio">Аудиозаписи</a></nav>
@include('public.partials.media-filters')
<section class="audio-list">@forelse($items as $item)<article><div><small>Аудиозапись</small><h3>{{$item->title}}</h3>@if($item->caption)<p>{{$item->caption}}</p>@endif<audio controls preload="metadata" src="{{asset('storage/'.$item->path)}}"></audio></div></article>@empty<div class="empty-state">Аудиозаписи пока не опубликованы.</div>@endforelse</section>{{$items->links()}}
@endsection