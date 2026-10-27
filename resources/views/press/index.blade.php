@extends('layouts.app')
@section('title','Пресс-центр — ЧМУ')
@section('content')
<section class="press-hub-hero"><div><p class="eyebrow">Пресс-центр</p><h1>Жизнь училища <i>в событиях</i></h1><p>Новости, события, анонсы и публикации средств массовой информации — структура сохранена по оригинальному сайту училища.</p></div><div class="press-hub-index"><span>PRESS</span><b>ЧМУ</b><small>Чебоксары</small></div></section>
<nav class="edu-nav"><a href="#news">Новости</a><a href="/press/events">События</a><a href="/press/announcements">Анонсы</a><a href="/press/media-about-us">СМИ о нас</a><a href="/events">Афиша</a></nav>
<section class="press-hub-grid" id="news">
<a href="/press"><span>01</span><small>Лента</small><h2>Новости</h2><p>Новости училища, отделений, преподавателей и студентов.</p><b>Смотреть →</b></a>
<a href="/press/events"><span>02</span><small>Хроника</small><h2>События</h2><p>Материалы о прошедших значимых событиях и проектах.</p><b>Открыть →</b></a>
<a href="/press/announcements"><span>03</span><small>Предстоящие</small><h2>Анонсы</h2><p>Информационные сообщения о предстоящих мероприятиях.</p><b>Открыть →</b></a>
<a href="/press/media-about-us"><span>04</span><small>Публикации</small><h2>СМИ о нас</h2><p>Материалы внешних СМИ о деятельности училища.</p><b>Открыть →</b></a>
</section>
<section class="press-hub-latest"><div><p class="eyebrow">Публикации</p><h2>Последние материалы</h2><p>После подключения CMS здесь будет единая хронологическая лента четырёх типов публикаций.</p></div><div class="press-empty"><span>↗</span><h3>Контент будет загружаться из пресс-центра CMS</h3><p>Без демонстрационных дат и вымышленных новостей.</p></div></section>
@endsection