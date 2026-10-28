@extends('layouts.app')
@section('title','Карта сайта — ЧМУ')
@section('content')
<section class="system-hero"><p class="eyebrow">Навигация</p><h1>Карта сайта</h1><p>Разделы сайта и опубликованные каталоги.</p></section>
<section class="block sitemap-grid">
<div><h2>Навигация</h2>
@foreach($siteNavigation->where('location','header')->whereNull('parent_id') as $item)
<a href="{{$item->url}}">{{$item->label}} →</a>
@foreach($siteNavigation->where('parent_id',$item->id) as $child)<a href="{{$child->url}}">— {{$child->label}} →</a>@endforeach
@endforeach
</div>
<div><h2>Отделения</h2>@foreach($departments as $item)<a href="{{route('departments.show',$item->slug)}}">{{$item->title}} →</a>@endforeach</div>
<div><h2>Коллективы</h2>@foreach($collectives as $item)<a href="{{route('collectives.show',$item->slug)}}">{{$item->title}} →</a>@endforeach</div>
<div><h2>Конкурсы и проекты</h2>@foreach($activities as $item)
@php $url=$item->type==='competition'?route('competitions.show',$item->slug):($item->type==='conference'?route('science.conference',$item->slug):route('science.project',$item->slug)); @endphp
<a href="{{$url}}">{{$item->title}} →</a>
@endforeach</div>
</section>
@endsection
