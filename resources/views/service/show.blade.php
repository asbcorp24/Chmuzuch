@extends('layouts.app')
@section('title',$page['title'].' — ЧМУ')
@section('content')
<section class="service-detail-hero"><div><a href="/{{$portal==='safety'?'safety':'employees'}}" class="backlink">← {{$portal==='safety'?'Безопасность':'Работникам'}}</a><p class="eyebrow">{{$portal==='safety'?'Безопасная среда':'Для сотрудников'}}</p><h1>{{$page['title']}}</h1><p>{{$page['lead']}}</p></div><div class="service-detail-symbol">{{$page['icon']}}</div></section>
@if($slug==='special-archive')
<section class="block"><p class="eyebrow">Архив</p><h2>Специальные материалы</h2><div class="year-archive"><a><b>COVID-19</b><span>Коронавирус: памятки, документы и архивные материалы</span><i>→</i></a><a><b>Архив</b><span>Другие временные информационные материалы</span><i>→</i></a></div></section>
@elseif($slug==='internal')
<section class="block"><p class="eyebrow">Авторизованный доступ</p><h2>Внутренние ресурсы</h2><div class="internal-links"><a><span>↗</span><b>Рабочая система</b><small>Требуется вход</small></a><a><span>↗</span><b>Внутренние документы</b><small>Требуется вход</small></a><a><span>↗</span><b>Сервисы сотрудников</b><small>Требуется вход</small></a></div></section>
@else
<section class="block split"><div><p class="eyebrow">Информация</p><h2>{{$page['title']}}</h2></div><div><p>{{$page['lead']}}</p><p>Раздел поддерживает текстовые материалы, инструкции, ссылки, контакты, изображения, видео и вложенные документы.</p></div></section>
<section class="block"><p class="eyebrow">Материалы</p><h2>Документы и памятки</h2><div class="document-list"><a><span>PDF</span><b>Основной документ</b><em>Открыть →</em></a><a><span>PDF</span><b>Памятка / инструкция</b><em>Открыть →</em></a><a><span>DOC</span><b>Дополнительные материалы</b><em>Скачать →</em></a></div></section>
@endif
@endsection