@extends('layouts.app')
@section('title','Расписание — ЧМУ')
@section('content')
<section class="schedule-hero"><p class="eyebrow">Учебный процесс</p><h1>Расписание</h1><p>Занятия, консультации и экзамены. Фактические данные будут публиковаться учебной частью.</p></section>
<section class="schedule-shell">
<div class="schedule-controls"><div class="schedule-role"><button class="active" data-schedule-role="student">Студент</button><button data-schedule-role="teacher">Преподаватель</button></div><label><span data-schedule-label>Группа</span><select data-schedule-person><option>Выберите группу</option><option>1 курс · группа</option><option>2 курс · группа</option><option>3 курс · группа</option><option>4 курс · группа</option></select></label><label>Неделя<input type="week"></label><div class="schedule-view"><button class="active" data-schedule-view="week">Неделя</button><button data-schedule-view="day">День</button></div></div>
<div class="schedule-weekbar"><button>←</button><div><small>Учебная неделя</small><b>Выберите актуальную неделю</b></div><button>Сегодня</button><button>→</button></div>
<div class="schedule-days" data-schedule-days>
@foreach(['Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'] as $di=>$day)<section class="schedule-day"><header><span>0{{$di+1}}</span><h2>{{$day}}</h2></header><div class="schedule-lessons">
@foreach([['09:00','Специальность','Индивидуальное','Ауд. —'],['10:40','Музыкально-теоретическая дисциплина','Групповое','Ауд. —'],['12:20','Ансамбль / оркестр','Практическое','Зал / ауд. —']] as $lesson)<article><time>{{$lesson[0]}}</time><div><small>{{$lesson[2]}}</small><b>{{$lesson[1]}}</b><span>Преподаватель · {{$lesson[3]}}</span></div><i>Учебное</i></article>@endforeach
</div></section>@endforeach
</div>
<section class="schedule-extra"><article><p class="eyebrow">Консультации</p><h2>Дополнительные занятия</h2><p>Индивидуальные консультации и подготовка к контрольным мероприятиям.</p><a href="#consultations">Смотреть →</a></article><article><p class="eyebrow">Экзамены</p><h2>Сессия и ГИА</h2><p>Отдельное расписание экзаменов, зачётов, академических концертов и ГИА.</p><a href="/education#gia">Раздел ГИА →</a></article></section>
<div class="schedule-note"><b>Важно</b><p>Сейчас отображается макет структуры расписания, а не фактические занятия училища. После подключения CMS/импорта здесь будут реальные группы, преподаватели, аудитории и изменения.</p></div>
</section>
@endsection