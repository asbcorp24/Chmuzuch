@extends('layouts.app')
@section('title','Творческие коллективы — ЧМУ')
@section('content')
<section class="section-hero"><p class="eyebrow">Сцена • ЧМУ</p><h1>Творческие коллективы</h1><p>Оркестры, хоры и ансамбли — пространство, где обучение становится настоящей концертной практикой.</p></section>
<section class="block collective-grid">@forelse($collectives as $c)<a class="collective-tile" href="{{route('collectives.show',$c->slug)}}"><div class="collective-art"><span>♫</span><small>Творческий коллектив</small></div><p>{{$c->department?->title??'ЧМУ'}}</p><h2>{{$c->title}}</h2><span>О коллективе →</span></a>@empty<div class="empty-state">Информация о коллективах готовится к публикации.</div>@endforelse</section>{{$collectives->links()}}
@endsection