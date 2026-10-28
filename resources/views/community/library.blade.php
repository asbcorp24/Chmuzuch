@extends('layouts.app')
@section('title','Библиотека — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="library-hero"><div><p class="eyebrow">Библиотека</p><h1>{{$block['title']}}</h1><p>{{$block['text']??'Нотный фонд, учебная и методическая литература и электронные ресурсы.'}}</p></div><div class="library-mark"><span>𝄞</span><small>НОТНЫЙ ФОНД</small></div></section>
@elseif($id==='collections')<section class="library-collections"><div><p class="eyebrow">Фонды</p><h2>{{$block['title']}}</h2><div class="prose">{!!nl2br(e($block['text']??'Сведения о фондах библиотеки редактируются в конструкторе страницы.'))!!}</div></div></section>
@elseif($id==='digital')<section class="library-digital"><div><p class="eyebrow">Онлайн</p><h2>{{$block['title']}}</h2><div class="document-list">@forelse($documentGroups['digital']??[] as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener"><b>{{$doc->title}}</b><em>Открыть →</em></a>@empty<p>{{$block['text']??'Электронные ресурсы пока не опубликованы.'}}</p>@endforelse</div></div></section>
@elseif($id==='documents')<section class="library-rules"><div><h2>{{$block['title']}}</h2></div><div>@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener">{{$doc->title}} <span>→</span></a>@empty<p>Документы пока не опубликованы.</p>@endforelse @foreach($documentGroups['rules']??[] as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener">{{$doc->title}} <span>→</span></a>@endforeach</div></section>@endif
@endforeach
@endsection