@extends('layouts.app')
@section('title',$title.' — ЧМУ')
@section('content')
<section class="service-hero {{$mode}}"><div><p class="eyebrow">{{$eyebrow}}</p><h1>{{$title}}</h1><p>@if($mode==='safety')Инструкции, документы и актуальные материалы по защите студентов, сотрудников и информационной среды.@elseДокументы, методические материалы, профессиональное развитие и рабочие ресурсы сотрудников училища.@endif</p></div><div class="service-symbol">{{$mode==='safety'?'⊕':'↗'}}</div></section>
<section class="block service-grid">@foreach($items as $slug=>$item)<a href="{{route('service.show',[$mode,$slug])}}"><span>{{$item['icon']}}</span><div><h2>{{$item['title']}}</h2><p>{{$item['lead']}}</p></div><b>→</b></a>@endforeach</section>
@if($mode==='safety')
<section class="block emergency-zone"><div><p class="eyebrow">Важно</p><h2>Экстренная информация</h2><p>Алгоритмы действий при угрозах и происшествиях должны быть доступны с любого устройства в несколько касаний.</p></div><div class="emergency-cards"><span>Экстренные службы</span><span>Эвакуация</span><span>Сообщить о проблеме</span></div></section>
@else
<section class="block employee-tools"><div><p class="eyebrow">Быстрый доступ</p><h2>Рабочие инструменты</h2></div><div><a>Расписание</a><a>Документы и формы</a><a>Методические материалы</a><a>Внутренние ресурсы</a></div></section>
@endif
@endsection