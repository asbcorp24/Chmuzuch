@extends('layouts.app')
@section('title','Нас благодарят — ЧМУ')
@section('content')
<nav class="honor-mini-nav"><a href="/pride">Наша гордость</a><a href="/laureates">Лауреаты и дипломанты</a><a href="/gratitudes">Нас благодарят</a><a href="/achievements">Все достижения</a></nav>
<section class="public-hero gratitude-hero"><div><p class="eyebrow">Отзывы и письма</p><h1>Нас<br>благодарят</h1><p>Благодарственные письма от организаций, партнёров, выпускников, зрителей и участников проектов.</p></div><div class="public-glyph">♥</div></section>
<section class="block gratitude-grid">@for($i=0;$i<6;$i++)<article><span>“</span><p>Текст благодарности или выдержка из официального письма.</p><h3>Организация / автор</h3><small>Год • событие</small><a>Открыть письмо →</a></article>@endfor</section>
@endsection