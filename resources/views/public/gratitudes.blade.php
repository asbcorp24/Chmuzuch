@extends('layouts.app')
@section('title','Нас благодарят — ЧМУ')
@section('content')
<nav class="honor-mini-nav"><a href="/pride">Наша гордость</a><a href="/laureates">Лауреаты и дипломанты</a><a href="/gratitudes">Нас благодарят</a><a href="/achievements">Все достижения</a></nav>
<section class="public-hero gratitude-hero"><div><p class="eyebrow">Отзывы и письма</p><h1>Нас<br>благодарят</h1><p>Благодарственные письма от организаций, партнёров, выпускников, зрителей и участников проектов.</p></div><div class="public-glyph">♥</div></section>
<section class="block gratitude-grid">@forelse($items as $item)<article><span>“</span><p>{{$item->description}}</p><h3>{{$item->person_name?:$item->title}}</h3><small>{{$item->competition}}{{$item->year?' • '.$item->year:''}}</small>@if($item->image)<a href="{{asset('storage/'.$item->image)}}" target="_blank">Открыть письмо →</a>@endif</article>@empty<div class="empty-state">Благодарности пока не опубликованы.</div>@endforelse</section>{{$items->links()}}
@endsection