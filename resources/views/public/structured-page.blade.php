@extends('layouts.app')
@section('title',($page->seo_title?:$page->title).' — ЧМУ')
@section('meta_description',$page->seo_description?:$page->excerpt)
@section('content')
<section class="public-hero"><div><p class="eyebrow">Чебоксарское музыкальное училище</p><h1>{{$page->title}}</h1>@if($page->excerpt)<p>{{$page->excerpt}}</p>@endif</div><div class="public-glyph">♫</div></section>
<section class="block content-page">@if($page->content)<div class="rich-content">{!!$page->content!!}</div>@else<p>Содержимое страницы ещё не опубликовано в CMS.</p>@endif</section>
@if($documents->isNotEmpty())<section class="block"><p class="eyebrow">Материалы</p><h2>Документы</h2><div class="document-list">@foreach($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener"><b>{{$doc->title}}</b><small>{{$doc->document_date?->format('d.m.Y')}}</small><em>Открыть →</em></a>@endforeach</div></section>@endif
@endsection