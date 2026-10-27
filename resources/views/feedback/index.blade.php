@extends('layouts.app')
@section('title','Обратная связь — ЧМУ')
@section('content')
<section class="feedback-hero"><div><p class="eyebrow">Обратная связь</p><h1>Напишите <i>нам</i></h1><p>Задайте вопрос училищу. Перед отправкой проверьте контактные данные — они нужны для ответа.</p></div><div class="feedback-mark"><span>↗</span><small>ЧМУ · ОБРАТНАЯ СВЯЗЬ</small></div></section>
<section class="feedback-wrap"><aside><p class="eyebrow">Связаться</p><h2>Ваш вопрос</h2><p>Форма сохраняет состав полей исходного сайта и подготовлена для подключения к единому модулю обращений CMS.</p><a href="/contacts">Контакты училища →</a><a href="/legal/privacy">Политика обработки данных →</a></aside>
<div class="feedback-form-card">
<form id="public-feedback-form" action="#" method="post" novalidate>
@csrf
<div class="feedback-field"><label for="feedback-name">Ваше имя <b>*</b></label><input id="feedback-name" name="name" type="text" required autocomplete="name" placeholder="Как к вам обращаться"></div>
<div class="feedback-row"><div class="feedback-field"><label for="feedback-phone">Телефон <b>*</b></label><input id="feedback-phone" name="phone" type="tel" required autocomplete="tel" placeholder="+7 ___ ___-__-__"></div><div class="feedback-field"><label for="feedback-email">E-mail <b>*</b></label><input id="feedback-email" name="email" type="email" required autocomplete="email" placeholder="name@example.ru"></div></div>
<div class="feedback-field"><label for="feedback-message">Сообщение <b>*</b></label><textarea id="feedback-message" name="message" rows="7" required placeholder="Напишите ваш вопрос"></textarea></div>
<label class="feedback-consent"><input type="checkbox" name="consent" required><span>Я даю согласие на обработку персональных данных в соответствии с <a href="/legal/privacy">политикой обработки персональных данных</a>.</span></label>
<div class="feedback-submit"><button type="submit">Отправить сообщение <span>→</span></button><small id="feedback-status">Поля со знаком * обязательны.</small></div>
</form>
</div></section>
<section class="feedback-help"><div><p class="eyebrow">Перед обращением</p><h2>Возможно, ответ уже есть</h2></div><div class="feedback-links"><a href="/applicants"><span>01</span><b>Поступление</b><small>Абитуриенту →</small></a><a href="/students"><span>02</span><b>Обучение</b><small>Студенту →</small></a><a href="/schedule"><span>03</span><b>Расписание</b><small>Открыть →</small></a><a href="/official"><span>04</span><b>Документы</b><small>Сведения →</small></a></div></section>
@endsection