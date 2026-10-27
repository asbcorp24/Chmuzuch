@extends('layouts.app')
@section('title','Нас благодарят — ЧМУ')
@section('content')
<section class="public-hero gratitude-hero"><div><p class="eyebrow">Отзывы и письма</p><h1>Нас<br>благодарят</h1><p>Благодарственные письма от организаций, партнёров, выпускников, зрителей и участников проектов.</p></div><div class="public-glyph">♥</div></section>
<section class="block gratitude-grid">@for($i=0;$i<6;$i++)<article><span>“</span><p>Текст благодарности или выдержка из официального письма.</p><h3>Организация / автор</h3><small>Год • событие</small><a>Открыть письмо →</a></article>@endfor</section>
@endsection