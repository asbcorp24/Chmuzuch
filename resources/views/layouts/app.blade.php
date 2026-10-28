<!doctype html>
<html lang="ru" data-accent="{{data_get($siteSettings,'appearance.accent')}}" data-ornament="{{data_get($siteSettings,'appearance.ornament')}}">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
@php($siteName=data_get($siteSettings,'general.site_name','Чебоксарское музыкальное училище им. Ф. П. Павлова'))
<title>@yield('title',data_get($siteSettings,'seo.default_title',$siteName))</title>
<meta name="description" content="@yield('meta_description',data_get($siteSettings,'seo.default_description',data_get($siteSettings,'general.tagline','')))">
@if(data_get($siteSettings,'general.favicon'))<link rel="icon" href="{{data_get($siteSettings,'general.favicon')}}">@endif
<link rel="manifest" href="/manifest.webmanifest">
<link rel="icon" type="image/svg+xml" href="/pwa-icon.svg">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="theme-color" content="{{data_get($siteSettings,'appearance.accent','#8d1f2d')}}">
<script>window.CHMUZUCH=@json(['appearance'=>data_get($siteSettings,'appearance',[])]);</script>
@vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<a class="skip-link" href="#main-content">Перейти к содержимому</a>
<header class="site-header">
<a class="brand" href="{{route('home')}}">@if(data_get($siteSettings,'general.logo'))<img class="brand-logo" src="{{data_get($siteSettings,'general.logo')}}" alt="{{$siteName}}">@else<span class="brand-mark"><i>{{data_get($siteSettings,'general.short_name','ЧМУ')}}</i></span>@endif<span>{{$siteName}}@if(data_get($siteSettings,'general.tagline'))<br><small>{{data_get($siteSettings,'general.tagline')}}</small>@endif</span></a>
<nav class="desktop-nav"><div>@foreach($siteNavigation->where('location','header')->whereNull('parent_id') as $item)<span class="nav-group"><a href="{{ $item->url }}">{{ $item->label }}</a>@if($siteNavigation->where('parent_id',$item->id)->isNotEmpty())<span class="nav-submenu">@foreach($siteNavigation->where('parent_id',$item->id) as $child)<a href="{{ $child->url }}">{{ $child->label }}</a>@endforeach</span>@endif</span>@endforeach</div></nav>
<div class="header-tools"><a href="/search" aria-label="Поиск">⌕</a><button class="vision-toggle" type="button" aria-label="Версия для слабовидящих">◐</button><button class="menu-toggle" type="button" aria-label="Открыть меню" aria-expanded="false" aria-controls="site-mobile-menu">☰</button></div>
</header>
<div id="site-mobile-menu" class="mobile-menu" aria-hidden="true"><div class="mobile-menu-head"><b>Меню</b><button class="menu-close" type="button" aria-label="Закрыть меню">×</button></div><nav>@foreach($siteNavigation->where('location','header')->whereNull('parent_id') as $item)<a href="{{ $item->url }}">{{ $item->label }}</a>@foreach($siteNavigation->where('parent_id',$item->id) as $child)<a class="mobile-submenu-link" href="{{ $child->url }}">{{ $child->label }}</a>@endforeach @endforeach</nav><div class="mobile-menu-tools"><a href="/search">⌕ Поиск</a><a href="/sitemap">Карта сайта</a></div></div>
<main id="main-content" tabindex="-1">@yield('content')</main>
@include('public.music-player')
<footer class="site-footer"><div><b>{{$siteName}}</b>@if(data_get($siteSettings,'footer.footer_text'))<span> {{data_get($siteSettings,'footer.footer_text')}}</span>@endif</div><nav>@foreach(['vk'=>'VK','telegram'=>'Telegram','rutube'=>'Rutube'] as $key=>$label)@if(data_get($siteSettings,'social.'.$key))<a href="{{data_get($siteSettings,'social.'.$key)}}" target="_blank" rel="noopener">{{$label}}</a>@endif @endforeach@foreach($siteNavigation->where('location','footer')->whereNull('parent_id') as $item)<a href="{{$item->url}}">{{$item->label}}</a>@endforeach<a href="/sitemap">Карта сайта</a><a href="{{data_get($siteSettings,'privacy.personal_data_url','/privacy')}}">Персональные данные</a><a href="{{data_get($siteSettings,'privacy.privacy_url','/privacy')}}">Политика</a><a href="/contacts">Контакты</a></nav><small>{{data_get($siteSettings,'footer.copyright')}}</small></footer>
<div class="cookie-banner" hidden><p><b>Cookie и персональные данные</b><br>{{data_get($siteSettings,'privacy.cookie_text','Используем необходимые cookie для работы сайта.')}}</p><div><a href="{{data_get($siteSettings,'privacy.privacy_url','/cookies')}}">Подробнее</a><button class="cookie-accept">Принять</button></div></div>
</body></html>