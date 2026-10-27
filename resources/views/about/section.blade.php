@extends('layouts.app')
@section('title',$page['title'].' — ЧМУ')
@section('content')
<section class="about-section-hero"><div><a href="/about" class="backlink">← Об училище</a><p class="eyebrow">{{$page['eyebrow']}}</p><h1>{{$page['title']}}</h1><p>{{$page['lead']}}</p></div><div class="section-glyph">@if($section==='history')⌛@elseif($section==='pavlov')ФП@elseif($section==='leadership')◇@elseif($section==='structure')⌘@elseif($section==='pride')✦@else♫@endif</div></section>
@if($section==='history')
<section class="block"><p class="eyebrow">Хронология</p><h2>Основные этапы</h2><div class="history-timeline">@foreach(['Основание училища','Становление педагогической школы','Развитие исполнительских традиций','Новые специальности и коллективы','Современный этап'] as $i=>$x)<div><span>{{str_pad($i+1,2,'0',STR_PAD_LEFT)}}</span><h3>{{$x}}</h3><p>Дата, архивные материалы, события и люди этого периода.</p></div>@endforeach</div></section>
<section class="block dual"><article><p class="eyebrow">Архив</p><h2>Документы и фотографии</h2><p>Исторические документы, программы, афиши и фотоматериалы.</p></article><article><p class="eyebrow">Люди</p><h2>Педагоги и выпускники</h2><p>Личности, сформировавшие историю училища.</p></article></section>
@elseif($section==='pavlov')
<section class="block pavlov-profile"><div class="portrait-placeholder large">ФП</div><div><p class="eyebrow">Биография</p><h2>Жизнь и творчество</h2><p>Биографический очерк, основные этапы творческого пути и вклад Ф. П. Павлова в музыкальную культуру.</p></div></section><section class="block dual"><article><h2>Творческое наследие</h2><p>Произведения, материалы, исследования.</p></article><article><h2>Память</h2><p>Архив, события и проекты, посвящённые Ф. П. Павлову.</p></article></section>
@elseif($section==='leadership')
<section class="block"><p class="eyebrow">Администрация</p><h2>Руководство училища</h2><div class="leadership-grid">@foreach(['Директор','Заместитель директора по учебной работе','Заместитель директора по воспитательной работе','Заместитель директора по административной работе'] as $role)<article><div class="avatar-placeholder">◇</div><small>{{$role}}</small><h3>Руководитель</h3><p>Контакты • часы приёма • направление работы</p></article>@endforeach</div></section>
@elseif($section==='structure')
<section class="block"><p class="eyebrow">Организация</p><h2>Структура</h2><div class="structure-tree"><b>Чебоксарское музыкальное училище</b><div><a href="/departments">Отделения</a><a href="/dshi">ДШИ</a><a href="/additional-education">ЦДО</a><a href="/collectives">Творческие коллективы</a><a href="/science">Наука и проекты</a><a href="/dormitory">Общежитие</a></div></div></section>
@elseif($section==='pride')
<section class="block"><p class="eyebrow">Лица училища</p><h2>Достижения и имена</h2><div class="pride-gallery">@for($i=0;$i<6;$i++)<article><div class="avatar-placeholder">✦</div><small>Достижение</small><h3>Лауреат / выпускник</h3><p>Год • конкурс • специальность</p></article>@endfor</div></section>
@else
<section class="block"><p class="eyebrow">Инфраструктура</p><h2>Пространства училища</h2><div class="facility-cards">@foreach(['Учебные аудитории','Концертные залы','Музыкальные инструменты','Техническое оборудование','Библиотека и нотный фонд','Доступная среда'] as $x)<article><span>▧</span><h3>{{$x}}</h3><p>Описание, оснащение, фотографии и документы.</p></article>@endforeach</div></section>
@endif
@endsection