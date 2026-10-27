@extends('layouts.app')
@section('title','Видеогалерея — ЧМУ')
@section('content')
<section class="media-sub-hero"><p class="eyebrow">Медиа · Видео</p><h1>Видеогалерея</h1><p>Концерты, выступления, проекты и другие видеоматериалы училища.</p></section><nav class="edu-nav"><a href="/media">Все медиа</a><a href="/video-gallery">Видеогалерея</a><a href="/audio">Аудиозаписи</a></nav>
<section class="media-sub-grid">@forelse($items as $item)<article><video controls preload="metadata" src="{{asset('storage/'.$item->path)}}"></video><small>Видео</small><h3>{{$item->title}}</h3>@if($item->caption)<p>{{$item->caption}}</p>@endif</article>@empty<div class="empty-state">Видеоматериалы пока не опубликованы.</div>@endforelse</section>{{$items->links()}}
@endsection