<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title','Чебоксарское музыкальное училище им. Ф. П. Павлова')</title>
@vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<header class="site-header">
<a class="brand" href="{{ route('home') }}"><span class="brand-mark"><i>ЧМУ</i></span><span>Чебоксарское музыкальное училище<br><small>им. Ф. П. Павлова</small></span></a>
<nav class="desktop-nav">
<div><a href="/about">Об училище</a><a href="/departments">Отделения</a><a href="/education">Образование</a><a href="/collectives">Коллективы</a><a href="/applicants">Абитуриенту</a><a href="/students">Студенту</a><a href="/student-life">Студжизнь</a><a href="/schedule">Расписание</a><a href="/dshi">ДШИ</a></div>
<div><a href="/press">Пресс-центр</a><a href="/events">Афиша</a><a href="/competitions">Конкурсы</a><a href="/science">Наука</a><a href="/media">Медиа</a><a href="/official">Сведения</a><a href="/contacts">Контакты</a></div>
</nav>
<div class="header-tools"><a href="/search" aria-label="Поиск">⌕</a><button class="vision-toggle" aria-label="Версия для слабовидящих">◐</button><button class="menu-toggle" aria-label="Меню">☰</button></div>
</header>
<div class="mobile-menu" aria-hidden="true">
<div class="mobile-menu-head"><b>Меню</b><button class="menu-close" aria-label="Закрыть">×</button></div>
<nav><a href="/about">Об училище</a><a href="/departments">Отделения</a><a href="/education">Образование</a><a href="/collectives">Творческие коллективы</a><a href="/applicants">Абитуриенту</a><a href="/students">Студенту</a><a href="/student-life">Студенческая жизнь</a><a href="/schedule">Расписание</a><a href="/dshi">ДШИ</a><a href="/additional-education">Дополнительное образование</a><a href="/press">Пресс-центр</a><a href="/events">Афиша</a><a href="/competitions">Конкурсы</a><a href="/science">Наука и проекты</a><a href="/dormitory">Общежитие</a><a href="/media">Медиатека</a><a href="/official">Сведения об образовательной организации</a><a href="/safety">Безопасность</a><a href="/employees">Работникам</a><a href="/contacts">Контакты</a></nav>
<div class="mobile-menu-tools"><a href="/search">⌕ Поиск</a><a href="/sitemap">Карта сайта</a></div>
</div>
<main>@yield('content')</main>
<footer class="site-footer"><div><b>Чебоксарское музыкальное училище</b><span> им. Ф. П. Павлова</span></div><nav><a href="/sitemap">Карта сайта</a><a href="/privacy">Персональные данные</a><a href="/cookies">Cookie</a><a href="/contacts">Контакты</a></nav></footer>
<div class="cookie-banner" hidden><p><b>Cookie и персональные данные</b><br>Используем необходимые cookie для работы сайта.</p><div><a href="/cookies">Подробнее</a><button class="cookie-accept">Принять</button></div></div>
</body></html>