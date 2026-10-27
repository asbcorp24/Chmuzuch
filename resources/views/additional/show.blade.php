@extends('layouts.app')
@section('title',$course['title'].' — ЦДО ЧМУ')
@section('content')
<section class="course-hero"><div><a class="backlink" href="/additional-education">← Все программы</a><p class="eyebrow">{{$course['kind']}}</p><h1>{{$course['title']}}</h1></div><div class="course-meta"><div><small>Объём</small><b>{{$course['hours']}}</b></div><div><small>Формат</small><b>{{$course['format']}}</b></div><div><small>Для кого</small><b>{{$course['audience']}}</b></div></div></section>
<section class="block split"><div><p class="eyebrow">О программе</p><h2>Практика, методика, профессиональный рост</h2></div><div><p>Описание программы, цели, результаты обучения, требования к слушателям и сведения о преподавателях.</p></div></section>
<section class="block"><p class="eyebrow">Содержание</p><h2>Учебный план</h2><div class="discipline-list">@foreach(['Теоретический модуль','Практический модуль','Методическая работа','Итоговая аттестация'] as $i=>$m)<div><span>0{{$i+1}}</span><h3>{{$m}}</h3></div>@endforeach</div></section>
<section class="block dual"><article><p class="eyebrow">Эксперты</p><h2>Преподаватели</h2><p>Педагоги училища и приглашённые специалисты.</p></article><article><p class="eyebrow">Результат</p><h2>Документ об обучении</h2><p>Сведения о выдаваемом удостоверении или дипломе.</p></article></section>
<section class="block open-day"><div><p class="eyebrow">Участие</p><h2>Подать заявку</h2><p>Выберите программу и заполните регистрационную форму.</p></div><a href="/additional-education#enroll">Записаться →</a></section>
@endsection