@extends('layouts.app')
@section('title','Сведения об образовательной организации — ЧМУ')
@section('content')
<section class="official-hero"><div><p class="eyebrow">Официальная информация</p><h1>Сведения об<br>образовательной<br>организации</h1><p>Обязательная публичная информация Чебоксарского музыкального училища им. Ф. П. Павлова.</p></div><div class="official-seal">i</div></section>
<section class="official-search block"><div><p class="eyebrow">Быстрый доступ</p><h2>Разделы сведений</h2></div></section>
@forelse($groups as $group=>$items)<section class="block official-group"><div class="official-group-title"><p class="eyebrow">Раздел</p><h2>{{$group}}</h2></div><div class="official-links">@foreach($items as $item)<a href="{{route('official.show',$item->slug)}}"><span>→</span><div><h3>{{$item->title}}</h3><p>{{$item->lead}}</p></div></a>@endforeach</div></section>@empty<section class="block"><p>Официальные разделы ещё не заполнены в CMS.</p></section>@endforelse
@endsection