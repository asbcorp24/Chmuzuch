@extends('layouts.app')
@section('title','Общежитие — ЧМУ')
@section('content')
<section class="public-hero dorm-hero"><div><p class="eyebrow">Студенческий дом</p><h1>Общежитие</h1><p>Условия проживания, документы, студенческий совет и жизнь общежития.</p></div><div class="public-glyph">⌂</div></section>
<nav class="applicant-nav"><a href="#about">Общежитие</a><a href="#docs">Документы</a><a href="#council">Студсовет</a><a href="#wins">Наши победы</a></nav>
<section id="about" class="block split"><div><p class="eyebrow">Проживание</p><h2>Общая информация</h2></div><div><p>Информация о здании, комнатах, инфраструктуре, порядке заселения, правилах проживания и контактах.</p><div class="fact-row"><span><b>⌂</b>Комнаты</span><span><b>♫</b>Среда для студентов</span><span><b>✓</b>Правила проживания</span></div></div></section>
<section id="docs" class="block"><p class="eyebrow">Заселение и проживание</p><h2>Документы</h2><div class="document-list"><a><span>PDF</span><b>Положение об общежитии</b><em>Открыть →</em></a><a><span>PDF</span><b>Правила внутреннего распорядка</b><em>Открыть →</em></a><a><span>DOC</span><b>Формы и заявления</b><em>Скачать →</em></a></div></section>
<section id="council" class="block council-zone"><div><p class="eyebrow">Самоуправление</p><h2>Студенческий совет общежития</h2><p>Состав совета, направления работы, инициативы, мероприятия и обратная связь.</p></div><div class="avatar-placeholder">СО</div></section>
<section id="wins" class="block"><p class="eyebrow">Жизнь общежития</p><h2>Наши победы</h2><div class="media-panels"><div>✦<span>Конкурсы</span></div><div>▧<span>Фотогалерея</span></div><div>♥<span>Студенческие инициативы</span></div></div></section>
@endsection