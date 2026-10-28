@extends('layouts.app')
@section('content')
@foreach($blocks as $block)
@php($id=$block['id']??'')
@if($id==='hero')
<section class="hero"><div id="hero-3d" class="hero-3d" data-stl="{{!empty($block['scene3d']['stl'])?asset('storage/'.$block['scene3d']['stl']):''}}" data-rotation-x="{{$block['scene3d']['rotation_x']??0}}" data-rotation-y="{{$block['scene3d']['rotation_y']??0}}" data-rotation-z="{{$block['scene3d']['rotation_z']??0}}" data-model-scale="{{$block['scene3d']['scale']??1}}"></div><div class="hero-copy"><p class="eyebrow">Шупашкар • Чебоксары</p><h1>{!! $block['headline']??'Музыка.<br>Наследие.<br><em>Будущее.</em>' !!}</h1><p>{{$block['subtitle']??'Чебоксарское музыкальное училище имени Ф. П. Павлова — академическая традиция в современном цифровом пространстве.'}}</p><div class="hero-actions"><a href="/applicants">Поступить</a><a href="/events" class="ghost">Афиша</a></div></div><div class="ornament"></div>
<nav class="hero-explorer" aria-label="Интерактивная навигация по разделам сайта">
<div class="hero-explorer-heading"><span>Исследуйте училище</span><small>Выберите направление</small></div>
<div class="hero-explorer-links">
@foreach($siteNavigation->where('location','header')->whereNull('parent_id')->take(8) as $navItem)
<div class="hero-explorer-item">
<a href="{{$navItem->url}}" class="hero-explorer-link"><span class="hero-explorer-note">♫</span><span>{{$navItem->label}}</span><span aria-hidden="true">↗</span></a>
@php($navChildren=$siteNavigation->where('parent_id',$navItem->id))
@if($navChildren->isNotEmpty())
<button type="button" class="hero-explorer-expand" aria-expanded="false" aria-label="Подразделы: {{$navItem->label}}">+</button>
<div class="hero-explorer-children" hidden>@foreach($navChildren as $child)<a href="{{$child->url}}">{{$child->label}}</a>@endforeach</div>
@endif
</div>
@endforeach
</div>
</nav></section>
@elseif($id==='ticker')
<section class="ticker"><span>ЧМУ • Ф. П. Павлов</span><span>Академическая музыка</span><span>Чувашская культура</span><span>Творчество и образование</span></section>
@elseif($id==='intro')
<section class="block"><p class="eyebrow">Училище</p><div class="split"><h2>{{$block['title']??'Музыкальная традиция Чувашии в движении'}}</h2><p>{{$block['subtitle']??'Чебоксарское музыкальное училище имени Ф. П. Павлова — музыкальное образование, творческие коллективы и культурная жизнь Чувашии.'}}</p></div></section>
@elseif($id==='competitions' || $id==='conferences')
<section class="block dual"><article><p class="eyebrow">Конкурсы</p><h2>Профессиональная сцена начинается здесь</h2><a href="/competitions">Конкурсы →</a></article><article><p class="eyebrow">Наука</p><h2>Конференции и исследования</h2><a href="/conferences">Конференции →</a></article></section>
@elseif($id==='achievements')
<section class="block achievements"><div><p class="eyebrow">Гордость училища</p><h2>Лауреаты и дипломанты</h2><a href="/achievements">Достижения →</a></div><div><p class="eyebrow">Обратная связь</p><h2>Нас благодарят</h2><a href="/gratitudes">Благодарности →</a></div></section>
@elseif($id==='official')
<section class="block official-teaser"><p class="eyebrow">Официально</p><h2>Сведения об образовательной организации</h2><a href="/official">Перейти →</a></section>
@elseif($id==='additional' || $id==='dshi' || $id==='student_life' || $id==='dormitory' || $id==='applicant_consultation')
@php($links=['additional'=>['/additional-education','Центр дополнительного образования'],'dshi'=>['/dshi','Детская школа искусств'],'student_life'=>['/student-life','Студенческая жизнь'],'dormitory'=>['/dormitory','Общежитие'],'applicant_consultation'=>['/applicants','Абитуриентам']])
<section class="block"><p class="eyebrow">Раздел училища</p><h2>{{$block['title']??$links[$id][1]}}</h2><a href="{{$links[$id][0]}}">Подробнее →</a></section>
@elseif($id==='news')
<section class="block"><div class="section-head"><div><p class="eyebrow">Пресс-центр</p><h2>{{$block['title']??'Новости'}}</h2></div><a href="/news">Все новости →</a></div><div class="cards cards-3">@forelse($news as $item)<article class="card"><span>{{$item->published_at?->format('d.m')}}</span><h3><a href="{{route('press.article',['news',$item->slug])}}">{{$item->title}}</a></h3><p>{{$item->excerpt}}</p></article>@empty<p>Новости пока не опубликованы.</p>@endforelse</div></section>
@elseif(in_array($id,['announcements','announce']))
<section class="block accent-block"><p class="eyebrow">Анонсы</p><div class="feature-row"><div><h3>{{$block['title']??'Важные объявления училища'}}</h3>@foreach($announcements as $item)<p>{{$item->title}}</p>@endforeach</div><a href="/press#announcements">Смотреть →</a></div></section>
@elseif(in_array($id,['events','afisha']))
<section class="block"><div class="section-head"><div><p class="eyebrow">Сцена</p><h2>{{$block['title']??'Афиша'}}</h2></div><a href="/events">Вся афиша →</a></div><div class="cards cards-3">@forelse($events as $event)<article class="card event-card"><div class="date"><b>{{$event->starts_at?->format('d')??'—'}}</b><span>{{$event->starts_at?->translatedFormat('M')}}</span></div><div><small>{{$event->place}}</small><h3><a href="{{route('events.show',$event->slug)}}">{{$event->title}}</a></h3></div></article>@empty<p>События пока не опубликованы.</p>@endforelse</div></section>
@elseif($id==='departments')
<section class="block"><div class="section-head"><div><p class="eyebrow">Образование</p><h2>{{$block['title']??'Отделения'}}</h2></div><a href="/departments">Все отделения →</a></div><div class="department-strip">@foreach($departments as $d)<a href="{{route('departments.show',$d->slug)}}"><span>♪</span>{{$d->title}}</a>@endforeach</div></section>
@elseif($id==='collectives')
<section class="block"><div class="section-head"><div><p class="eyebrow">Творчество</p><h2>{{$block['title']??'Коллективы'}}</h2></div><a href="/collectives">Все коллективы →</a></div><div class="cards cards-3">@foreach($collectives as $c)<article class="card visual-card"><div class="visual-placeholder">◌</div><h3><a href="{{route('collectives.show',$c->slug)}}">{{$c->title}}</a></h3></article>@endforeach</div></section>
@elseif($id==='media')
<section class="block"><div class="section-head"><div><p class="eyebrow">Медиа</p><h2>{{$block['title']??'Слушать. Смотреть. Чувствовать.'}}</h2></div><a href="/media">Медиатека →</a></div><div class="cards cards-3"><article class="card"><b>▶</b><h3>Видео</h3></article><article class="card"><b>♫</b><h3>Аудиозаписи</h3></article><article class="card"><b>▧</b><h3>Фото</h3></article></div></section>
@elseif(in_array($id,['portals','links']))
<section class="portal-grid expanded"><a href="/applicants"><b>Абитуриенту</b></a><a href="/students"><b>Студенту</b></a><a href="/dshi"><b>ДШИ</b></a><a href="/additional-education"><b>ЦДО</b></a><a href="/dormitory"><b>Общежитие</b></a><a href="/official"><b>Сведения</b></a></section>
@else
<section class="block"><p class="eyebrow">{{$block['type']??'Раздел'}}</p><h2>{{$block['title']??'Раздел'}}</h2>@if(!empty($block['subtitle']))<p>{{$block['subtitle']}}</p>@endif</section>
@endif
@endforeach
@endsection