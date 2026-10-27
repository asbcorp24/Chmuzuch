@extends('layouts.app')
@section('title',$page['title'].' — ЧМУ')
@section('content')
<section class="official-detail-hero"><div><a href="/official" class="backlink">← Сведения об образовательной организации</a><p class="eyebrow">{{$page['group']}}</p><h1>{{$page['title']}}</h1><p>{{$page['lead']}}</p></div><div class="official-number">{{str_pad(array_search($slug,array_keys(config('official_sections'))) + 1,2,'0',STR_PAD_LEFT)}}</div></section>
@if($slug==='facilities')
<section class="block"><p class="eyebrow">Оснащение</p><h2>Материально-техническая база</h2><div class="facility-cards">@foreach(['Учебные кабинеты','Концертные залы','Библиотека','Объекты спорта','Средства обучения','Электронные ресурсы'] as $x)<article><span>▧</span><h3>{{$x}}</h3><p>Сведения, оснащение и документы.</p></article>@endforeach</div></section>
<section class="block accessibility-zone"><div><p class="eyebrow">Доступная среда</p><h2>Условия для обучающихся с ОВЗ и инвалидностью</h2><p>Доступность объектов, специальные технические средства, условия обучения и сопровождение.</p></div><span>♿</span></section>
@elseif($slug==='vacancies')
<section class="block"><p class="eyebrow">Приём и перевод</p><h2>Вакантные места</h2><div class="official-table"><div><b>Образовательная программа</b><b>Курс</b><b>Бюджет</b><b>Платно</b></div>@for($i=0;$i<4;$i++)<div><span>Программа</span><span>{{$i+1}}</span><span>—</span><span>—</span></div>@endfor</div></section>
@elseif($slug==='teachers')
<section class="block"><div class="section-head"><div><p class="eyebrow">Педагогические работники</p><h2>Преподаватели</h2></div><a href="/teachers">Каталог преподавателей →</a></div><p>Официальные сведения связаны с единым каталогом педагогического состава.</p></section>
@elseif($slug==='science')
<section class="block open-day"><div><p class="eyebrow">Исследования</p><h2>Наука и проекты</h2><p>Научная, проектная и исследовательская деятельность вынесена в отдельный содержательный портал.</p></div><a href="/science">Перейти →</a></section>
@elseif($slug==='quality-survey')
<section class="block survey-zone"><div><p class="eyebrow">Обратная связь</p><h2>Оцените условия обучения</h2><p>Анкета удовлетворённости качеством образовательной деятельности.</p></div><form>@foreach(['Качество образовательной среды','Доступность информации','Условия обучения','Работа сотрудников'] as $q)<label>{{$q}}<select><option>Выберите оценку</option><option>5 — отлично</option><option>4 — хорошо</option><option>3 — удовлетворительно</option><option>2 — плохо</option><option>1 — очень плохо</option></select></label>@endforeach<textarea placeholder="Комментарий"></textarea><button type="button">Отправить</button></form></section>
@else
<section class="block"><p class="eyebrow">Информация</p><h2>{{$page['title']}}</h2><div class="official-content"><p>{{$page['lead']}}</p><p>Содержимое раздела будет управляться через CMS с сохранением официальной структуры и обязательных сведений.</p></div></section>
<section class="block"><p class="eyebrow">Файлы</p><h2>Документы раздела</h2><div class="document-list"><a><span>PDF</span><b>Основной документ</b><em>Открыть →</em></a><a><span>PDF</span><b>Дополнительные материалы</b><em>Открыть →</em></a></div></section>
@endif
@endsection