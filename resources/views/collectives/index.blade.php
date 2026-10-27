@extends('layouts.app')
@section('title','Творческие коллективы — ЧМУ')
@section('content')
<section class="section-hero"><p class="eyebrow">Сцена • ЧМУ</p><h1>Творческие коллективы</h1><p>Оркестры, хоры и ансамбли — пространство, где обучение становится настоящей концертной практикой.</p></section>
<section class="block collective-grid">@foreach($collectives as $slug=>$c)<a class="collective-tile" href="{{route('collectives.show',$slug)}}"><div class="collective-art"><span>{{$c['symbol']}}</span><small>{{$c['type']}}</small></div><p>{{config('departments.'.$c['department'].'.title')}}</p><h2>{{$c['title']}}</h2><span>О коллективе →</span></a>@endforeach</section>
@endsection