@extends('layouts.app')
@section('title','Лауреаты и дипломанты — ЧМУ')
@section('content')
<section class="public-hero achievement-hero"><div><p class="eyebrow">Гордость училища</p><h1>Лауреаты<br>и дипломанты</h1><p>Достижения студентов, преподавателей и творческих коллективов.</p></div><div class="public-glyph">✦</div></section>
<section class="block achievement-filter"><div><p class="eyebrow">Каталог</p><h2>Достижения</h2></div><div><button>Все</button><button>Студенты</button><button>Преподаватели</button><button>Коллективы</button></div></section>
<section class="block"><div class="achievement-grid">@for($i=0;$i<8;$i++)<article><div class="avatar-placeholder">✦</div><small>Конкурс • год</small><h3>Лауреат / дипломант</h3><p>Специальность или коллектив • награда</p></article>@endfor</div></section>
<section class="block open-day"><div><p class="eyebrow">Конкурсы</p><h2>От достижений — к истории конкурса</h2><p>Результаты связываются с конкурсами, участниками, преподавателями и коллективами.</p></div><a href="/competitions">Все конкурсы →</a></section>
@endsection