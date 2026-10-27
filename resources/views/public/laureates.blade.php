@extends('layouts.app')
@section('title','Лауреаты и дипломанты — ЧМУ')
@section('content')
<section class="honor-hero laureate-hero"><p class="eyebrow">Достижения</p><h1>Лауреаты <i>и дипломанты</i></h1><p>Конкурсные достижения студентов и творческих коллективов училища.</p></section>
<nav class="edu-nav"><a href="/pride">Наша гордость</a><a href="/laureates">Лауреаты и дипломанты</a><a href="/gratitudes">Нас благодарят</a><a href="/achievements">Все достижения</a></nav>
<section class="honor-list"><div class="honor-list-head"><div><p class="eyebrow">Архив</p><h2>Конкурсные результаты</h2></div><div><button class="active">Все годы</button><button>По отделениям</button></div></div><div class="honor-empty"><span>✦</span><h3>Результаты будут перенесены из оригинального раздела</h3><p>Без вымышленных конкурсов, мест, фамилий и дат.</p></div></section>
@endsection