@extends('layouts.app')
@section('title',$page->title.' — ЧМУ')
@section('content')
<section class="service-detail-hero"><div><a href="/{{$portal==='safety'?'safety':'employees'}}" class="backlink">← {{$portal==='safety'?'Безопасность':'Работникам'}}</a><p class="eyebrow">{{$page->group?:($portal==='safety'?'Безопасная среда':'Для сотрудников')}}</p><h1>{{$page->title}}</h1><p>{{$page->lead}}</p></div><div class="service-detail-symbol">{{$page->icon}}</div></section>
@if($page->content)<section class="block split"><div><p class="eyebrow">Информация</p><h2>{{$page->title}}</h2></div><div>{!! nl2br(e($page->content)) !!}</div></section>@endif
<section class="block"><p class="eyebrow">Материалы</p><h2>Документы и памятки</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank"><b>{{$doc->title}}</b><small>{{$doc->document_date?->format('d.m.Y')}}</small><em>Открыть →</em></a>@empty<p>Материалы пока не опубликованы.</p>@endforelse</div></section>
@endsection