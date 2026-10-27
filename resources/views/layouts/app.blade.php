<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title','Чебоксарское музыкальное училище им. Ф. П. Павлова')</title>
@vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<header class="site-header">
<a class="brand" href="{{ route('home') }}"><span class="brand-mark">ЧМУ</span><span>Чебоксарское музыкальное училище<br><small>им. Ф. П. Павлова</small></span></a>
<nav>
<a href="{{ route('departments.index') }}">Отделения</a><a href="{{ route('applicants') }}">Абитуриенту</a>
<a href="{{ route('students') }}">Студенту</a><a href="{{ route('events.index') }}">Афиша</a>
<a href="{{ route('news.index') }}">Новости</a><a href="{{ route('official') }}">Сведения</a>
</nav><button class="menu-toggle" aria-label="Меню">☰</button>
</header>
<main>@yield('content')</main>
<footer>БПОУ «Чебоксарское музыкальное училище им. Ф. П. Павлова»</footer>
</body></html>