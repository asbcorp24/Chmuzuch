@extends('layouts.app')
@section('title',$page->title.' — ЧМУ')
@section('content')
<section class="official-detail-hero"><div><a href="/official" class="backlink">← Сведения об образовательной организации</a><p class="eyebrow">{{$page->group}}</p><h1>{{$page->title}}</h1><p>{{$page->lead}}</p></div><div class="official-number">i</div></section>
@if($slug==='teachers')
<section class="block"><div class="section-head"><div><p class="eyebrow">Педагогические работники</p><h2>Преподаватели</h2></div><a href="/teachers">Каталог преподавателей →</a></div></section>
@elseif($slug==='science')
<section class="block open-day"><div><p class="eyebrow">Исследования</p><h2>Наука и проекты</h2></div><a href="/science">Перейти →</a></section>
@elseif($slug==='facilities')
<section class="block"><p class="eyebrow">Оснащение</p><h2>Материально-техническая база</h2><div class="facility-cards">@foreach(['Учебные кабинеты','Концертные залы','Библиотека','Объекты спорта','Средства обучения','Электронные ресурсы'] as $x)<article><span>▧</span><h3>{{$x}}</h3></article>@endforeach</div></section>
@endif
@if($page->content)<section class="block"><p class="eyebrow">Информация</p><h2>{{$page->title}}</h2><div class="official-content">{!! nl2br(e($page->content)) !!}</div></section>@endif
<section class="block"><p class="eyebrow">Файлы</p><h2>Документы раздела</h2><div class="document-list">@forelse($documents as $document)<a href="{{asset('storage/'.$document->file_path)}}" target="_blank" rel="noopener"><span>{{strtoupper(pathinfo($document->file_path,PATHINFO_EXTENSION))}}</span><b>{{$document->title}}</b><small>{{$document->number}} {{$document->document_date?->format('d.m.Y')}}</small><em>Открыть →</em></a>@empty<p>Документы раздела пока не опубликованы.</p>@endforelse</div></section>
@endsection