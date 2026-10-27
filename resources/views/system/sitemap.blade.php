@extends('layouts.app')
@section('title','Карта сайта — ЧМУ')
@section('content')
<section class="system-hero"><p class="eyebrow">Навигация</p><h1>Карта сайта</h1><p>Все основные публичные разделы училища.</p></section>
<section class="block sitemap-grid">
@foreach([
'Училище'=>[['Об училище','/about'],['Преподаватели','/teachers'],['Отделения','/departments'],['Коллективы','/collectives'],['Контакты','/contacts']],
'Учёба'=>[['Абитуриенту','/applicants'],['Студенту','/students'],['ДШИ','/dshi'],['Дополнительное образование','/additional-education'],['Общежитие','/dormitory']],
'События и творчество'=>[['Пресс-центр','/press'],['Афиша','/events'],['Конкурсы','/competitions'],['Наука и проекты','/science'],['Медиатека','/media'],['Лауреаты','/achievements']],
'Официально'=>[['Сведения об образовательной организации','/official'],['Безопасность','/safety'],['Работникам','/employees'],['Нас благодарят','/gratitudes']]
] as $group=>$links)<div><h2>{{$group}}</h2>@foreach($links as $link)<a href="{{$link[1]}}">{{$link[0]}} <span>→</span></a>@endforeach</div>@endforeach
</section>
@endsection