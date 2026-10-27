@extends('layouts.app')
@section('title',$program['title'].' — ДШИ ЧМУ')
@section('content')
<section class="dshi-program-hero"><div><a href="/dshi" class="backlink">← Все программы ДШИ</a><p class="eyebrow">Образовательная программа</p><h1>{{$program['title']}}</h1><p>{{$program['age']}}</p></div><div class="program-symbol">{{$program['symbol']}}</div></section>
<section class="block split"><div><p class="eyebrow">О программе</p><h2>Развиваем музыкальность и творческое мышление</h2></div><div><p>Описание программы, цели, возраст поступающих, продолжительность обучения, содержание занятий и ожидаемые результаты.</p></div></section>
<section class="block"><p class="eyebrow">Обучение</p><h2>Что входит в программу</h2><div class="study-grid"><article><b>01</b><h3>Основной предмет</h3><p>Практические индивидуальные и групповые занятия.</p></article><article><b>02</b><h3>Музыкальная грамота</h3><p>Слух, ритм, теория и музыкальное мышление.</p></article><article><b>03</b><h3>Сцена</h3><p>Концерты, творческие показы и практика.</p></article></div></section>
<section class="block dshi-admission"><div><p class="eyebrow">Поступление</p><h2>Записаться на программу</h2></div><div><p>Требования, сроки, документы и условия прослушивания будут управляться отдельно для каждой программы.</p><a href="/dshi#admission">Условия поступления →</a></div></section>
@endsection