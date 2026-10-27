@extends('layouts.app')
@section('title','Отделения — ЧМУ')
@section('content')
<section class="section-hero"><p class="eyebrow">Образование • ЧМУ</p><h1>Отделения</h1><p>Профессиональная музыкальная школа, в которой академическая традиция соединяется с живой сценой.</p></section>
<section class="block department-catalog">
@php($departments=['Фортепиано','Народных инструментов','Оркестровых струнных инструментов','Духовых и ударных инструментов','Дирижёрско-хоровое','Вокального искусства','Теории музыки','Музыкальное искусство эстрады','Сольного и хорового народного пения','Общего фортепиано','Гуманитарных, социально-экономических и общеобразовательных дисциплин'])
@foreach($departments as $i=>$d)<article class="department-row"><span>{{str_pad($i+1,2,'0',STR_PAD_LEFT)}}</span><h2>{{$d}}</h2><div><small>Преподаватели • специальности • достижения</small><b>→</b></div></article>@endforeach
</section>
@endsection