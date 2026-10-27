@extends('layouts.app')
@section('title','Общежитие — ЧМУ')
@section('content')
<section class="dorm-hero"><div><p class="eyebrow">Студенту</p><h1>Общежитие</h1><p>Раздел сохранён по структуре оригинального сайта: общая информация, документы, студенческий совет и «Наши победы».</p></div><div class="dorm-house"><span>⌂</span><small>ЧМУ · ОБЩЕЖИТИЕ</small></div></section>
<nav class="edu-nav"><a href="#info">Общая информация</a><a href="/dormitory/documents">Документы</a><a href="/student-life/dorm-council">Студенческий совет</a><a href="/dormitory/victories">Наши победы</a></nav>
<section class="dorm-info" id="info"><div><p class="eyebrow">Проживание</p><h2>Общая информация</h2></div><div><p>Условия заселения, проживания, режим работы и актуальные контакты будут перенесены только из проверенных официальных материалов.</p><div class="dorm-actions"><a href="/dormitory/documents">Документы →</a><a href="/student-life/dorm-council">Студенческий совет →</a></div></div></section>
<section class="dorm-sections"><a href="/dormitory/documents"><span>01</span><small>Правила и положения</small><h3>Документы</h3><b>Открыть →</b></a><a href="/student-life/dorm-council"><span>02</span><small>Самоуправление</small><h3>Студенческий совет</h3><b>Открыть →</b></a><a href="/dormitory/victories"><span>03</span><small>Студенты</small><h3>Наши победы</h3><b>Открыть →</b></a></section>
@endsection