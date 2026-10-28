@extends('layouts.app')
@section('title',($page->seo_title?:$page->title).' — ЧМУ')
@section('meta_description',$page->seo_description?:$page->excerpt)
@section('content')
<section class="public-hero"><div><p class="eyebrow">Чебоксарское музыкальное училище</p><h1>{{$page->title}}</h1>@if($page->excerpt)<p>{{$page->excerpt}}</p>@endif</div><div class="public-glyph page-3d" data-stl="{{!empty($page->blocks['scene3d']['stl'])?asset('storage/'.$page->blocks['scene3d']['stl']):''}}" data-rotation-x="{{$page->blocks['scene3d']['rotation_x']??0}}" data-rotation-y="{{$page->blocks['scene3d']['rotation_y']??0}}" data-rotation-z="{{$page->blocks['scene3d']['rotation_z']??0}}" data-model-scale="{{$page->blocks['scene3d']['scale']??1}}"></div></section>
<section class="block content-page">@if($page->content)<div class="rich-content">{!! $page->content !!}</div>@else<p>Содержимое страницы ещё не опубликовано в CMS.</p>@endif</section>
@include('public.partials.embedded-form')
@endsection