@extends('layouts.app')
@section('title',($page->seo_title?:$page->title).' — ЧМУ')
@section('meta_description',$page->seo_description?:$page->excerpt)
@section('content')
<section class="public-hero"><div><p class="eyebrow">Чебоксарское музыкальное училище</p><h1>{{$page->title}}</h1>@if($page->excerpt)<p>{{$page->excerpt}}</p>@endif</div><div class="public-glyph page-3d" data-stl="{{!empty($page->blocks['scene3d']['stl'])?asset('storage/'.$page->blocks['scene3d']['stl']):''}}" data-rotation-x="{{$page->blocks['scene3d']['rotation_x']??0}}" data-rotation-y="{{$page->blocks['scene3d']['rotation_y']??0}}" data-rotation-z="{{$page->blocks['scene3d']['rotation_z']??0}}" data-model-scale="{{$page->blocks['scene3d']['scale']??1}}"></div></section>
<section class="block content-page">@if($page->content)<div class="rich-content">{!! $page->content !!}</div>@else<p>Содержимое страницы ещё не опубликовано в CMS.</p>@endif</section>
@if(!empty($page->blocks['media']))
<section class="block page-media-section"><p class="eyebrow">Медиаматериалы</p><h2>Фотографии, музыка, видео и документы</h2><div class="page-media-grid">
@foreach($page->blocks['media'] as $media)
@php($url=asset('storage/'.$media['path']))
<figure class="page-media-item">
@if(($media['type']??'')==='image')<a href="{{$url}}" target="_blank" rel="noopener"><img src="{{$url}}" loading="lazy" alt="{{$media['title']??$page->title}}"></a>
@elseif(($media['type']??'')==='audio')<audio controls preload="none" src="{{$url}}">Ваш браузер не поддерживает аудио.</audio>
@elseif(($media['type']??'')==='video')<video controls preload="metadata" playsinline src="{{$url}}">Ваш браузер не поддерживает видео.</video>@elseif(($media['type']??'')==='document')<a class="cms-document-link" href="{{$url}}" download>📄 {{$media['title']??basename($media['path'])}} — скачать</a>@if(strtolower(pathinfo($media['path'],PATHINFO_EXTENSION))==='pdf')<a href="{{$url}}" target="_blank" rel="noopener">Открыть PDF</a>@endif@endif
<figcaption>{{$media['title']??''}}</figcaption></figure>
@endforeach
</div></section>@endif
@include('public.partials.embedded-form')
@endsection