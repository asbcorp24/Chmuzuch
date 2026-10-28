@extends('layouts.admin')
@section('title','Настройки сайта — CMS ЧМУ')
@section('content')
<form method="POST" action="{{route('admin.settings.save')}}">@csrf<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Системные настройки</small><h1>Настройки сайта</h1></div><button class="admin-primary">Сохранить</button></header>
@if(session('success'))<div class="admin-flash">{{session('success')}}</div>@endif
<nav class="settings-section-nav"><a href="#settings-seo">SEO и поисковые системы</a><a href="#settings-general">Сайт</a><a href="#settings-appearance">Оформление</a><a href="#settings-contacts">Контакты</a></nav>
<div class="settings-grid">
@foreach($fields as $group=>$keys)<section class="settings-card" id="settings-{{$group}}"><h2>{{['general'=>'Сайт','contacts'=>'Контакты','social'=>'Социальные сети','seo'=>'SEO и поисковые системы','appearance'=>'Оформление и 3D','privacy'=>'Cookie и персональные данные','footer'=>'Подвал'][$group]??$group}}</h2>
@foreach($keys as $key)<label><span>{{['default_title'=>'Заголовок сайта (Title)','default_description'=>'Описание сайта (Description)','site_url'=>'Основной адрес сайта (https://...)','robots'=>'Индексация (index,follow или noindex,nofollow)','og_image'=>'Изображение для социальных сетей (URL)','og_site_name'=>'Название сайта для социальных сетей','twitter_card'=>'Тип карточки (summary_large_image или summary)','yandex_verification'=>'Код подтверждения Яндекс Вебмастера','google_verification'=>'Код подтверждения Google Search Console'][$key]??$key}}</span>@if(in_array($key,['tagline','default_description','cookie_text','footer_text']))<textarea name="{{$group}}[{{$key}}]" rows="3">{{data_get($settings,$group.'.'.$key)}}</textarea>@else<input name="{{$group}}[{{$key}}]" value="{{data_get($settings,$group.'.'.$key)}}">@endif</label>@endforeach
@if($group==='seo')<small>Настройки применяются к публичным страницам. Индивидуальные SEO-заголовки и описания страниц имеют приоритет.</small>@endif</section>@endforeach
</div></form>
@endsection